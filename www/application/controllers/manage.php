<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('goal_model');
        $this->load->helper('url');
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 302);
        }
        if ($this->session->userdata('isadmin') != '1'){
            show_error($this->lang->line('hw_unauthorized'));
        }
        if (ENVIRONMENT == 'development') {
           $this->output->enable_profiler(TRUE);
        }
    }
    
    public function add_goal() {
        $post = $this->input->post();
        
        $this->form_validation->set_rules('name', 'Goal name', 'required');
        $this->form_validation->set_rules('idusers', 'User', 'required');
        $this->form_validation->set_rules('start_date', 'Start date', 'required');
        $this->form_validation->set_rules('end_date', 'End date', 'required');
        if(isset($post['idusers']) && $post['idusers'] != '')
            $idusers = $post['idusers'];
        else
            $idusers = NULL;
        $status = (isset($status)) ? $status : "1";
        
        if ($this->form_validation->run() === FALSE) {
            $users_dropdown = form_dropdown('idusers',$this->goal_model->get_users_array(),$idusers,'id="idusers" class="form-control" style="max-width: 200px;"','None');
            $status_dropdown = form_dropdown('status',$this->goal_model->get_status_array(),$post['status'],'id="status" class="form-control" style="max-width: 200px;"');
            
            $data = array(
                    'title'         => $this->lang->line('hw_add_goal').$this->config->item('hw_site_title'),
                    'users_dropdown'=> $users_dropdown,
                    'status_dropdown'=> $status_dropdown,
                    'cssFile'       => array('wellness'),
                    'jsFile'        => array('wellness')
                );
            if ($this->session->flashdata('msg') != ''){
                $data['msg'] = $this->session->flashdata('msg');
            }
            $page = array(
                'data'      => $data,
                'content'   => 'manage/add_goal'
            );
            $this->load->view('bootstrap',$page);   
        }else{
            
            if ($this->input->post() == '') {
                $post = $this->input->get();
            }else{
                $post = $this->input->post();
            }
            if (isset($post['public'])) {
                $post['public'] = $post['public'] == 'on' ? "1" : '';
            }
            if (isset($post['anonymous'])) {
                $post['anonymous'] = $post['anonymous'] == 'on' ? "1" : '';
            }
            $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
            $post['end_date'] = date('Y-m-d', strtotime($post['end_date']));
            
            if (isset($post['public']) && ($post['public'] == '1' || $post['public'] == 'on')){
                $post['public'] = 1;
                $anonymous = $this->lang->line('hw_public_goal');   
                if (isset($post['anonymous']) && ($post['anonymous'] == '1' || $post['anonymous'] == 'on')){
                    $post['anonymous'] = 1;
                    $anonymous = $this->lang->line('hw_anonymous_public_goal');
                }
            }else{
                $anonymous = $this->lang->line('hw_private_goal');
            }
            
            $post['timestamp'] = date("Y-m-d H:i:s");
            $post['status'] = "1";

            $result = $this->goal_model->add($post);
            if (is_numeric($result) && $result > 0) {
                
                $user_info = $this->goal_model->get_user(NULL,$post['idusers']);
                $status = $this->goal_model->get_status($post['status']);
                $post['status'] = $status[0]['name'];
                $recipient = $user_info[0]['email'];
                
                $subject = $this->lang->line('hw_nav_goal').": {$post['name']}";
                
                $data['full_name'] = $user_info[0]['cn'];
                $data['lead'] =  $this->lang->line('hw_new_goal');
                $data['sub_lead'] = $anonymous;
                $data['message'] = '';
                
                $data['rows'] = array(
                    $this->lang->line('hw_status')          => $post['status'],
                    $this->lang->line('hw_add_goal_start')  => $post['start_date'],
                    $this->lang->line('hw_add_goal_end')    => $post['end_date'],
                    $this->lang->line('hw_comments')        => $post['notes'],
                    $this->lang->line('hw_description')     => $post['description'],
                    $this->lang->line('hw_add_goal_t1')     => $post['tier1'],
                    $this->lang->line('hw_add_goal_t2')     => $post['tier2'],
                    $this->lang->line('hw_add_goal_t3')     => $post['tier3'],
                    $this->lang->line('hw_progress')        => $post['progress'],
                    $this->lang->line('hw_proof')           => $post['prove']
                );
                
                $msg = $this->load->view('templates/email', $data, true);
                
                $this->wellness->email($recipient, $subject, $msg);
                
                $this->session->set_flashdata('msg',$this->lang->line('hw_new_goal'));
                $this->session->set_flashdata('goal_id',$result);
                
                redirect(current_url());
            }else{                
                $data = array(
                        'title'         => $this->lang->line('hw_add_goal').$this->config->item('hw_site_title'),
                        'cssFile'       => array('wellness'),
                        'jsFile'        => array('wellness'),
                        'error'         => $this->lang->line('hw_error_add_goal')
                    );
                $page = array(
                    'data' => $data,
                    'content' => 'manage/add_goal'
                );
                $this->load->view('bootstrap',$page);
            }
        }
    }
    
    public function goals() {
        $post = $this->input->post();
       
        if ($post != '') {
            $status = $post['status'];
            $since = $post['since'];
            $formatted_since = date('Y-m-d', strtotime($since." ".date('Y')));
        }else{
            $formatted_since = date('Y-m-d');
            $since = date('M j', strtotime($formatted_since));
        }
        
        $status = (isset($status)) ? $status : "1";
        
        if(isset($post['sort']) && $post['sort'] == 'user')
            $sort = 'user';
        else
            $sort = 'date';
        if(isset($post['idusers']) && $post['idusers'] != '')
            $idusers = $post['idusers'];
        else
            $idusers = NULL;
        
        $users_dropdown = form_dropdown('idusers',$this->goal_model->get_users_array(),$post['idusers'],'id="idusers" class="form-control" style="max-width: 200px;"','All Users');
        $status_dropdown = form_dropdown('status',$this->goal_model->get_status_array(),$post['status'],'id="status" class="form-control" style="max-width: 200px;"');
        $mygoals = $this->goal_model->get_goals($status,$formatted_since,$idusers,$sort,NULL);
        $accordion = $this->wellness->goal_accordion($mygoals,true,true);
        
        $data = array(
            'title'         => $this->lang->line('hw_page_manage_goal').$this->config->item('hw_site_title'),
            'mygoals'       => $accordion,
            'status_dropdown'=> $status_dropdown,
            'since'         => $since,
            'users_dropdown'=> $users_dropdown,
            'sort'          => $sort,
            'jsFile'        => array('wellness'),
            'cssFile'       => array('wellness')
        );

        $page = array(
            'data' => $data,
            'content' => 'manage/goals'
        );

        $this->load->view('bootstrap',$page);
    }
    
    public function activity_log() {
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 302);
        }
        $post = $this->input->post();
       
        if ($post != '') {
            $date = $post['date'];
            $formatted_date = date('Y-m-d', strtotime($date." ".date('Y')));
            
        }else{
            $formatted_date = date('Y-m-d');
            $date = date('M j', strtotime($formatted_date));
        }
        
        $approval = (isset($post['approval']) && $post['approval'] != '') ? $post['approval'] : '1';
        $idactivity = $this->input->post('idactivities');
        
        # if a class is selected, make sure to only select activity from same class
        if ($this->input->post('class') != '') {
            if ($this->input->post('idactivities') != '') {
                $activitydetail = $this->goal_model->get_activity($this->input->post('idactivities'));
                if ($activitydetail[0]['class'] != $this->input->post('class')) {
                    $idactivity = '';
                }
            }
        }
        
        $users_dropdown = form_dropdown('idusers',$this->goal_model->get_users_array(),$post['idusers'],'id="idusers" class="form-control"','All Users');
        $status_dropdown = $this->goal_model->get_activity_status_dropdown($post['approval']);
        $activity_table = $this->wellness->activity_log_table(
                $this->input->post('idusers'),
                $formatted_date,
                $approval,
                $this->input->post('class'),
                $idactivity,
                true,
                ''
        );
        $activity_dropdown = $this->wellness->activities_dropdown(
                $this->input->post('class'),
                $idactivity
        );
        $activity_class_dropdown = $this->wellness->activity_class_dropdown(
                $this->input->post('class')
        );
        
        # did we get an error back
        if (substr($activity_table, 0, 5) === 'Error') {
            $error = $activity_table;
        }
        
        $data = array(
                'title'         => $this->lang->line('hw_manage_activity_logs').$this->config->item('hw_site_title'),
                'users_dropdown'=> $users_dropdown,
                'status_dropdown'=> $status_dropdown,
                'activity_table'=> $activity_table,
                'activity_dropdown' => $activity_dropdown,
                'activity_class_dropdown' => $activity_class_dropdown,
                'cssFile'       => array('wellness'),
                'formatted_date'=> $formatted_date,
                'date'          => $date,
                'jsFile'        => array('wellness')
            );
        if (isset($error) && $error != '0')
            $data['error'] = $error;
        
        $page = array(
            'data' => $data,
            'content' => 'manage/activities'
        );
        $this->load->view('bootstrap',$page);
    }
    
    public function activities() {
        
        $data = array(
            'title'         => $this->lang->line('hw_page_activities').$this->config->item('hw_site_title'),
            'cssFile'   => array('wellness'),
            'jsFile'    => array('wellness')
          );
        $page = array(
            'data' => $data,
            'content' => 'manage/activities'
        );

        $this->load->view('bootstrap',$page);
    }
    
    public function data() {
        
        $data = array(
            'title'         => $this->lang->line('hw_page_manage_user').$this->config->item('hw_site_title'),
            'cssFile'   => array('wellness'),
            'jsFile'    => array('wellness')
          );
        $page = array(
            'data' => $data,
            'content' => 'manage/data'
        );

        $this->load->view('bootstrap',$page);
    }
}