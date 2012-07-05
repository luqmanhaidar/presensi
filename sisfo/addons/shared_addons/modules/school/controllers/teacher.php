<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends Public_Controller
{ 
    function __construct() {
        parent::Public_Controller();
        
        $this->load->model('schoptions_m');
		$this->load->model('teachers_m');
		$this->load->model('users/users_m','users_m');
		$this->load->model('teachers_subjects_m');
		$this->load->helper('users/user');
		$this->load->library('form_validation');
		$this->load->library('to_roman');
		$this->load->library('kasta');
		
		foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
    }
    
    public function index() {
        $this->cache->delete_all('modules_m');
		
		//$this->data->pagination = create_pagination('admin/school/teachers/index', $this->data->active_teacher_count);
		
		$this->data->teachers = $this->_teacher_translate(
		 	 $this->users_m
			 ->order_by('users.id', 'desc')
			 ->get_many_by(array('active'=>1,'group_id'=>$this->options['teacher_group_id']))
		);
		// Using this data, get the relevant results
		        
        $this->template->title($this->module_details['name'])
                        ->append_metadata( css('school.css', 'school') )
						->build('teacher', $this->data);
    }
    
    public function detail($id=0) {
    
        $this->cache->delete_all('modules_m');
        $this->load->model('users/profile_m');
        $this->data->myprofiles = $this->profile_m->get_profile(array('id'=>$id));
        $this->load->model('school_profiles_m');
        
        if($this->input->post('data')) {
            $this->school_profiles_m->insert_profile(array('data'=>serialize($this->input->post('data')),'user_id'=>$id));
        }
        
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
    
    private function _teacher_translate($data) {
		$i = 0;
    	$result = array();
		foreach ($data as $obj) {
			$result[$i]->id = $obj->id;
			$result[$i]->full_name = $obj->full_name;
			$result[$i]->role_title = $obj->role_title;
			$result[$i]->last_login = $obj->last_login;
			
			$x=0;
			foreach ($this->teachers_subjects_m->get_by_teacher($obj->id) as $sub){
				$result[$i]->the_subject[$x] = $sub->subjects;
				$result[$i]->the_subject[$x] .= ' Grade ';
				$result[$i]->the_subject[$x] .= $this->_grade($sub->grade);
				$x++;
			}
			
			$i++;
		}
		return $result;
	}
	
	private function _grade($data) {
		$grade = $this->options['start_grade']-1+$data;
		if($this->options['grade_roman']) {
			$grade = $this->to_roman->convert($grade);
		}
		return $grade;
	}
}