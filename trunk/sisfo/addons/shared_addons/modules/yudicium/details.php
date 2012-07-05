<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Yudicium extends Module {
    
    public $version = 0.1;
    
    public function info()
	{
		return array(
			'name' => array(
			
				'en' => 'Yudicium'
				
			),
			'description' => array(
				
				'en' => 'Sistem Informasi Yudisium.Entri data Isian Keluluasan'
		
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu'	=> 'content',
                        'sections' => array(
                            'list' => array(
                                    'name'  => 'yudicium_new_entri',
				    'uri'   => 'admin/yudicium',  
                            ),
                            'new'  => array(
                                    'name'  => 'yudicium_new_entri',
                                    'uri'   => 'admin/yudicium/create'
                            )
                            
                        ),                      
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('yudicium');
		
		return $this->db->query("
			CREATE TABLE ".$this->db->dbprefix('yudicium')." (
			  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
			  `nim` varchar(12) NOT NULL default '',
			  `name` varchar(255) NOT NULL default '',			  
			  `place_of_birth` varchar(35) NOT NULL default '',
			  `date_of_birth` DATE,
			  `religion` varchar(32) NOT NULL default '',
			   `sex` enum('L','P') default 'L',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='yudicium'
		");
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return FALSE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "This module has no inline docs as it does not have a back-end.";
	}
}