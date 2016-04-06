<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hw extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('goal_model');
        $this->load->helper('email');
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 302);
        }
        
        if (!valid_email($this->session->userdata('email')))
            redirect(site_url('user/profile'), 'location', 302);
        if (ENVIRONMENT == 'development') {
           $this->output->enable_profiler(TRUE);
        }
    }
    
    function index()
    {
        $post = $this->input->post();
       
        if ($post != '') {
            $status = $post['status'];
            $since = $post['since'];
            $formatted_since = date('Y-m-d', strtotime($since." ".date('Y')));
        }else{
            $status = "2";
            $time = "01-01-".date('Y');
            $formatted_since = date('Y-m-d', strtotime($time));
            $since = date('M j', strtotime($time));
        }
        
        $downloads = $this->wellness->downloads();
        $consistency_board = $this->wellness->consistency_board();
        $recentgoals = $this->goal_model->get_public_goals($status,$formatted_since);
        $accordion = $this->wellness->goal_accordion($recentgoals,false,false);
        $activity_log_table = $this->wellness->activity_log_table($this->session->userdata('idusers'),date('Y'),'1','','',false,10);
        $topright = $this->goal_model->get_content('top-right');
        
        $data = array(
                    'title'         => $this->lang->line('hw_hw').$this->lang->line('hw_site_title'),
                    'jsFile'        => array('wellness'),
                    'consistency_board'   => $consistency_board,
                    'recentgoals'   => $accordion,
                    'activity_log_table' => $activity_log_table,
                    'topright'      => $topright,
                    'cssFile'       => array('wellness'),
                    'status'        => $status,
                    'downloads'     => $downloads,
                    'since'         => $since
                );

        $page = array(
            'data' => $data,
            'content' => 'hw/index'
        );

        $this->load->view('bootstrap',$page);
    }
    
    public function add_goal() {
        $this->form_validation->set_rules('name', 'Goal name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('progress', 'Progress', 'required');
        $this->form_validation->set_rules('start_date', 'Start date', 'required');
        $this->form_validation->set_rules('end_date', 'End date', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data = array(
                    'title'         => $this->lang->line('hw_add_goal').$this->lang->line('hw_site_title'),
                    'cssFile'       => array('wellness'),
                    'jsFile'        => array('wellness')
                );
            if ($this->session->flashdata('msg') != ''){
                $data['msg'] = $this->session->flashdata('msg');
            }
            $page = array(
                'data'      => $data,
                'content'   => 'hw/add_goal'
            );
            $this->load->view('bootstrap',$page);   
        }else{
            $post = $this->input->post();
            
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
                
                $this->session->set_flashdata('msg',$this->lang->line('hw_new_goal'));
                $this->session->set_flashdata('goal_id',$result);
                
                
                $user_info = $this->goal_model->get_user(NULL,$post['idusers']);
                $recipient = $user_info[0]['email'];
                
                $subject = $this->lang->line('hw_nav_goal').": {$post['name']}";
                
                $data['full_name'] = $user_info[0]['cn'];
                $data['lead'] =  $this->lang->line('hw_new_goal');
                $data['sub_lead'] = $anonymous;
                $data['message'] = '';
                
                $data['rows'] = array(
                    $this->lang->line('hw_status') => $post['status'],
                    $this->lang->line('hw_add_goal_start') => $post['start_date'],
                    $this->lang->line('hw_add_goal_end') => $post['end_date'],
                    $this->lang->line('hw_description') => $post['description'],
                    $this->lang->line('hw_add_goal_t1') => $post['tier1'],
                    $this->lang->line('hw_add_goal_t2') => $post['tier2'],
                    $this->lang->line('hw_add_goal_t3') => $post['tier3'],
                    $this->lang->line('hw_progress') => $post['progress'],
                    $this->lang->line('hw_proof') => $post['prove']
                );
                
                $msg = $this->load->view('templates/email', $data, true);
                
                $this->wellness->email($recipient, $subject, $msg);
                redirect(current_url());

            }else{

                $data = array(
                        'title'         => $this->lang->line('hw_add_goal').$this->lang->line('hw_site_title'),
                        'cssFile'       => array('wellness'),
                        'jsFile'        => array('wellness'),
                        'error'         => $this->lang->line('hw_error_add_goal')
                    );
                $page = array(
                    'data' => $data,
                    'content' => 'hw/add_goal'
                );
                $this->load->view('bootstrap',$page);
            }
        }
    }
    
    public function report() {
        $this->load->model('report_model');
        
        $jsFiles = array('wellness',
                        'highcharts/js/highcharts',
                        'highcharts/js/themes/gray',
                        'highcharts/js/modules/drilldown',
                        'highcharts/reports/public-bar'
        );
        $chart_data = $this->report_model->get_public_column_js_array();
        
        $data = array(
            'title'         => $this->lang->line('hw_page_report').$this->lang->line('hw_site_title'),
            'jsFile'        => $jsFiles,
            'cssFile'       => array('wellness')
        );
        
        $data['jsVar'] = array(
            'ytd_months' => $this->report_model->get_ytd_months_js_array(),
            'month_view' => $chart_data['month'],
            'year_view'  => $chart_data['year'],
            'points_goal' => $this->config->item('hw_consistency_goal')
        );
 
        $page = array(
            'data' => $data,
            'content' => 'hw/reports'
        );

        $this->load->view('bootstrap',$page);
    }  
}