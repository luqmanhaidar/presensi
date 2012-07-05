<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student extends Public_Controller
{ 
    public $options =  array();
    
    function __construct() {
        parent::Public_Controller();
        
        $this->load->model('schoptions_m');
		$this->load->model('students_m');
		$this->load->model('student_classes_m');
		$this->load->model('users/users_m','users_m');
		$this->load->helper('users/user');
		$this->load->library('form_validation');
		$this->load->library('to_roman');
		$this->load->library('kasta');
		
		foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
        
        
    }
    
    public function index() {
        $id = 0;
		if($this->input->post('filter_class')) {
			$id = $this->input->post('filter_class');
		}
		
		$this->load->model('classes_m');
		
		foreach ($this->classes_m->get_all() as $class) {
			$this->data->classes[$class->id] = $this->_grade($class->grade).' '.$class->class_name; 
		}
 	
		$this->cache->delete_all('modules_m');
		
		//$this->data->pagination = create_pagination('admin/school/teachers/index', $this->data->active_teacher_count);
		
		$this->data->students = $this->student_classes_m
			 ->order_by('student_classes.class_id', 'desc')
			 ->get_many_by(array('active'=>1,'group_id'=>$this->options['student_group_id']));
			 
		if($id != 0) {
		$this->data->students = $this->student_classes_m
			 ->order_by('student_classes.class_id', 'desc')
			 ->get_many_by(array('active'=>1,'group_id'=>$this->options['student_group_id'],'student_classes.class_id'=>$id));
		}
				
		// Using this data, get the relevant results
		$this->template->title($this->module_details['name'], 'Halaman Daftar Murid')
						->build('admin/students/index', $this->data);
        
        $this->template->title($this->module_details['name'])
                        ->append_metadata( css('school.css', 'school') )
						->build('student', $this->data);
    }
    
    public function detail($id) {
		$this->cache->delete_all('modules_m');
        $this->load->model('school_profiles_m');
		
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
						->build('detail', $this->data);
	}
    
    private function _grade($data) {
		$grade = $this->options['start_grade']-1+$data;
		if($this->options['grade_roman']) {
			$grade = $this->to_roman->convert($grade);
		}
		return $grade;
	}
}