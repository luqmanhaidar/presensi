<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Subjects extends Admin_Controller 
{ 
	public $options = array();
	
	public function __construct() {
		parent::Admin_Controller();
		$this->load->model('subjects_m');
		$this->load->model('schoptions_m');
		$this->load->model('users/users_m','users_m');
		$this->load->model('teachers_subjects_m');
		$this->load->library('to_roman');
        $this->load->library('kasta');
		
		foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
		
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}
	
	public function index() {
		$this->cache->delete_all('modules_m');
        
		// Create pagination links
		$total_rows 			= $this->subjects_m->count_all();
		$this->data->pagination = create_pagination('admin/school/subjects/index', $total_rows);
			
		// Using this data, get the relevant results
		$this->data->subjects = $this->_subjects_translate($this->subjects_m->limit( $this->data->pagination['limit'] )->get_all(),$this->options['grade_roman']);
		$this->template->title($this->module_details['name'], 'Halaman Mata Pelajaran')
						->build('admin/subjects/index', $this->data);
	}
	
	public function create() {
		$this->_form();
	}
	
	public function update($id) {
		$this->_form($id);
	}
	
	public function add_teacher($id) {
		$this->template->set_layout('modal', 'admin');
		$teachers = $this->users_m
			 ->order_by('users.id', 'desc')
			 ->get_many_by(array('active'=>1,'group_id'=>$this->options['teacher_group_id']));
		foreach ($teachers as $teacher) {
			$this->data->teachers[$teacher->user_id] = $teacher->full_name;
		}
			 
		$this->data->subjects = $this->subjects_m->get($id);
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('teachers_id', 'Nama Pengajar', 'required');
		$this->form_validation->set_rules('codes', 'Kode', 'required');
		
		
		if($this->form_validation->run())
		{
			$data = array(
				'subjects_id'	=> $id,
				'teachers_id' 	=> $this->input->post('teachers_id'),
				'codes'			=> $this->input->post('codes')
			);
			
			$this->teachers_subjects_m->insert($data);
			
			$this->data->messages['success'] = 'Penambahan nama mata pelajaran berhasil dilakukan';
		}
		
		$suggests->teachers_id = set_value('teachers_id');
		$suggests->codes = set_value('codes');
		
		$this->data->suggests =& $suggests;
		
		$this->template->build('admin/subjects/suggests', $this->data);
	}
	
	public function update_ts($ts_id) {
		$this->data->suggests = $this->teachers_subjects_m->get($ts_id);
		
		$this->template->set_layout('modal', 'admin');
		$teachers = $this->users_m
			 ->order_by('users.id', 'desc')
			 ->get_many_by(array('active'=>1,'group_id'=>$this->options['teacher_group_id']));
		foreach ($teachers as $teacher) {
			$this->data->teachers[$teacher->user_id] = $teacher->full_name;
		}
			 
		$this->data->subjects = $this->subjects_m->get($this->data->suggests->subjects_id);
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('teachers_id', 'Nama Pengajar', 'required');
		$this->form_validation->set_rules('codes', 'Kode', 'required');
		
		
		if($this->form_validation->run())
		{
			$data = array(
				'teachers_id' 	=> $this->input->post('teachers_id'),
				'codes'			=> $this->input->post('codes')
			);
			
			$this->teachers_subjects_m->update($ts_id,$data);
			
			$this->data->messages['success'] = 'Penambahan nama mata pelajaran berhasil dilakukan';
		}
		
		//$suggests->teachers_id = set_value('teachers_id');
		//$suggests->codes = set_value('codes');
		
		//$this->data->suggests =& $suggests;
		
		$this->template->build('admin/subjects/suggests', $this->data);
	}
	
    public function silabus($id_ts) {
        $this->load->model('lessons_m');
        $this->cache->delete_all('modules_m');
        
        $this->data->detail = $this->teachers_subjects_m->get_for_silabus($id_ts);
        $this->data->classes = $this->teachers_subjects_m->get_classes($id_ts);
        $this->data->lessons = $this->lessons_m->get_many_by(array('ts_id'=>$id_ts));
        
        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('ts_id', 'ID TS', 'required');
		$this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('resume', 'Resume', 'required');
        
        if($this->form_validation->run())
		{
			$data = array(
                        'ts_id'=> $this->input->post('ts_id'),
                        'title'=> $this->input->post('title'),
                        'resume'=> $this->input->post('resume')
                    );
			
			$this->lessons_m->insert($data);
			
			$this->data->messages['success'] = 'Penambahan sub materi berhasil dilakukan';
            redirect ('admin/school/subjects/silabus/'.$data['ts_id']);
		}
        
        $this->template->title($this->module_details['name'], 'Silabus')
                        ->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
						->build('admin/subjects/silabus', $this->data);
	}
    
    public function update_lesson($id) {
        $this->load->model('lessons_m');
        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('id_silabus', 'ID Lesson', 'required');
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('resume', 'Resume', 'required');
        
        if($this->form_validation->run())
		{
			$data = array(
                        'title'=> $this->input->post('title'),
                        'resume'=> $this->input->post('resume')
                    );
			
			$this->lessons_m->update_by(array('id_lesson'=>$id),$data);
			
			$this->data->messages['success'] = 'Penambahan sub materi berhasil dilakukan';
		}
        redirect ('admin/school/subjects/silabus/'.$this->input->post('id_silabus'));
    }
    
    public function delete_lesson($id) {
        $this->load->model('lessons_m');
        $this->lessons_m->delete_by(array('id_lesson'=>$id));
        redirect ('admin/school/subjects/silabus/'.$this->uri->segment(6));
    }
	
	public function scores($id_cs) {
		$this->load->model('classes_subjects_m');
		$this->cache->delete_all('modules_m');
		$this->data->abouts = $this->classes_subjects_m->get_for_score($id_cs);
		$this->data->students = $this->classes_subjects_m->get_student($id_cs);
		
		
		
		if($this->input->post('score')){
			$data =array('`data_cs`'=>serialize($this->input->post('score')));
			$this->classes_subjects_m->update_by(array('id_cs'=>$this->input->post('id_cs')),$data);
		}
		
		$mydata = $this->classes_subjects_m->get_by(array('id_cs'=>$id_cs));
		$this->data->mydata = unserialize($mydata->data_cs);
	
		$this->template->title($this->module_details['name'], 'Scores')
                        ->build('admin/subjects/scores', $this->data);
	}
    
    public function update_desc($id_ts) {
        $this->template->set_layout('modal', 'admin');
        $this->data->subject = $this->teachers_subjects_m->get_by(array('id'=>$id_ts));
        
        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('id', 'ID TS', 'required');
		$this->form_validation->set_rules('desc', 'Deskripsi', 'required');
        
        if($this->form_validation->run())
		{
			$data = array('`desc`'=> $this->input->post('desc'));
			
			$this->teachers_subjects_m->update($this->input->post('id'),$data);
			
			$this->data->messages['success'] = 'Penambahan nama mata pelajaran berhasil dilakukan';
		}
        
        $this->template->build('admin/subjects/desc', $this->data);
    }
    
	private function _form($id = null) {
    	if($id != null) {
    		$subjects = $this->subjects_m->get($id);
    	}
    
    	$this->template->set_layout('modal', 'admin');
    	$this->data->grades = array();
    	for($i=1;$i<=$this->options['total_grade'];$i++) {
    		$this->data->grades[$i] = $this->options['start_grade']-1+$i;
    		if($this->options['grade_roman']) {
    			$this->data->grades[$i] = $this->to_roman->convert($this->data->grades[$i]);
    		} 
    	}
    	
    	$this->load->library('form_validation');

		$this->form_validation->set_rules('subjects', 'Mata Pelajaran', 'required');
		$this->form_validation->set_rules('grade', 'Grade', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'subjects'		=> $this->input->post('subjects'),
				'grade'			=> $this->input->post('grade')
			);
			if($id != null) {
				$this->subjects_m->update($id,$data);
			}else{
				$this->subjects_m->insert($data);
			}
			
			$this->data->messages['success'] = 'Penambahan nama mata pelajaran berhasil dilakukan';
		}
		
		
		if($id != null) {
			$subjects->subjects = set_value('subjects',$subjects->subjects);
			$subjects->grade = set_value('grade',$subjects->grade);
		} else {
			$subjects->subjects = set_value('subjects');
			$subjects->grade = set_value('grade');
		}
		
		$this->data->subjects =& $subjects;
		
		$this->template->build('admin/subjects/form', $this->data);
    }
	
	private function _subjects_translate ($objects,$state) {
    	$i = 0;
    	$result = array();
    	foreach ($objects as $data){	
    		$result[$i]->id = $data->id;
    		$result[$i]->subjects = $data->subjects;
    		
    		if ($state) {
    			$result[$i]->grade = $this->to_roman->convert($this->options['start_grade']-1+$data->grade);	
    		} else {
    			$result[$i]->grade = $this->options['start_grade']-1+$data->grade;
    		}
    		
    		//TEACHER ASSOCIATE
    		$x = 0;
    		foreach ($this->teachers_subjects_m->get_by_subject($data->id) as $teacher ){
    			$result[$i]->the_teacher[$teacher->ts_id]= array(
    							'id'=>$teacher->user_id,
    							'ts_id'=>$teacher->ts_id,
    							'data'=>' ('.$teacher->codes.') '.$teacher->first_name.' '.$teacher->last_name);
    			$x++;
    		}
    		
    		$i++;
    	}
    	return $result;
    }
}