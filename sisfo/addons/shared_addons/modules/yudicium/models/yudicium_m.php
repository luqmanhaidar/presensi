<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Dwi Agus Purwanto
 * @package 	PyroCMS
 * @subpackage 	Yudicium model
 * @since		v0.1
 *
 */
class Yudicium_m extends MY_Model {
    function get_dept(){
        return $this->db->get('department')->result();
    }
    function get_lecture(){
        return $this->db->get('lecture')->result();
    }
}