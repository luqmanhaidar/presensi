<?php include ("adm.db.php"); 
include("cnn/CnnNav.php");
?>
<html>
<head>
<title>Matrix Karyawan Universitas Negeri Yogyakarta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<style type="text/css">
body {
  color : #000000;
  background : #ffffff;
  font-family : "Times New Roman", Times, serif;
  font-size : 10pt;
}
table.mytable {border: 1px solid #000000;}
table.mytable td { border: 1px solid #000000;}
table.mytable tr.special td { border: 1px solid #000000;  }
}
</style>
<?php
if (isset($_POST['submit1'])){
	$bulan=$_POST['bulan'];
	$tahun=$_POST['tahun'];
	$hal  =$_POST['hal'];
	$bt=$bulan."-".$tahun;
	$fakk=$_SESSION['userdata']['Fak'];
	if($hal=="all"){
	  $sql= "SELECT distinct(Nama),(NamaLengkap) FROM profile WHERE Jabatan='Karyawan' AND Fak='$fakk' AND status='1' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY sort ASC";
	}else{
	  $sql= "SELECT distinct(Nama),(NamaLengkap) FROM profile WHERE Jabatan='Karyawan' AND Fak='$fakk' AND status='1' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY sort ASC limit $hal";
	}
	$query1 = mysql_query ($sql);
	$sqlrow= "SELECT distinct(Tanggal) FROM presensi LIMIT 31";
	$queryrow= mysql_query($sqlrow);
	$numrow = mysql_num_rows($queryrow);
	switch ($bulan) {
		case '1':  $namabulan = "Januari";   break;
		case '2':  $namabulan = "Februari";  break;						
		case '3':  $namabulan = "Maret";     break;					
		case '4':  $namabulan = "April";     break;
		case '5':  $namabulan = "Mei";       break;						
		case '6':  $namabulan = "Juni";      break;
		case '7':  $namabulan = "Juli";      break;
		case '8':  $namabulan = "Agustus";   break;						
		case '9':  $namabulan = "September"; break;						
		case '10': $namabulan = "Oktober";   break;	
		case '11': $namabulan = "November";  break;	
		case '12': $namabulan = "Desember";						
	}	      
	echo "<h2 align=\"center\">Matrix Karyawan Universitas Negeri Yogyakarta</h2>";
	echo "<p align =\"center\" ><b>Bulan: ".$namabulan." Tahun : ".$tahun."</b></p>";
	echo "<table class=\"mytable\"><tr class=\"special\"><td><b>No</b></td><td style= \"padding-left: 70px; padding-right: 70px; \"><b>Nama</b></td>";
		for ($i=1;$i<=31;$i++) {
		echo "<td><b>Tgl".$i."</b></td>";
		}
    	echo "<td>Jml</td><tr>";
	$a=1;
	$j=0;
	$index=array();
	$x=0;
	$arrays = array();
	while ($data = mysql_fetch_array($query1,MYSQL_ASSOC)) {
	$j++;
	$Row  = countRow("presensi","where login='".$data['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'  AND abs='1'","abs");
        $Row1 = countRow("presensi","where login='".$data['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'  AND abs='2'","abs");
        $Row2 = countRow("presensi","where login='".$data['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'  AND abs='5'","abs");
        $Row3 = countRow("presensi","where login='".$data['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'  AND abs='8'","abs");
        $hdr= $Row+$Row1+$Row2+$Row3;
    	echo "<tr class=\"special\"><td>".$a."</td><td>".$data['NamaLengkap']."</td>";
	//echo $data['NamaLengkap'];
	//echo "</td>";
	for ($day=1; $day<=31; $day++) {
		$dhari=$tahun."-".$bulan."-".$day;
		$index[$j] = "SELECT abs FROM presensi WHERE login='".$data['Nama']."' AND Tanggal = '$dhari' LIMIT 1";
		$query_abs = mysql_query($index[$j]);
		$row = mysql_num_rows($query_abs);
		if($row == 0) {
			echo "<td style=\"background-color:#000;\">xXx</td>"; 
		}
		else {
			$hasil = mysql_fetch_array($query_abs,MYSQL_ASSOC);
			switch($hasil['abs']){
		      case    "1" :
			  echo "<td style=\"background-color:#FFFFFF;\"> H </td>";
			  break;
		      case    "2" :
			  echo "<td style=\"background-color:#FFFFFF;\"> H </td>";
			  break;
		      case    "3" :
			  echo "<td style=\"background-color:#FFFFFF;\"> T </td>";
			  break;
		      case    "4" :
			  echo "<td style=\"background-color:#FFFFFF;\"> I </td>";
			  break;
		      case    "5" :
			  echo "<td style=\"background-color:#FFFFFF;\"> H </td>";
			  break;
		      case    "6" :
			  echo "<td style=\"background-color:#FFFFFF;\"> S </td>";
			  break;
		      case    "7" :
			  echo "<td style=\"background-color:#FFFFFF;\"> C </td>";
			  break;
		      case    "8" :
			  echo "<td style=\"background-color:#FFFFFF;\"> C </td>";
			  break;
		      
		      default     :
			  //echo "<td style=\"background-color:#000;\">xXx</td>";
			  echo "<td style=\"background-color:#FFFFFF;\"> XXX </td>";
			  break;
		  }
		}
		
	} //end FOR
	/**
	$jml[$j]="SELECT abs FROM presensi WHERE login='".$data['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";
	$query_jml=mysql_query($jml[$j]);
	$row_jml=mysql_num_rows($query_jml);
	echo "<td>$row_jml</td>";
	**/
	echo "<td>$hdr</td>";
	echo "</tr>";
	$a++;
	}
 	echo "</table>";
	}

?>
</body>
</html>