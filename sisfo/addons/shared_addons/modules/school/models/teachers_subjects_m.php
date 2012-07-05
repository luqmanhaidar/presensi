<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers_subjects_m extends MY_Model {
        function get_by_subject($subject_id) {
        	$this->db->select('teachers_subjects.*, s.*, p.*, teachers_subjects.id AS ts_id');
			$this->db->join('subjects s','s.id = teachers_subjects.subjects_id');
        	$this->db->join('profiles p','p.user_id = teachers_subjects.teachers_id');
        	$this->db->where('teachers_subjects.subjects_id',$subject_id);
        	return parent::get_all();
        } 
        
        function get_by_teacher($teacher_id) {
        	$this->db->select('teachers_subjects.*, s.*, p.*');
			$this->db->join('subjects s','s.id = teachers_subjects.subjects_id');
        	$this->db->join('profiles p','p.user_id = teachers_subjects.teachers_id');
        	$this->db->where('teachers_subjects.teachers_id',$teacher_id);
        	return parent::get_all();
        }
        
        function get_for_classes($grade) {
        	$this->db->select('teachers_subjects.*, s.*, p.*, teachers_subjects.id AS ts_id, s.id AS s_id')
					 ->join('subjects s','s.id = teachers_subjects.subjects_id')
					 ->join('profiles p','p.user_id = teachers_subjects.teachers_id');
			$this->db->where('s.grade',$grade);
			$this->db->order_by('subjects_id');
        	return parent::get_all();
        }
        
        function get_for_silabus($id_ts) {
            $this->db->select('teachers_subjects.*, s.*, p.*, teachers_subjects.id AS ts_id, s.id AS s_id')
					 ->join('subjects s','s.id = teachers_subjects.subjects_id')
					 ->join('profiles p','p.user_id = teachers_subjects.teachers_id');
            return parent::get_by(array('teachers_subjects.id'=>$id_ts));
        }
        
        function get_classes($id_ts) {
            $this->db->select('teachers_subjects.*, cs.*, c.*')
                     ->join('classes_subjects cs','cs.ts_id=teachers_subjects.id','right')
                     ->join('classes c','c.id=cs.class_id','left');
            return parent::get_many_by(array('teachers_subjects.id'=>$id_ts));
        }
        
        
}