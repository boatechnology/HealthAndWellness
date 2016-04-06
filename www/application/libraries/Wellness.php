<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wellness {
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    public function consistency_board() {
        $data['points'] = $this->CI->goal_model->get_consistency_board();
        $table = '<div class="table-responsive boa">';
        if (count($data['points']) > 0) {
            $table .= $this->CI->load->view('templates/consistency_board_table', $data, true);
        }else{
            $table = "<p>".$this->CI->lang->line('hw_consistency')."</p>";
        }
        $table .= "</div>";
        return $table;
    }
    
    public function activity_log_table_row($a='', $v=NULL, $manager=NULL) {
        if (!isset($v)) {            
            $b = $this->CI->goal_model->get_activity_log('', '', '', '','','', $a['idactivity_log']);
            $a = $b->result_array();
            $v = $a[0];
        }
        if (!isset($v['manager']) && !isset($manager)) {
            $v['manager'] = false;
        }
        
        $row = $this->CI->load->view('templates/activity_log_table_row', $v, true);

        return $row;
    }
    
    public function activity_log_table($idusers='',$date='',$approved='1',$class='', $activity='', $manager=false, $limit=11) {
        $activities = $this->CI->goal_model->get_activity_log($idusers, $date, $approved, $class, $activity, $limit);
        
        if (!is_object($activities)) {
            if ($activities != '') {
                return "Error: ".$activities;
            }else{
                return '';
            }
        }else{
            $data['rows'] = $activities->result_array();
            $data['manager'] = $manager;
                $table = $this->CI->load->view('templates/activity_log_table', $data, true);
        }
        
        return $table;
    }
    
    public function goal_accordion($goals, $manager=false, $allow_edit=false) {
        $data['status_array'] = $this->CI->goal_model->get_status_jsarray();
        $data['goals'] = $goals;
        $data['manager'] = $manager;
        $data['allow_edit'] = $allow_edit;
        
        $accordion = $this->CI->load->view('templates/goal_accordion', $data, true);
        
        return $accordion;
    }
    
    public function activities_dropdown($class=NULL,$active='') {
        return form_dropdown(
                'idactivities',
                $this->CI->goal_model->get_activities_array($class),
                $active,
                'class="form-control lighter" data-name="activity"',
                $this->CI->lang->line('hw_activity')."..."
        );
    }
    
    public function activity_class_dropdown($active='') {
        return form_dropdown(
                'class',
                $this->CI->goal_model->get_activity_class_array(),
                $active,
                'id="activity_classes" class="form-control lighter" ',
                $this->CI->lang->line('hw_activity_class')."..."
        );
    }
    
    public function downloads() {
        if ($handle = opendir('assets/files')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $files[] = "$entry";
                }
            }
            closedir($handle);
        }
        if (is_array($files)) {
            foreach($files as $key=>$value) {
                $names = preg_split('[\.]',$value);
                $split = preg_split('{---}',$names[0]);
                $myfiles[] = array('name' => $split[0], 'link' => $value);
            }
        }
        $html = '';
        if (is_array($myfiles)) {
            foreach($myfiles as $value) {
                $html .= "<p><a href='/assets/files/".$value['link']."'>".$value['name']."</a></p>";
            }
            return $html;
        }
        return false;
    }
    
    public function email($recipient, $subject, $message, $debug=false) {
        $config = array(
            'mailtype' => 'html'
        );
        $this->CI->email->initialize($config);
        
        $this->CI->email->from($this->CI->config->item('hw_from_email'), $this->CI->config->item('hw_from_email_name'));
        $this->CI->email->to($recipient);
        $this->CI->email->subject($subject);
        $this->CI->email->message($message);
        $emailed = $this->CI->email->send();
        if ($debug) {
            log_message('debug', $this->CI->email->print_debugger()); 
        }
        
        return $emailed;
    }
}