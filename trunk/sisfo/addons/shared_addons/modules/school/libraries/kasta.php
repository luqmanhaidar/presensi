<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kasta {
    private $CI;
    private $options = array();
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('schoptions_m','opt');
        
        foreach ($this->CI->opt->get_all() as $opt) {
            $this->options[$opt->option_name] = $opt->value;
        }
        
    }
    
    public function position() {
        switch ($this->CI->session->userdata('group_id')) {
            case ($this->options['student_group_id']):
                return 'student';
                break;
            
            case ($this->options['teacher_group_id']):
                return 'teacher';
                break;
                
            case ($this->options['admin_group_id']):
                return 'admin';
                break;
                
            case ('1'):
                return 'super';
                break;
            
            default :
                return 'unknown';
                break;
        }
    }
    
    public function is_mine($id = 0) {
        $is_mine = false;
        if ($id == $this->CI->session->userdata('user_id')) {
            $is_mine = true;
        }
        return $is_mine;
    }
    
    public function role($id = 0) {
    	$permision = false;
    	if ($this->is_mine($id)) {
    		$permision = true;
    	}
    	if ($this->position() == 'admin' || $this->position() == 'super') {
    		$permision = true;
    	}
    	return $permision;
    }
    
    public function is_admin() {
    	$is_admin = false;
    	if($this->position() == 'super' || $this->position() == 'admin') {
    		$is_admin = true;
    	}
    	return $is_admin;
    }
}

?>