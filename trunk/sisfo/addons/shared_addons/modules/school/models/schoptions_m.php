<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Schoptions_m extends MY_Model {
	public function update_options($post) {
		$status = TRUE;
		foreach ($post as $opt=>$val) {
			if(!$this->update_by(array('option_name'=>$opt),array('value'=>$val))) {
				$status = FALSE;
				continue;
			}
		}
		return $status;
	} 
}