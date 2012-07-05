<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Classes extends Admin_Controller {
	public $options = array();
    
    public function __construct () {
        parent::Admin_Controller();
        $this->load->model('classes_m');
        $this->load->model('schoptions_m');
        
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
		$total_rows 			= $this->classes_m->count_all();
		$this->data->pagination = create_pagination('admin/school/classes/index', $total_rows);
			
		// Using this data, get the relevant results
		$this->data->classes = $this->_class_translate($this->classes_m->limit( $this->data->pagination['limit'] )->get_all(),$this->options['grade_roman']);
    	$this->template->title($this->module_details['name'])
						->build('admin/classes/index', $this->data);
    }
    
    public function create() {
    	$this->_form();
    }
    
    public function edit($id) {
    	$this->_form($id);
    }
    
    public function delete($id = 0) {
    	$this->load->model('classes_subjects_m');
    	$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
    	
    	if(!empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id) 
			{
				if($this->classes_m->delete($id))
				{
					$this->classes_subjects_m->delete_by(array('class_id'=>$id));
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', 'Data kelas gagal dihapus');
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', 'Data kelas berhasil dihapus');
			}
		}		
		else
		{
			$this->session->set_flashdata('error', 'Tidak ada data yang diseleksi');
		}
		
    	redirect('admin/school/classes/index');
    }
    
    public function detail($id) {
    	$this->load->model('teachers_subjects_m');
    	$this->load->model('classes_subjects_m');
    	
    	if($_POST) {
    		if($this->input->post('subject') == '') {
    			$this->classes_subjects_m->delete_by(array('class_id'=>$id));
    		}else{
    			$this->classes_subjects_m->insert($id,$this->input->post('subject'));
    		}
    	}

    	
    	$this->data->grades = $this->_grade($this->classes_m->get($id)->grade);
    	$this->data->classes = $this->classes_m->get($id);
    	
    	$mysubject = $this->classes_subjects_m->get_subject($id);
    	
    	$this->data->mysubject = $mysubject;
        $this->data->mystudent = $this->classes_m->get_my_student($id);
    	
    	/** list of subjects */
    	$this->data->subjects = $this->teachers_subjects_m->get_for_classes($this->data->classes->grade);
    	
    	$this->data->mine = array();
    	if($mysubject){
    		foreach ($mysubject as $item){
    			$this->data->mine[] = $item->ts_id;
    		}
    	}
    	
    	
    	
    	
    	$this->template->title($this->module_details['name'])
						->build('admin/classes/details', $this->data);
    }
    
    private function _form($id = null) {
    	if($id != null) {
    		$classes = $this->classes_m->get($id);
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

		$this->form_validation->set_rules('class_name', 'Nama Kelas', 'required');
		$this->form_validation->set_rules('grade', 'Grade', 'required');
		$this->form_validation->set_rules('year', 'Tahun', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'class_name'	=> $this->input->post('class_name'),
				'grade'			=> $this->input->post('grade'),
				'year'			=> $this->input->post('year')
			);
			if($id != null) {
				$this->classes_m->update($id,$data);
			}else{
				$this->classes_m->insert($data);
			}
			
			$this->data->messages['success'] = lang('files.folders.success');
		}
		
		
		if($id != null) {
			$classes->class_name = set_value('class_name',$classes->class_name);
			$classes->grade = set_value('grade',$classes->grade);
			$classes->year = set_value('year',$classes->year);
		} else {
			$classes->class_name = set_value('class_name');
			$classes->grade = set_value('grade');
			$classes->year = set_value('year');
		}
		
		$this->data->classes =& $classes;
		
		$this->template->build('admin/classes/form', $this->data);
    }
    
    private function _class_translate ($objects,$state) {
    	$i = 0;
    	$result = array();
    	foreach ($objects as $data){	
    		$result[$i]->id = $data->id;
    		$result[$i]->class_name = $data->class_name;
    		$result[$i]->year = $data->year;
    		
    		if ($state) {
    			$result[$i]->grade = $this->to_roman->convert($this->options['start_grade']-1+$data->grade);	
    		} else {
    			$result[$i]->grade = $this->options['start_grade']-1+$data->grade;
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