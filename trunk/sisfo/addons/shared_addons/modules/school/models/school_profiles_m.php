<?php defined('BASEPATH') OR exit('No direct script access allowed');

class School_profiles_m extends MY_Model {
    public function insert_profile($data) {
        if (isset($data['user_id'])) {
            if (parent::get_by(array('user_id'=>$data['user_id']))) {
                return parent::update_by(array('user_id'=>$data['user_id']),array('data'=>$data['data']));
            }else{
                return parent::insert(array('data'=>$data['data'],'user_id'=>$data['user_id']));
            }
        }
    }
    
    public function insert_id_number($data) {
        if (isset($data['user_id'])) {
            if (parent::get_by(array('user_id'=>$data['user_id']))) {
                return parent::update_by(array('user_id'=>$data['user_id']),array('id_number'=>$data['id_number']));
            }else{
                return parent::insert(array('id_number'=>$data['id_number'],'user_id'=>$data['user_id']));
            }
        }
    }
}