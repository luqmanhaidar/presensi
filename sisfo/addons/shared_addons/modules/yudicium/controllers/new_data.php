<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 */

class New_data extends Admin_Controller {
    
    public function __construct()
	{
		parent::__construct();

		$this->lang->load('yudicium');
	}
    
    public function index() {
        $this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
    }
    
    public function create() {
    	
    }
    
}