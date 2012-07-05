<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends Public_Controller {
    public $options = array();
    
    public function __construct() {
        parent::Public_Controller();
		$this->load->model('subjects_m');
		$this->load->model('schoptions_m');
		$this->load->model('users/users_m','users_m');
		$this->load->model('teachers_subjects_m');
		$this->load->library('to_roman');
		
		foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
    }
    
    public function index() {
		$this->cache->delete_all('modules_m');
		// Create pagination links
		$total_rows 			= $this->subjects_m->count_all();
		$this->data->pagination = create_pagination('admin/school/subjects/index', $total_rows);
			
		// Using this data, get the relevant results
		$this->data->subjects = $this->_subjects_translate($this->subjects_m->limit( $this->data->pagination['limit'] )->get_all(),$this->options['grade_roman']);
		$this->template->title($this->module_details['name'], 'Halaman Mata Pelajaran')
                        ->append_metadata( css('school.css', 'school') )
						->build('subjects', $this->data);
	}
    
    public function silabus($id_ts) {
        $this->load->model('lessons_m');
        $this->cache->delete_all('modules_m');
        
        $this->data->detail = $this->teachers_subjects_m->get_for_silabus($id_ts);
        $this->data->classes = $this->teachers_subjects_m->get_classes($id_ts);
        $this->data->lessons = $this->lessons_m->get_many_by(array('ts_id'=>$id_ts));
        
        $this->template->title($this->module_details['name'], 'Silabus')
                        ->append_metadata( css('school.css', 'school') )
						->build('silabus', $this->data);
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
    			$result[$i]->the_teacher[$teacher->ts_id]=' ('.$teacher->codes.') '.$teacher->first_name.' '.$teacher->last_name;
    			$x++;
    		}
    		
    		$i++;
    	}
    	return $result;
    }
}