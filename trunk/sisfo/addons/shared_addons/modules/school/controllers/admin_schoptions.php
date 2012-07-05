<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Schoptions extends Admin_Controller 
{
	protected $validation_rules;
	protected $options = array();
	
	public function __construct() {
		parent::Admin_Controller();
		$this->load->model('schoptions_m');
		$this->load->model('groups/group_m');
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
		$this->load->library('kasta');
		foreach ($this->schoptions_m->get_all() as $option){
			$this->options[$option->option_name] = $option->value;
		}
		
		$this->validation_rules = array(
			array(
				'field' => 'admin_group_id',
				'label' => 'Grup Admin Sekolah',
				'rules' => 'required'
			),
			array(
				'field' => 'teacher_group_id',
				'label' => 'Grup Pengajar',
				'rules' => 'required'
			),
			array(
				'field' => 'student_group_id',
				'label' => 'Grup Siswa',
				'rules' => 'required'
			)
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);
        
        if ($this->kasta->position() != 'admin' && $this->kasta->position() != 'super' ) {
            redirect('admin/school');
        }
	}
	
	public function index() {
		$this->cache->delete_all('modules_m');
		
		$this->data->groups =  array();
		foreach ($this->group_m->get_all() as $group) {
			$this->data->group[$group->id] = $group->name;			
		}
		
		$this->data->options = $this->options;
			
		// Using this data, get the relevant results
		$this->template->title($this->module_details['name'], 'Halaman pengaturan sekolah')
						->build('admin/schoptions', $this->data);
	}
	
	public function update() {
		if ($this->form_validation->run()) {
		array_pop($_POST);
			$this->schoptions_m->update_options($_POST)
			?$this->session->set_flashdata('success','Opsi pengaturan telah diperbaharui')
			:$this->session->set_flashdata(array('error'=> 'Pembaharuan gagal dilaksanakan'));
				
				redirect('admin/school/schoptions/index');
		}
	
	}
}