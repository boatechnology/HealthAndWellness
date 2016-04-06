<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('goal_model');
        
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE);
        }
    }
    
    public function login() {
        $this->load->library('Auth_Ldap');
        if ($this->session->userdata('logged_in') == '1'){
            redirect(site_url(''), 'location', 302);
        }
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $error = validation_errors();
            $data = array(
                    'title'         => $this->lang->line('hw_sign_in').$this->config->item('hw_site_title'),
                    'cssFile'       => array('wellness'),
                    'login_error'   => $error
                );

            $page = array(
                'data' => $data,
                'nonav' => true,
                'content' => 'user/login'
            );

            $this->load->view('bootstrap',$page);
            
        }else{
            $post = $this->input->post();
            
            if(!$this->auth_ldap->is_authenticated()) {
                // Do the login...
                if($this->auth_ldap->login($post['username'],$post['password'])) {
                    // Login WIN!
                    // Session cookies for filemanager access
                    session_start();
                    $_SESSION['KCFINDER'] = array();
                    $_SESSION['KCFINDER']['disabled'] = false;

                    # if user not in local DB add them
                    if (!$this->goal_model->check_user('username',$this->session->userdata('username'))) {
                        $newuser = array('cn' => $this->session->userdata('cn'),
                                        'email' => $this->session->userdata('email'),
                                        'username' => $this->session->userdata('username')
                                        );

                        $newuser['hwnumber'] = $this->_gen_hw_num();

                        if ($result = $this->goal_model->add_user($newuser)) {
                            foreach($result[0] as $key=>$value) {
                                $userdata[$key] = $value;
                            }
                            $this->session->set_userdata($userdata);
                        }else{
                            show_error($this->lang->line('hw_error_new_user'));
                        }
                        // Send them to profile so they can fill it out
                        redirect(site_url('user/profile'));
                    }else{
                        # user already in DB, update HW number if not valid
                        $result = $this->goal_model->get_user($this->session->userdata('username'));
                        foreach($result[0] as $key=>$value) {
                            $userdata[$key] = $value;
                        }
                        # hwnumbers can be reset so gen one if not present
                        if ($userdata['hwnumber'] < $this->config->item('hw_num_min') || $userdata['hwnumber'] > $this->config->item('hw_num_max')) {
                            $userdata['hwnumber'] = $this->_gen_hw_num();
                            $this->goal_model->update_user($userdata);
                        }
                        $this->session->set_userdata($userdata);
                        redirect(site_url(''));
                    } 
                }else{

                    $error = "<div class='alert alert-danger'>".$this->lang->line('hw_error_failed_login')."</div>";

                    $data = array(
                            'title'         => $this->lang->line('hw_sign_in').$this->config->item('hw_site_title'),
                            'cssFile'       => array('wellness'),
                            'login_error'   => $error
                        );
                    $page = array(
                        'data' => $data,
                        'nonav' => true,
                        'content' => 'user/login'
                    );

                    $this->load->view('bootstrap',$page);
                }

            }else{
                // Already logged in...
                redirect(site_url(''));
            }
        }
    }
    
    public function _gen_hw_num() {
        $numbers = range($this->config->item('hw_num_min'), $this->config->item('hw_num_max'));
        shuffle($numbers);
        foreach($numbers as $value) {
            if (!$this->goal_model->check_id($value)) {
                return $value;                
            }
        }
    }
    
    public function logout(){
        $this->load->helper('url');
        $this->session->sess_destroy();
        redirect(site_url(), 'location', 302);
    }
    
    public function profile() {
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 302);
        }
        
        $this->load->model('report_model');
        $this->config->load('wellness');
        
        $this->form_validation->set_rules('cn', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        
        $data = array(
                    'title'         => $this->lang->line('hw_page_profile').$this->config->item('hw_site_title'),
                    'cssFile'       => array('wellness'),
                    'jsFile'        => array(
                        'wellness',
                        'highcharts/js/highcharts',
                        'highcharts/js/themes/gray',
                        'highcharts/reports/profile-bar'
                        ),
                    
                );
        
        # Go ahead and update user if data is good
        if ($this->form_validation->run() === TRUE) {
            if ($this->input->post() == '') {
                $post = $this->input->get();
            }else{
                $post = $this->input->post();
            }
            $result = $this->goal_model->update_user($post);
            if($result){
                $data['msg'] = $this->lang->line('hw_msg_update_info');
                foreach($result[0] as $key=>$value) {
                    $userdata[$key] = $value;
                }
                $this->session->set_userdata($userdata);
            }else{
                $data['error'] = $this->lang->line('hw_error_update_info');
            }
        }

        $this->load->helper('email');
        if (!valid_email($this->session->userdata('email')))
            $data['error'] = $this->lang->line('hw_msg_add_email');
        
        $ytd_months = $this->report_model->get_ytd_months_js_array();
        
        $monthly_totals = $this->report_model->get_point_monthly_totals_js_array($this->session->userdata('idusers'));
        
        $data['jsVar'] = array(
            'consistency_series' => $monthly_totals,
            'ytd_months' => $ytd_months,
            'points_goal' => $this->config->item('hw_consistency_goal')
        );
        
        $page = array(
            'data' => $data,
            'content' => 'user/profile'
        );

        $this->load->view('bootstrap',$page);
    }
    
    function goals() {
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 302);
        }     
        
        $goal_id = $this->session->flashdata('goal_id');
                
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
        $user = $this->session->all_userdata();
        
        $status_dropdown = form_dropdown('status',$this->goal_model->get_status_array(),$post['status'],'id="status" class="form-control" style="max-width: 200px;"');
        $mygoals = $this->goal_model->get_goals($status,$formatted_since,$user['idusers'],NULL,NULL);
        $accordion = $this->wellness->goal_accordion($mygoals, false, true);
        
        $data = array(
                    'title'         => $this->lang->line('hw_nav_goals').$this->config->item('hw_site_title'),
                    'mygoals'       => $accordion,
                    'status_dropdown'=> $status_dropdown,
                    'since'         => $since,
                    'user'          => $user,
                    'jsFile'        => array('wellness'),
                    'cssFile'       => array('wellness')
                );
        if ($this->session->flashdata('msg') != ''){
            $data['msg'] = $this->session->flashdata('msg');
        }
        
        $page = array(
            'data' => $data,
            'content' => 'user/goals'
        );

        $this->load->view('bootstrap',$page);
    }

    public function activities() {
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 302);
        }
        $post = $this->input->post();

        if ($post != '') {
            $date = $post['date'];
            $formatted_date = date('Y-m-d', strtotime($date." ".date('Y')));

        }else{
            $formatted_date = date('Y-m-d', strtotime("-14 days"));
            $date = date('M j', strtotime($formatted_date));
        }

        $approval = (isset($post['approval']) && $post['approval'] != '') ? $post['approval'] : '1';

        # if a class is selected, make sure to only select activity from same class
        $idactivity = $this->input->post('idactivities');
        if ($this->input->post('class') != '') {
            if ($this->input->post('idactivities') != '') {
                $activitydetail = $this->goal_model->get_activity($this->input->post('idactivities'));
                if ($activitydetail[0]['class'] != $this->input->post('class')) {
                    $idactivity = '';
                }
            }
        }

        $activity_table = $this->wellness->activity_log_table($this->session->userdata('idusers'),$formatted_date,1,$this->input->post('class'),$idactivity,false,'');

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
                'title'         => $this->lang->line('hw_activity_log').$this->config->item('hw_site_title'),
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
            'content' => 'user/activities'
        );
        $this->load->view('bootstrap',$page);
    }
}