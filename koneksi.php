<?php	
		$db_host = "localhost";  // nama host  
		$db_user = "mrcoco";  // username mysql  
		$db_pass = ""; //password isi sesuai setting server Anda.  
		$db_name = "presensi";  // nama database 

		// koneksi ke database  
		$link = mysql_connect($db_host, $db_user, $db_pass) or die ("Ga bisa connect");  
		mysql_select_db ($db_name) or die ("Ga bisa select database");
		$timezone =mysql_query("SET time_zone='Asia/Jakarta'");
		
		function getIP() {
				$ip;
				if (getenv("HTTP_CLIENT_IP"))
				$ip = getenv("HTTP_CLIENT_IP");
				else if(getenv("HTTP_X_FORWARDED_FOR"))
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				else if(getenv("REMOTE_ADDR"))
				$ip = getenv("REMOTE_ADDR");
				else
				$ip = "UNKNOWN";
				return $ip;
		}
		function numRow($table,$where = ""){
				$query  = mysql_query("SELECT COUNT(*) FROM ".$table." ".$where." ");
				$result = mysql_result($query,0,0);
				return $result;
		}
?>