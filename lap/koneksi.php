<?php	
		$db_host = "localhost";  // nama host  
		$db_user = "mrcoco";  // username mysql  
		$db_pass = "northface"; //password isi sesuai setting server Anda.  
		$db_name = "presensi";  // nama database 

		// koneksi ke database  
		$link = mysql_connect ($db_host, $db_user, $db_pass) or die ("Ga bisa connect");  
		mysql_select_db ($db_name) or die ("Ga bisa select database"); 
?>
