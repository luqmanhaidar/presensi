<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_subjects_m extends MY_Model { 
	/**
    function insert($id_class, $post) {
		parent::delete_by(array('class_id'=>$id_class));
		foreach ($post as $key=>$val) {
			parent::insert(array('class_id'=>$id_class,'ts_id'=>$val));
		}
		return true;
	}
    */
    
    function insert($id_class,$post) {
        $old = $this->_get_old($id_class);
        foreach ($old as $data) {
            $del = true;
            foreach ($post as $key=>$val){
                if($data->ts_id == $val){
                    $del = false;
                    break;
                } 
            }
            if ($del){
                parent::delete_by(array('class_id'=>$id_class,'ts_id'=>$data->ts_id));
            }
        }
        $old = $this->_get_old($id_class);
        foreach ($post as $key=>$val) {
            $ins = true;
            foreach ($old as $data){
                if($val == $data->ts_id){
                    $ins = false;
                    break;
                }
            }
            if($ins){
                parent::insert(array('class_id'=>$id_class,'ts_id'=>$val));
            }    
        }
        return true;
    }
    
    private function _get_old ($id_class) {
        return parent::get_many_by(array('class_id'=>$id_class));
    }
	
	function get_subject ($id) {
		$this->db->select('classes_subjects.*, t.*, p.*, s.*')
				 ->join('teachers_subjects t','t.id = classes_subjects.ts_id')
				 ->join('subjects s', 's.id = t.subjects_id')
				 ->join('profiles p','p.user_id = t.teachers_id');
		$this->db->where('class_id',$id);
		return parent::get_all();
	}
	
	function get_for_score($id_cs) {
    	$this->db->select('classes_subjects.*,ts.*,s.*,c.*,p.*')
    			 ->join('teachers_subjects ts','ts.id=classes_subjects.ts_id')
    			 ->join('subjects s','s.id=ts.subjects_id')
    			 ->join('classes c','c.id=classes_subjects.class_id')
    			 ->join('profiles p','p.user_id=ts.teachers_id');
    	return parent::get_by(array('id_cs'=>$id_cs));
    }
    
    function get_student($id_cs){
    	$this->db->select('classes_subjects.*,sc.*,p.*')
    			 ->join('student_classes sc','sc.class_id=classes_subjects.class_id')
    			 ->join('profiles p','p.user_id=sc.student_id');
    	return parent::get_many_by(array('id_cs'=>$id_cs));
    }
	
}