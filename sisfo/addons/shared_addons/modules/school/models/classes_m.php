<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_m extends MY_Model {
    function get_my_student($id_class) {
        $this->db->select('classes.*,sc.*,p.*')
                 ->join('student_classes sc','sc.class_id=classes.id')
                 ->join('profiles p','p.user_id=sc.student_id');
        $this->db->order_by('p.first_name','asc');
        return parent::get_many_by(array('classes.id'=>$id_class));
    }
    
}