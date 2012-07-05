<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Students extends Admin_Controller 
{
	public $options =  array();
	
	public function __construct() {
		parent::Admin_Controller();
		
		$this->load->model('schoptions_m');
		$this->load->model('students_m');
		$this->load->model('student_classes_m');
		$this->load->model('users/users_m','users_m');
		$this->load->helper('users/user');
		$this->load->model('groups/group_m');
		$this->load->library('form_validation');
		$this->load->library('to_roman');
		$this->load->library('kasta');
		foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
		
		$this->validation_rules = array(
			array(
				'field' => 'first_name',
				'label' => lang('user_first_name_label'),
				'rules' => 'required|utf8'
			),
			array(
				'field' => 'last_name',
				'label' => lang('user_last_name_label'),
				'rules' => 'required|utf8'
			),
			array(
				'field' => 'display_name',
				'label' => lang('user_display_name'),
				'rules' => 'required|alphanumeric|maxlength[50]'
			),
			array(
				'field' => 'password',
				'label' => lang('user_password_label'),
				'rules' => 'min_length[6]|max_length[20]'
			),
			array(
				'field' => 'confirm_password',
				'label' => lang('user_password_confirm_label'),
				'rules' => 'matches[password]'
			),
			array(
				'field' => 'email',
				'label' => lang('user_email_label'),
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'username',
				'label' => lang('user_username'),
				'rules' => 'required|alphanumeric|maxlength[20]'
			),
			array(
				'field' => 'group_id',
				'label' => lang('user_group_label'),
				'rules' => 'required'
			),
			array(
				'field' => 'active',
				'label' => lang('user_active_label'),
				'rules' => ''
			),
			array(
				'field' => 'class',
				'label' => 'Kelas',
				'rules' => ''
			)
		);
		
		$this->data->the_groups 			= $this->group_m->get($this->options['student_group_id']);

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
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
	}
	
	public function create() {
		$this->cache->delete_all('modules_m');
		
		$this->load->model('classes_m');
		$this->load->model('school_profiles_m');
		
		foreach ($this->classes_m->get_all() as $class) {
			$this->data->classes[$class->id] = $this->_grade($class->grade).' '.$class->class_name; 
		}
		
		// We need a password don't you think?
		$this->validation_rules[2]['rules'] .= '|required';
		$this->validation_rules[3]['rules'] .= '|required';
		$this->validation_rules[5]['rules'] .= '|callback__email_check';
		$this->validation_rules[6]['rules'] .= '|callback__username_check';

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		$email 		  = $this->input->post('email');
		$password 	  = $this->input->post('password');
		$username	  = $this->input->post('username');

		$user_data 	= array(
			'first_name' 	=> $this->input->post('first_name'),
			'last_name'  	=> $this->input->post('last_name'),
			'display_name'  => $this->input->post('display_name'),
			'group'  => $this->input->post('group_id')
		);

		if ($this->form_validation->run() !== FALSE)
		{
			//hack to activate immediately
			
			if ($this->input->post('active'))
			{
				$this->config->set_item('email_activation', $this->settings->email_activation, 'ion_auth');
			}
			

			// Try to register the user
			if($user_id = $this->ion_auth->register($username, $password, $email, $user_data,$group_name = $this->input->post('group_id')))
			{
				$newid = $this->db->insert_id();
				// Set the class 
				$set_class = array('class_id'=>$this->input->post('class'),'student_id'=>$newid,'year'=>$this->options['active_years']);
				$this->student_classes_m->insert($set_class);
				$id_number = array('user_id'=>$newid,'id_number'=>$this->input->post('id_number'));
				$this->school_profiles_m->insert_id_number($id_number);
				// Set the flashdata message and redirect
				$this->session->set_flashdata('success', $this->ion_auth->messages());
				redirect('admin/school/students');
			}
			// Error
			else
			{
				$this->data->error_string = $this->ion_auth->errors();
			}
		}
		else
		{
			// Dirty hack that fixes the issue of having to re-add all data upon an error
			if ($_POST)
			{
				$member = (object)$_POST;
			}
		}
		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$member->{$rule['field']} = set_value($rule['field']);
		}

    	// Render the view
		$this->data->member =& $member;
		
		$this->template->title($this->module_details['name'], 'Halaman Penambahan Siswa')
						->build('admin/students/form', $this->data);
	}
	
	public function edit($id=0) {
		$this->load->model('classes_m');
		$this->load->model('school_profiles_m');
		
		foreach ($this->classes_m->get_all() as $class) {
			$this->data->classes[$class->id] = $this->_grade($class->grade).' '.$class->class_name; 
		}
	
		$this->data->my_class = $this->student_classes_m->get_by(array('student_id'=>$id));
		
		$this->data->profile = $this->school_profiles_m->get_by(array('user_id'=>$id));
	
		// confirm_password is required in case the user enters a new password
		if($this->input->post('password') && $this->input->post('password') != '')
		{
			$this->validation_rules[3]['rules'] .= '|required';
			$this->validation_rules[3]['rules'] .= '|matches[password]';
		}

		// Get the user's data
		$member 			= $this->ion_auth->get_user($id);

		$member->full_name 	= $member->first_name .' '. $member->last_name;

		// Got user?
		if(!$member)
		{
			$this->session->set_flashdata('error', $this->lang->line('user_edit_user_not_found_error'));
			redirect('admin/users');
		}

		// Check to see if we are changing usernames
		if ($member->username != $this->input->post('username'))
		{
			$this->validation_rules[6]['rules'] .= '|callback__username_check';
		}

		// Check to see if we are changing emails
		if ($member->email != $this->input->post('email'))
		{
			$this->validation_rules[5]['rules'] .= '|callback__email_check';
		}

		// Run the validation
		$this->form_validation->set_rules($this->validation_rules);
		if ($this->form_validation->run() === TRUE)
		{
			// Get the POST data
			$update_data['first_name'] 		= $this->input->post('first_name');
			$update_data['last_name'] 		= $this->input->post('last_name');
			$update_data['email'] 			= $this->input->post('email');
			$update_data['active'] 			= $this->input->post('active');
			$update_data['username'] 		= $this->input->post('username');
			$update_data['display_name']	= $this->input->post('display_name');
			$update_data['group_id']		= $this->options['student_group_id'];

			// Password provided, hash it for storage
			if( $this->input->post('password') && $this->input->post('confirm_password') )
			{
				$update_data['password'] = $this->input->post('password');
			}

			if($this->ion_auth->update_user($id, $update_data))
			{
				$this->session->set_flashdata('success', $this->ion_auth->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}
			
			$class_update = array('class_id'=>$this->input->post('class'));
			$this->student_classes_m->update_by(array('student_id'=>$id),$class_update);
			$id_number = array('user_id'=>$id,'id_number'=>$this->input->post('id_number'));
			$this->school_profiles_m->insert_id_number($id_number);

			// Redirect the user
			redirect('admin/school/students');
		}
		else
		{
			// Dirty hack that fixes the issue of having to re-add all data upon an error
			if ($_POST)
			{
				$member 			= (object)$_POST;
				$member->full_name 	= $member->first_name .' '. $member->last_name;
			}
		}
		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$member->{$rule['field']} = set_value($rule['field']);
			}
		}

		// Render the view
		$this->data->member =& $member;
		
		$this->template->title($this->module_details['name'], 'Halaman Penambahan Pengajar')
						->build('admin/students/form', $this->data);
	}
	
	public function set_class() {
		//print_r($this->input->post('action_to'));
		foreach ($this->input->post('action_to') as $key=>$val) {
			$in = array('class_id'=>$this->input->post('assign_class'),'student_id'=>$val,'year'=>$this->options['active_years']);
			$this->student_classes_m->insert($in);
		}
		redirect('admin/school/students');
	}
	
	public function report($id) {
		$this->cache->delete_all('modules_m');
        $this->load->model('school_profiles_m');
		
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
						->append_metadata( css('admin.css', 'school') )
        				->append_metadata( css('school.css', 'school') )
						->build('admin/students/report', $this->data);
	}
    
    public function profile($id=0) {
        $this->cache->delete_all('modules_m');
        $this->data->myprofiles = $this->student_classes_m->get_my_profile($id);
        $this->load->model('school_profiles_m');
        
        if($this->input->post('data')) {
            $this->school_profiles_m->insert_profile(array('data'=>serialize($this->input->post('data')),'user_id'=>$id));
        }
        
        $this->data->profiles = $this->school_profiles_m->get_by(array('user_id'=>$id));
        $mydata = unserialize($this->data->profiles->data);
        
        if (isset($mydata['mypicture'])) {
        	$this->data->picture = '<img src="'.$mydata['mypicture'].'" >';
        }else{
        	$this->data->picture = '<img src="'.base_url().'/uploads/school/picture.png" >';
        }
        
        $this->data->mydata =$mydata;
        
        $this->template->title($this->module_details['name'], 'Halaman Profil')
        				->append_metadata( css('admin.css', 'school') )
        				->append_metadata( css('school.css', 'school') )
						->build('admin/students/profile', $this->data);
    }
    
    public function picture($id=0) {
    	$this->load->model('school_profiles_m');
    	$this->data->myprofiles = $this->student_classes_m->get_my_profile($id);
    	
    	$this->data->profiles = $this->school_profiles_m->get_by(array('user_id'=>$id));
        $mydata = unserialize($this->data->profiles->data);
        
        if (isset($mydata['mypicture'])) {
        	$this->data->picture = '<img src="'.$mydata['mypicture'].'" >';
        }else{
        	$this->data->picture = '<img src="'.base_url().'/uploads/school/picture.png" >';
        }
        
        $this->data->mydata =$mydata;
        
        /** ============================= */
    
        $this->cache->delete_all('modules_m');
        $this->load->library('jcrop');
        
                $prefix = 'c_';
				$this->data->prefix = $prefix;
				$this->data->target_w = 90;
				$this->data->target_h = 120;
				$setdata = array(
					'prefix'=>$prefix,
					'folder'=>'uploads/school/student/',
					'thumb_folder'=>'uploads/school/student/',
					'target_w'=>$this->data->target_w,
					'target_h'=>$this->data->target_h,
					'create_thumb'=>FALSE
					);
				$this->jcrop->set_data($setdata);
				$action_form = site_url($this->uri->uri_string());
				
				//Cancel uploading image
				if(isset($_POST[$prefix.'cancel'])) {
					$this->jcrop->cancel();
				}
				
				//Upload Process
				if(isset($_POST[$prefix.'submit'])) {
					$this->jcrop->uploading(& $status);
					$this->data->status = $status;
				}
				
				//Saving data
				if(isset($_POST[$prefix.'save'])) {
					$this->form_validation->set_error_delimiters('<div style="color:red;margin-bottom:10px;">', '</div>');
					$this->form_validation->set_rules($prefix.'name','"Collection Name"','required|max_length[50]');
					
					if($this->form_validation->run() == false){
						$this->data->error_notification = 'Im Sorry, there are some error occured. Please fill all the blank form';
					}else{
						$this->jcrop->produce(& $pic_loc,& $pic_path,& $thumb_loc,& $thumb_path);
						$mydata['mypicture'] = $pic_loc;
						$input = array(	'data'		=> serialize($mydata),
										'user_id'	=> $id,
										);
						$this->school_profiles_m->insert_profile($input);
						redirect(base_url().'admin/school/students/profile/'.$id);
					}			
				}
				
				//Cek if image has uploaded
				if($this->jcrop->is_uploaded(& $thepicture,& $orig_w,& $orig_h,& $ratio)){
					$this->data->orig_w = $orig_w;
					$this->data->orig_h = $orig_h;
					$this->data->ratio = $ratio;
					$this->data->thepicture = $thepicture;
					
					$form = array (	'form_input'	=>array('name'=>$prefix.'name',
															'class'=>'text-long',
															'value'=>$this->data->myprofiles->first_name,
															'onClick'=>'$(this).val(\'\');')
							);	
					$this->jcrop->add_form($form);
					$this->data->form = $this->jcrop->show_form($action_form,TRUE);
					
				}else{
					$this->data->form = $this->jcrop->show_form($action_form);
				}
        
        $this->template->title($this->module_details['name'], 'Halaman Profil')
                        ->append_metadata( js('jcrop.js', 'school') )
                        ->append_metadata( css('jcrop.css', 'school') )
                        ->append_metadata( css('admin.css', 'school') )
        				->append_metadata( css('school.css', 'school') )
						->build('admin/students/picture', $this->data);
    }
	
	private function _grade($data) {
		$grade = $this->options['start_grade']-1+$data;
		if($this->options['grade_roman']) {
			$grade = $this->to_roman->convert($grade);
		}
		return $grade;
	}
}