<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 */

class Admin extends Admin_Controller {
    
    public function __construct() {
        parent::Admin_Controller();
        $this->load->library('kasta');
        $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
        
    }
    
    public function index() {
        $this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
    }
    
    public function create() {
    	
    }
    
}