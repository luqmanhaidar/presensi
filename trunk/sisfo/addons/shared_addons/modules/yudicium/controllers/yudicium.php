<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 */

class Yudicium extends Public_Controller {
    protected $v_rules = array(
		    array(
			    'field' => 'name',
			    'label' => 'lang:yudicium_name',
			    'rules' => 'trim|htmlspecialchars|required|max_length[100]'
			  ),
		    array(
			    'field' => 'nim',
			    'label' => 'lang:yudicium_nim',
			    'rules' => 'trim|numeric|required|max_length[100]'
			  ),
		    array(
			    'field' => 'department',
			    'label' => 'lang:yudicium_department',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'pa',
			    'label' => 'lang:yudicium_pa',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'religion',
			    'label' => 'lang:yudicium_religion',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'gender',
			    'label' => 'lang:yudicium_gender',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'merriage',
			    'label' => 'lang:yudicium_merriage',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'pob',
			    'label' => 'lang:yudicium_pob',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'dob',
			    'label' => 'lang:yudicium_dob',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'address',
			    'label' => 'lang:yudicium_address',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'parrent_address',
			    'label' => 'lang:yudicium_parrent_address',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'parrental',
			    'label' => 'lang:yudicium_parrental',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'soo',
			    'label' => 'lang:yudicium_soo',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'school_address',
			    'label' => 'lang:yudicium_school_address',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'graduation',
			    'label' => 'lang:yudicium_graduation',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'sks',
			    'label' => 'lang:yudicium_sks',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'ipk',
			    'label' => 'lang:yudicium_ipk',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'thesis',
			    'label' => 'lang:yudicium_thesis',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'thesis_title',
			    'label' => 'lang:yudicium_thesis_title',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'lecture',
			    'label' => 'lang:yudicium_lecture',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'start',
			    'label' => 'lang:yudicium_start',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'finish',
			    'label' => 'lang:yudicium_finish',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'yudicium_date',
			    'label' => 'lang:yudicium_date',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'phone',
			    'label' => 'lang:yudicium_phone',
			    'rules' => 'trim|required'
		    ),
		    array(
			    'field' => 'email',
			    'label' => 'lang:yudicium_email',
			    'rules' => 'trim|required'
		    )
		);
    
    public function __construct()
	{
		
		parent::__construct();

		$this->lang->load('yudicium');
		$this->load->model('yudicium_m');
		//$this->load->model('department_m');
		$this->data->prodies= array(0 => 'Pilih Program Studi');
		if($prodies = $this->yudicium_m->get_dept())
		{
		    foreach($prodies as $dpt)
		    {
			$this->data->prodies[$dpt->id] = $dpt->name;
		    }
		}
		
		$this->data->lectures= array(0 => 'Pilih Dosen');
		if($lectures = $this->yudicium_m->get_lecture())
		{
		    foreach($lectures as $lec){
			$this->data->lectures[$lec->id]= $lec->name;
		    }
		}
		
		$this->data->religions= array(
					      0 => 'Pilih Agama',
					      1 => 'Islam',
					      2 => 'Katholik',
					      3 => 'Kristen',
					      4 => 'Hindu',
					      5 => 'Budha',
					      6 => 'Konghuchu',
					      7 => 'Lainnya'
					      );
	}
    
    public function index() {
	
        $this->template
//			->set('departments',$dpid)
			->append_metadata( css('ui-lightness/jquery-ui-1.7.3.custom.css', 'yudicium') )
			->append_metadata( js('jquery-ui-min.js', 'yudicium') )
			->append_metadata('<script type="text/javascript">
					  $(function() {
					  $( "#datepicker" ).datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true,yearRange: "1980:2000"});
					  $( "#graduation" ).datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true});
					  $( "#start" ).datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true});
					  $( "#finish" ).datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true});
					  $( "#date" ).datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true});
					  });</script>')
			->title($this->module_details['name'])
			->build('index', $this->data);
    }
    
    public function create() {
	$this->load->library('form_validation');
	$this->form_validation->set_rules($this->v_rules);
	if($this->form_validation->run()){
	    if($this->input->post('submit')=='Simpan'){
		
		//echo "<pre>";
		$id=$this->yudicium_m->insert(array(
						    'name'	=> $this->input->post('name'),
						    'nim'	=> $this->input->post('nim'),
						    'department'=> $this->input->post('department'),
						    'pa'	=> $this->input->post('pa')
						    
						    ));
		if($id){
		    $message='Data Berhasil disimpan';
		    $this->session->set_flashdata('success', $message);
		}else{
		    $message='Data Gagal disimpan';
		    $this->session->set_flashdata('error', $message);
		}
		
		redirect('index');
	    }
	    
	}else{
	    foreach ($this->v_rules as $key => $field)
		{
			if (isset($_POST[$field['field']]))
			{
				$post->$field['field'] = set_value($field['field']);
			}
		}
	}
	
	$this->template
			
			->build('index',$this->data);
	
    }
    function ok(){
	echo "ok";
    }
    
}