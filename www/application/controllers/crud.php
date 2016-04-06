<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        if ($this->session->userdata('logged_in') != '1'){
             $this->output->set_status_header('401');
             echo "Unauthorized";
             //redirect(site_url());
        }
        error_reporting(0);
    }
    
    public function index() {
        if ($this->session->userdata('logged_in') != '1'){
            redirect(site_url('user/login'), 'location', 403);
        }
        redirect(site_url(''), 'location', 302);
    }
    
    public function sql_backup()
    {
        $this->load->dbutil();
        $this->load->helper('download');
        $this->load->helper('file');
        $prefs = array(                
                'format'      => 'txt',             // gzip, zip, txt
                'ignore'      => 'group',
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
        $backup =& $this->dbutil->backup($prefs);
        $filename = "boa-wellness-sql-backup-".date('m-d-y').".sql";
        write_file("./application/backups/$filename", $backup);
        force_download($filename, $backup);
    }
    
    public function activities() {
        $crud = new grocery_CRUD();
        $crud->set_table('activities');
        $crud->set_relation('class', 'activity_classes', 'name');
        $this->_gen_page($crud);
    }
    
    public function activity_classes() {
        $crud = new grocery_CRUD();
        $crud->set_table('activity_classes');
        
        $this->_gen_page($crud);
    }
    public function activity_log() {
        $crud = new grocery_CRUD();
        $crud->set_table('activity_log');
        $crud->set_relation('approval', 'activity_statuses', 'name');
        $crud->set_relation('idactivities', 'activities', 'description');
        $crud->set_relation('idusers', 'users', 'cn');
        $this->_gen_page($crud);
    }
    public function activity_statuses() {
        $crud = new grocery_CRUD();
        $crud->set_table('activity_statuses');
        $this->_gen_page($crud);
    }
    
    public function users() {
        $crud = new grocery_CRUD();
        $crud->set_table('users');
        
        $this->_gen_page($crud);
    }
    
    public function statuses() {
        $crud = new grocery_CRUD();
        $crud->set_table('statuses');
        $this->_gen_page($crud);
    }
    public function content() {
        $crud = new grocery_CRUD();
        $crud->set_table('content');
        
        $crud->set_theme('twitter-bootstrap');
        $data = $crud->render();
        $page = array(
            'data' => $data,
            'content' => 'crud/template'
        );
        $this->load->view('crud',$page);
    }
    public function goals() {
        $crud = new grocery_CRUD();
        $crud->set_table('goals');
        $crud->set_relation('status', 'statuses', 'name');
        $crud->set_relation('idusers', 'users', 'cn');
        $this->_gen_page($crud);
    }
    
    public function _gen_page($crud) {
        $crud->unset_texteditor('*');
        
        $crud->set_theme('twitter-bootstrap');
        $data = $crud->render();
        $page = array(
            'data' => $data,
            'content' => 'crud/template'
        );
        $this->load->view('crud',$page);
    }    
    
    public function files() {
        $data = array(
            'title'         => 'Manage Downloads'.$this->lang->line('hw_site_title'),
            'jsFile'        => array('wellness'),
            'cssFile'       => array('wellness')
        );

        $page = array(
            'data' => $data,
            'content' => 'manage/files'
        );

        $this->load->view('bootstrap',$page);
    }
}