<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maintenance Module
 *
 * @author		Donald Myers
 * @package		PyroCMS
 * @subpackage	Maintenance Module
 * @category	Modules
 */
class Module_Maintenance extends Module 
{

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Maintenance',
				'el' => 'Συντήρηση',
				'ar' => 'الصيانة',
				'zh' => '維護'
			),
			'description' => array(
				'en' => 'Manage the site cache and export information from the database.',
				'el' => 'Διαγραφή αντικειμένων προσωρινής αποθήκευσης μέσω της σελίδας διαχείρισης.',
				'ar' => 'حذف عناصر الذاكرة المخبأة عبر واجهة الإدارة.',
				'zh' => '經由管理介面手動刪除暫存資料。'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'utilities'
		);
	}


	public function install()
	{
		return TRUE;
	}


	public function uninstall()
	{
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
	}


	public function help()
	{
		return "This module will clean up and/or remove cache files and folders
				and also allows admins to export information from the database.";
	}


}

/* End of file details.php */
