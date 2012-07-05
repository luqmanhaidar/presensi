<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class School extends Public_Controller
{ 
    public $options = array();
    public $is_student;
    public $is_teacher;
    public $is_admin;
    
    function __construct() {
        parent::Public_Controller();
        $this->load->library('kasta');
        $this->load->model('schoptions_m');
        $this->load->model('school_profiles_m');
        
        foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
        
        $this->is_student = $this->_cek_group('student_group_id');
        $this->is_teacher = $this->_cek_group('teacher_group_id');
        $this->is_admin = $this->_cek_group('admin_group_id');
        
        foreach ($this->session->userdata as $key=>$val) {
        	$this->data->$key = $val;
        }
        
    }
    
    public function index() {
    	if($this->session->userdata('user_id')){
        	redirect ('school/profiles/'.$this->data->user_id);
        }else{
        	redirect ('school/restricted');
        }
    }
    
    public function profiles($id) {
    	if ($id == '1') {
    		echo 'tes';
    	}
    
    	if($this->is_student && $this->uri->segment('3') != $this->data->user_id) {
        	redirect ('school/restricted');
        }
    
    	$this->cache->delete_all('modules_m');
        $this->load->model('school_profiles_m');
        $this->load->model('student_classes_m');
		
		$this->data->myprofiles = $this->student_classes_m->get_my_profile($id);
		$this->data->mysubjects = $this->student_classes_m->get_my_subject($id);
        $this->data->profiles = $this->school_profiles_m->get_by(array('user_id'=>$id));
        $mydata = unserialize(@$this->data->profiles->data);
        
        if (isset($mydata['mypicture'])) {
        	$this->data->picture = '<img src="'.$mydata['mypicture'].'" >';
        }else{
        	$this->data->picture = '<img src="'.base_url().'/uploads/school/picture.png" >';
        }
        
        $this->data->mydata = $mydata;
        
		$this->template->title($this->module_details['name'], 'Halaman Rapor')
                        ->append_metadata( css('school.css', 'school') )
						->append_metadata( css('admin.css', 'school') )
						->build('index', $this->data);
    }
    
    public function edit_profiles($id) {
    	if ($id == '1') {
    		'echo tes';
    	}
    
    	if($this->is_student && $this->uri->segment('3') != $this->data->user_id) {
        	redirect ('school/restricted');
        }
    
    	$this->cache->delete_all('modules_m');
        $this->load->model('school_profiles_m');
        $this->load->model('student_classes_m');
		
		$this->data->myprofiles = $this->student_classes_m->get_my_profile($id);
		$this->data->mysubjects = $this->student_classes_m->get_my_subject($id);
        $this->data->profiles = $this->school_profiles_m->get_by(array('user_id'=>$id));
        $mydata = unserialize(@$this->data->profiles->data);
        
        if (isset($mydata['mypicture'])) {
        	$this->data->picture = '<img src="'.$mydata['mypicture'].'" >';
        }else{
        	$this->data->picture = '<img src="'.base_url().'/uploads/school/picture.png" >';
        }
        
        $this->data->mydata = $mydata;
        
        if($this->input->post('data')) {
            $this->school_profiles_m->insert_profile(array('data'=>serialize($this->input->post('data')),'user_id'=>$id));
            redirect('school/profiles/'.$id);
        }
        
		$this->template->title($this->module_details['name'], 'Halaman Rapor')
                        ->append_metadata( css('school.css', 'school') )
                        ->append_metadata( css('admin.css', 'school') )
						->build('index', $this->data);
    }
    
    public function classes($id) {
    	$this->load->model('student_classes_m');
    	$this->load->model('classes_m');
    	
    	$get_me = $this->student_classes_m->get_by(array('student_id'=>$this->data->user_id));
    	
    	$this->data->mystudent = $this->classes_m->get_my_student($get_me->class_id);
    	$this->template->title($this->module_details['name'], 'Halaman Rapor')
                        ->append_metadata( css('school.css', 'school') )
						->build('index', $this->data);
	}
    
    public function subjects($id) {
    
    }
    
    public function report($id) {
    	if($this->is_student && $this->uri->segment('3') != $this->data->user_id) {
        	redirect ('school/restricted');
        }
    
    	$this->cache->delete_all('modules_m');
        $this->load->model('school_profiles_m');
        $this->load->model('student_classes_m');
		
		$this->data->myprofiles = $this->student_classes_m->get_my_profile($id);
		$this->data->mysubjects = $this->student_classes_m->get_my_subject($id);
        $this->data->profiles = $this->school_profiles_m->get_by(array('user_id'=>$id));
        $mydata = unserialize($this->data->profiles->data);
        
        if (isset($mydata['mypicture'])) {
        	$this->data->picture = '<img src="'.$mydata['mypicture'].'" >';
        }else{
        	$this->data->picture = '<img src="'.base_url().'/uploads/school/picture.png" >';
        }
        
        $this->data->mydata =$mydata;
        
		$this->template->title($this->module_details['name'], 'Halaman Rapor')
                        ->append_metadata( css('school.css', 'school') )
						->build('index', $this->data);
    }
    
    public function class_score($id_cs) {
    	$this->load->model('classes_subjects_m');
    	$this->data->abouts = $this->classes_subjects_m->get_for_score($id_cs);
		$this->data->students = $this->classes_subjects_m->get_student($id_cs);
		$this->cache->delete_all('modules_m');
		
		$mydata = $this->classes_subjects_m->get_by(array('id_cs'=>$id_cs));
		$this->data->mydata = unserialize($mydata->data_cs);
		
		$this->template->title($this->module_details['name'], 'Halaman Rapor')
                        ->append_metadata( css('school.css', 'school') )
						->build('index', $this->data);
    }
    
    public function restricted() {
    	$this->template->title($this->module_details['name'], 'Halaman Rapor')
                        ->append_metadata( css('school.css', 'school') )
						->build('restricted', $this->data);
    }
    
    private function _cek_group($group_opt) {
        $x = false;
        if ($this->session->userdata['group_id'] == $this->options[$group_opt]) {
            $x = true;
        } 
        return $x;
    }
}