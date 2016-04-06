<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in') != '1'){
             $this->output->set_status_header('401');
             echo $this->lang->line('hw_unauthorized');
        }
        $this->load->model('goal_model');
        error_reporting(0);
    }
    
    public function index() {
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 403);
        }
    }

    public function goal() {
        if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }
        
        $data[$post['name']] = $post['value'];
        $data['idgoals'] = $post['pk'];
                
        $msg = $this->goal_model->update_goal($data);
        
        if ($msg === true) {
            $this->_send_ok();
        }else{
            $this->_send_error($this->lang->line('hw_error_update_goal').":\n$msg");
        }

        if ($post['name'] == 'status') {
            $goal = $this->goal_model->get_goal($data['idgoals']);
            $g = $goal[0];
            $user_info = $this->goal_model->get_user(NULL,$g['idusers']);
            $status = $this->goal_model->get_status($g['status']);
            $g['status'] = $status[0]['name'];
            $recipient = $user_info[0]['email'];
            $subject = $this->lang->line('hw_nav_goal').": {$g['name']}";

            $data['full_name'] = $user_info[0]['cn'];
            $data['lead'] =  $this->lang->line('hw_msg_goal_updated');
            $data['sub_lead'] = '';
            $data['message'] = '';

            $data['rows'] = array(
                $this->lang->line('hw_status')          => $g['status'],
                $this->lang->line('hw_add_goal_start')  => $g['start_date'],
                $this->lang->line('hw_add_goal_end')    => $g['end_date'],
                $this->lang->line('hw_points')          => $g['points'],
                $this->lang->line('hw_comments')        => $g['notes'],
                $this->lang->line('hw_description')     => $g['description'],
                $this->lang->line('hw_add_goal_t1')." {$g['t1points']}" => $g['tier1'],
                $this->lang->line('hw_add_goal_t2')." {$g['t2points']}" => $g['tier2'],
                $this->lang->line('hw_add_goal_t3')." {$g['t3points']}" => $g['tier3'],
                $this->lang->line('hw_progress')        => $g['progress'],
                $this->lang->line('hw_proof')           => $g['prove']
            );
            
            $emsg = $this->load->view('templates/email', $data, true);

            $this->wellness->email($recipient, $subject, $emsg);
        }
    }

    public function delete_activity_log() {
        $post = $this->input->post();
        
        $data['idactivity_log'] = $post['id'];
        
        $msg = $this->goal_model->delete_activity_log($data);
        if ($msg === true) {
            $this->output->set_status_header('200');
            echo "1";
        }else{
            $this->output->set_status_header('400');
            echo $this->lang->line('hw_error_delete_activity').":\n$msg";
        }
    }
    public function activity_log() {
        if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }
        
        $data[$post['name']] = $post['value'];
        $data['idactivity_log'] = $post['pk'];
        
        $msg = $this->goal_model->update_activity_log($data);
        if ($msg === true) {
            $this->_send_ok();
        }else{
            $this->_send_error($this->lang->line('hw_error_update_activity').":\n$msg");
        }
    }
    public function get_activity() {
        if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }
        
        $result = $this->goal_model->get_activity($post['idactivity']);
        $this->_send_ok('',json_encode($result[0]));
    }
    
    public function add_activity_log() {
        if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }
        $date = $post['date']." ".date('Y');
        $post['date'] = date('Y-m-d', strtotime($date));
        unset($post['class']);
        $result = $this->goal_model->add_activity_log($post);
        
        if (!array_key_exists('error', $result)) {
            $this->_send_ok('', $this->wellness->activity_log_table_row($result[0]));
        }else{
            $this->_send_error($result['error']);
        }
    }
    
    public function delete_goal() {
        if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }      
        $data['status'] = '6';
        $data['idgoals'] = $post['idgoals'];
        
        $msg = $this->goal_model->update_goal($data);
        if ($msg === true) {
            $this->_send_ok('',$post['idgoals']);
        }else{
            $this->_send_error($msg);
        }
    }
    
    public function add_feedback() {
         if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }
        
        if (isset($post['feedbacker'])){
            $feedback = $this->lang->line('hw_feedback_subject');
        }else {
            $feedback = "{$post['name']}:";
        }
        
        $recipient = $this->config->item('hw_to_email');
        $subject = $this->lang->line('hw_feedback_subject');

        $data['full_name'] = 'H&W Committee';
        $data['lead'] =  '';
        $data['sub_lead'] = $feedback;
        $data['message'] = $post['feedback'];

        $data['rows'] = array(
        );

        $msg = $this->load->view('templates/email', $data, true);
        
        if ($this->wellness->email($recipient, $subject, $msg)) {
            $this->_send_ok();
        }else{
            $this->_send_error();
        }
    }
    
    public function activity_dropdown() {
        if ($this->input->post() == '') {
            $post = $this->input->get();
        }else{
            $post = $this->input->post();
        }
        
        $activity_dropdown = $this->wellness->activities_dropdown(
                $post['class']
        );
        
        $this->_send_ok('', $activity_dropdown);
    }

    function _send_ok($msg=NULL, $data=NULL) {
        $response = array(
            'error' => '0',
            'msg'   => $msg,
            'data'  => $data
        );
        $this->output->set_status_header('200');
        echo json_encode($response);
    }
    
    function _send_error($msg=NULL, $data=NULL) {
        $response = array(
            'error' => '1',
            'msg'   => $msg
        );
        $this->output->set_status_header('400');
        echo json_encode($response);
    }
}