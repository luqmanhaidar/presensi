<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroDatabase
 *
 * Database Utilities Module for PyroCMS
 * 
 * @author 		Parse19
 * @link		http://parse19.com/pyrodatabase
 * @package 	PyroDatabase
 */
class Module_Database extends Module {

	public $version = '1.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Database'
			),
			'description' => array(
				'en' => 'Database utilities.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'utilities'
		);
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		return true;
	}

	public function upgrade( $upgrade_version )
	{
		return true;
	}

	public function help()
	{
		return "No documentation has been added for this module.";
	}
}
/* End of file details.php */