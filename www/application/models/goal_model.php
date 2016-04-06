<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goal_model extends CI_Model {
    
    public function check_user($column, $value) 
    {
        $this->db->where($column, $value);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function check_id($value) 
    {
        $this->db->where('hwnumber', $value);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    
    public function get_user($username=NULL,$idusers=NULL) {
        if (isset($username)) {
            $this->db->where('username', $username);
        }elseif (isset($idusers)) {
            $this->db->where('idusers', $idusers);
        }
        $result = $this->db->get('users');
        return $result->result_array();
    }

    public function get_users_array() {
        
        $users = $this->get_user();
        
        foreach ($users as $value) {
            $u[$value['idusers']] = $value['cn']; 
        }
        natcasesort($u);
        
        return $u;
    }
    
    public function add_user($data) {
        $this->db->insert('users', $data);
        
        $this->db->where('idusers',$this->db->insert_id());
        $result = $this->db->get('users');
        return $result->result_array();
    }
    
    public function update_user($data) {
        $this->db->where('idusers',$data['idusers']);
        if (!$this->db->update('users', $data))
            return false;
        $this->db->where('idusers',$data['idusers']);
        $result = $this->db->get('users');
        return $result->result_array();
    }
    
    public function add($data) {
        $result = $this->db->insert('goals', $data);
        $id = $this->db->insert_id();
        if (is_numeric($id)) {
            return $id;
        }else{
            return "error";
        }
    }
    
    public function get_consistency_board() {
        $this->config->load('wellness');
        
        $query = "call consistency(".$this->config->item('hw_consistency_goal').")";
        
        $result = $this->db->query($query);
        $array = $result->result_array();
        // Need to run this to free up resource for next query
        // see: http://stackoverflow.com/questions/16029729/mysql-error-commands-out-of-sync-you-cant-run-this-command-now
        mysqli_next_result($this->db->conn_id);
        return $array;
    }
    
    public function get_goal($id=Null,$user=NULL,$status=NULL) {
        if (isset($user))
            $this->db->where('idusers', $user);
        if(isset($id))
            $this->db->where('idgoals', $id);
        if(isset($status))
            $this->db->where('status', $status);
        $result = $this->db->get('goals');
        return $result->result_array();
    }
    # TODO: consolodate this and above into one
    public function get_goals($status=NULL,$since=NULL,$idusers=NULL,$sort='date',$id=NULL) {
       
        $goal_html = "<div id='my-goals'>";
        
        $this->db->select('goals.idgoals, goals.start_date, goals.end_date, goals.timestamp,
            goals.public as public, goals.anonymous as anonymous, users.hwnumber as ID, 
            goals.name as name, goals.description as description, users.cn as cn,
            goals.progress, goals.prove, goals.benefit, goals.tier1, goals.status,
            goals.tier2, goals.tier3, goals.notes, goals.points, goals.t1points, goals.t2points, goals.t3points',FALSE);
        $this->db->from('goals');
        $this->db->join('users','goals.idusers=users.idusers');
       
        if (isset($status))
            $this->db->where('goals.status',$status);
        if (isset($since))
            $this->db->where('goals.updated >=',$since);
        if (isset($idusers) && $idusers != '0')
            $this->db->where('goals.idusers',$idusers);
        if (isset($id) && $id != '0')
            $this->db->where('goals.idgoals',$id);
        if ($sort == 'user')
            $this->db->order_by('users.cn', 'ASC');
        else    
            $this->db->order_by('goals.timestamp', 'DESC');
        
        
        $result = $this->db->get();
        
        return $result->result_array();
    }

    public function get_public_goals($status=NULL,$since=NULL) {
        
        $this->db->select('goals.idgoals, goals.start_date, goals.end_date, goals.timestamp,
            goals.public as public, goals.anonymous as anonymous, users.hwnumber as ID, 
            goals.name as name, goals.description as description, users.cn as cn,
            goals.progress, goals.prove, goals.benefit, goals.tier1, goals.status,
            goals.tier2, goals.tier3, goals.notes, goals.points, goals.t1points, goals.t2points, goals.t3points',FALSE);
        $this->db->from('goals');
        $this->db->join('users','goals.idusers=users.idusers');
        if (isset($status))
            $this->db->where('goals.status',$status);
        if (isset($since))
            $this->db->where('goals.updated >=',$since);
        $this->db->where('goals.public','1');
        $this->db->order_by('goals.timestamp', 'DESC');
        
        $result = $this->db->get();
        return $result->result_array();
    }

    public function update_goal($data) {
        
        $this->db->where('idgoals', $data['idgoals']);
        $this->db->update('goals', $data);
        
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return $this->db->_error_message();
        }
    }
    
    public function delete_activity_log($data) {
        
        $this->db->delete('activity_log', $data);
        
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return $this->db->_error_message();
        }
    }
    
    public function update_activity_log($data) {
        
        $this->db->where('idactivity_log', $data['idactivity_log']);
        $this->db->update('activity_log', $data);
        
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return $this->db->_error_message();
        }
    } 
    
    public function add_activity_log($data) {
        $this->db->insert('activity_log',$data);
        
        if ($this->db->affected_rows() > 0) {
            $this->db->where('idactivity_log',$this->db->insert_id());
            $result = $this->db->get('activity_log');
            return $result->result_array();
        }else{
            return array('error' => $this->db->_error_message());
        }
    }
    
    public function get_activity_log($idusers='',$date='',$approved='', $class='', $activity='', $limit='',$id='') {
        
        $this->db->select('activity_log.idactivity_log, activity_log.idusers, activity_log.idactivities,
                            activity_log.date, activity_log.comments,
                            activity_log.points, activity_log.quantity, activity_log.approval,
                            activities.description as name, activities.points as activitypoints, activities.factor, activities.class,
                            activity_classes.name as classname, activities.description as classdescription, 
                            users.cn as username',FALSE);
        $this->db->join('activities','activity_log.idactivities=activities.idactivities');
        $this->db->join('activity_classes','activity_classes.idactivity_classes=activities.class');
        $this->db->join('users','activity_log.idusers=users.idusers');
        if ($idusers != '')
            $this->db->where('activity_log.idusers',$idusers);
        if ($class != '')
            $this->db->where('activity_classes.idactivity_classes',$class);
        if ($activity != '')
            $this->db->where('activity_log.idactivities',$activity);
        if ($id != '')
            $this->db->where('idactivity_log',$id);
        if ($date != '')
            $this->db->where('activity_log.date >=',$date);
        if ($approved != '')
            $this->db->where('activity_log.approval',$approved);
        $this->db->order_by('activity_log.date', 'DESC');
        $this->db->order_by('activity_log.idactivity_log', 'DESC');
        if ($limit != '') {
            $result = $this->db->get('activity_log',$limit);
        }else{
            $result = $this->db->get('activity_log');
        }
        if ($this->db->affected_rows() > 0) {
            return $result;
        }else{
            return $this->db->_error_message();
        }
    }

    public function get_activity($id='') {
        if ($id != '') 
            $this->db->where('idactivities', $id);
        $result = $this->db->get('activities');
        return $result->result_array();
    }

    public function get_content($section) {
        $this->db->where('section', $section);
        $result = $this->db->get('content');
        $array = $result->result_array();
        $html_santized = htmlspecialchars_decode($array[0]['html']);
        return $html_santized;
    }
    
    public function get_status_array() {
        $result = $this->db->get('statuses');
        $results = $result->result_array();
        foreach ($results as $key=>$value) {
            if ($value['isvisible'] == '1')
                $status[$value['idstatus']] = $value['name']; 
        }
        return $status;
    }
    public function get_activity_status_dropdown($active='') {
        $result = $this->db->get('activity_statuses');
        $results = $result->result_array();
        foreach ($results as $key=>$value) {
            if ($value['isvisible'] == '1')
                $status[$value['idactivity_statuses']] = $value['name']; 
        }
        return form_dropdown('approval',$status,$active,'id="approval" class="form-control"');
    }
    public function get_activities_array($class=NULL) {
        if (isset($class))
            $this->db->where('class', $class);
        
        $this->db->order_by('description', 'asc');
        $result = $this->db->get('activities');
        $acts = $result->result_array();
        
        foreach ($acts as $value) {
            if ($value['isvisible'] == '1')
                $activities[$value['idactivities']] = $value['description']; 
        }
        
        return $activities;
    }
    public function get_activity_class_array($active='') {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('activity_classes');
        $results = $result->result_array();
        
        foreach ($results as $key=>$value) {
            if ($value['isvisible'] == '1')
                $activities[$value['idactivity_classes']] = $value['name']; 
        }
        
        return $activities;
    }
    
    public function get_status($id=NULL) {
        if(isset($id))
            $this->db->where('idstatus', $id);
        $result = $this->db->get('statuses');
        return $result->result_array();
    }
    
    public function get_status_jsarray($id=NULL) {
        
        $statuses = $this->get_status($id);
        
        $array = '[';
        foreach($statuses as $k => $v) {
            if ($v['isvisible'] == '1')
                $array .= "{value: {$v['idstatus']}, text: \"{$v['name']}\"},";
        }
        $array = rtrim($array,',');
        $array .= ']';
        return $array;
    }

}