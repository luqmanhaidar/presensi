Selamat datang di sistem elearning ala Indonesia <br /><br />


<?php 

if ( $this->is_student) {
	echo anchor('school/index/'.$user_id,'Profil').' | ';
	echo anchor('school/classes/'.$user_id,'Kelas').' | ';
	echo anchor('school/report/'.$user_id,'Mata Pelajaran');
	
	if ($this->method == 'profiles' || $this->method == 'edit_profiles'){$this->load->view('detail');}
	if ($this->method == 'report'){$this->load->view('report');}
	if ($this->method == 'classes'){$this->load->view('myclass');}
	if ($this->method == 'class_score'){$this->load->view('score');}
} else {

	echo 'Anda terdaftar sebagai '; 
	if ( $this->is_admin){echo ' <b>admin</b> ';};
	if ( $this->is_teacher){echo '<b>Pengajar</b> ';};
	echo 'silakan masuk ke halaman ';
	echo anchor('admin',' admin ');

}

?>