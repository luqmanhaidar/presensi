<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_classes_m extends MY_Model {
	function get_all(){
		$this->db->select('student_classes.*,c.*, u.*, p.*, g.description as role_title, IF(p.last_name = "", p.first_name, CONCAT(p.first_name, " ", p.last_name)) as full_name')
				 ->join('users u','u.id=student_classes.student_id','right')
				 ->join('groups g','g.id=u.group_id')
				 ->join('classes c','c.id=student_classes.class_id', 'left')
				 ->join('profiles p','p.user_id = u.id','left');
		return parent::get_all();
	}
	
	function insert($array) {
		$this->delete_by_data($array);
		return parent::insert($array);
	}
	
	function delete_by_data($array){
		array_shift($array);
		$this->db->where($array);
		$this->db->delete('student_classes');
	}
	
	function get_my_profile($id) {
		$this->db->select('student_classes.*,c.*, u.*, p.*, g.description as role_title, IF(p.last_name = "", p.first_name, CONCAT(p.first_name, " ", p.last_name)) as full_name')
				 ->join('users u','u.id=student_classes.student_id','right')
				 ->join('groups g','g.id=u.group_id')
				 ->join('classes c','c.id=student_classes.class_id', 'left')
				 ->join('profiles p','p.user_id = u.id','left');
		return parent::get_by(array('student_id'=>$id));
	}
	
	function get_my_subject($id) {
		$this->db->select('student_classes.*,cs.*,ts.*,ts.id as ts_id,s.*,p.*')
                 ->join('classes_subjects cs','cs.class_id=student_classes.class_id')
                 ->join('teachers_subjects ts','ts.id=cs.ts_id')
                 ->join('subjects s','s.id=ts.subjects_id')
                 ->join('profiles p','p.user_id=ts.teachers_id');
        $this->db->where(array('student_classes.student_id'=>$id));
        return parent::get_all();
	}
}