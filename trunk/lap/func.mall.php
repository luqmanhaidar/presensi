<?php
function cariMarixDosen () {
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<h1>Tampil Data Matrik Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan Jurusan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"mdos.php\" >";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "</select>";
	echo "<select name=\"bulan\">";
	echo "<option>Bulan</option>\n";
	echo "<option value=\"01\">Januari</option>\n";
	echo "<option value=\"02\">Februari</option>\n";
	echo "<option value=\"03\">Maret</option>\n";
	echo "<option value=\"04\">April</option>\n";
	echo "<option value=\"05\">Mei</option>\n";
	echo "<option value=\"06\">Juni</option>\n";
	echo "<option value=\"07\">Juli</option>\n";
	echo "<option value=\"08\">Agustus</option>\n";
	echo "<option value=\"09\">September</option>\n";
	echo "<option value=\"10\">Oktober</option>\n";
	echo "<option value=\"11\">November</option>\n";
	echo "<option value=\"12\">Desember</option>\n";
	echo "</select>\n";
	$jur=fetchRow("adm_jurusan","where Jab='Dosen'");
	echo "<select name=\"jur\">";
	echo "<option>Pilih Jurusan</option>\n";
	foreach($jur as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
	echo "<div><br /><br /></div>";
	TampilMatrixDosen ();
}

function cariMatrixKaryawan () {	
	echo "<h1>Tampil Data Matrik Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"mkar.php\">";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "</select>";
	echo "<select name=\"bulan\">";
	echo "<option>Bulan</option>\n";
	echo "<option value=\"01\">Januari</option>\n";
	echo "<option value=\"02\">Februari</option>\n";
	echo "<option value=\"03\">Maret</option>\n";
	echo "<option value=\"04\">April</option>\n";
	echo "<option value=\"05\">Mei</option>\n";
	echo "<option value=\"06\">Juni</option>\n";
	echo "<option value=\"07\">Juli</option>\n";
	echo "<option value=\"08\">Agustus</option>\n";
	echo "<option value=\"09\">September</option>\n";
	echo "<option value=\"10\">Oktober</option>\n";
	echo "<option value=\"11\">November</option>\n";
	echo "<option value=\"12\">Desember</option>\n";
	echo "</select>\n";
        echo "</select>\n";
        echo "<select name=\"bagian\">";
        echo "<option value=\"\"> -Pilih Bagian- </option>\n";
        echo "<option value=\"FT\">Fakultas Teknik</option>\n";
        echo "<option value=\"FBS\">Fakultas Bahasa dan Seni</option>\n";
        echo "<option value=\"FISE\">Fakultas Ilmu Sosial dan Ekonomi</option>\n";
        echo "<option value=\"MIPA\">Fakultas MIPA</option>\n";
        echo "<option value=\"FIP\">Fakultas Ilmu Pendidikan</option>\n";
        echo "<option value=\"FIK\">Fakultas Ilmu Keolahragaan</option>\n";
        echo "<option value=\"PASKA\">Pascasarjana</option>\n";
        echo "<option value=\"BUPK\">BUPK</option>\n";
        echo "<option value=\"BAKI\">BAKI</option>\n";
        echo "<option value=\"PERPUS\">PERPUS</option>\n";
        echo "<option value=\"LEMLIT\">LEMLIT</option>\n";
        echo "<option value=\"PUSKOM\">PUSKOM</option>\n";
        echo "<option value=\"LPM\">LPM</option>\n";
	echo "<option value=\"WATES\">WATES</option>\n";
        echo "</select>\n";
	echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
}

function TampilMatrixDosen () {
	if (isset($_POST['submit'])){
	$jurusan=$_POST['jur'];
	$sql= "SELECT distinct(Nama),(NamaLengkap) FROM profile WHERE Jabatan='Dosen' AND Jurusan='".$jurusan."'";
	$query1 = mysql_query ($sql);
	$sqlrow= "SELECT distinct(Tanggal) FROM presensi";
	$queryrow= mysql_query($sqlrow);
	$numrow = mysql_num_rows($queryrow);
	echo "<table border=\"1px\"><tr><td>Nama</td>";
		for ($i=1;$i<=30;$i++) {
		echo "<td>tgl".$i."</td>";
		}
    	echo "<tr>";
	$j=0;
	$index=array();
	$x=0;
	$arrays = array();
	while ($data = mysql_fetch_array($query1,MYSQL_ASSOC)) {
	$j++;
    	echo "<tr><td>";
	echo $data['NamaLengkap'];
	echo "</td>";
	for ($day=1; $day<=30; $day++) {
		$bulan=$_POST['bulan'];
		$tahun=$_POST['tahun'];
		$dhari=$tahun."-".$bulan."-".$day;
		$index[$j] = "SELECT abs FROM presensi WHERE login='".$data['Nama']."' AND Tanggal = '$dhari' ";
		$query_abs = mysql_query($index[$j]);
		$row = mysql_num_rows($query_abs);
		if($row == 0) {
			echo "<td style=\"background-color:#000000;\"> </td>"; 
		} else {
			$hasil = mysql_fetch_array($query_abs,MYSQL_ASSOC);
			$hasil['abs'] == 0 ? $bg="#000000" : $bg="#FFFFFF";
			echo "<td style=\"background-color:'$bg';\">".$hasil['abs']."</td>";
		}
	} //end FOR
	echo "</tr>";
	}
 	echo "</table>";
	}
}

function TampilMatrixKaryawan () {
	if (isset($_POST['submit1'])){
	$sql= "SELECT distinct(Nama),(NamaLengkap) FROM profile WHERE Jabatan='Karyawan'";
	$query1 = mysql_query ($sql);
	$sqlrow= "SELECT distinct(Tanggal) FROM presensi";
	$queryrow= mysql_query($sqlrow);
	$numrow = mysql_num_rows($queryrow);
	echo "<table border=\"1px\"><tr><td>Nama</td>";
		for ($i=1;$i<=30;$i++) {
		echo "<td>tgl".$i."</td>";
		}
    	echo "<tr>";
	$j=0;
	$index=array();
	$x=0;
	$arrays = array();
	while ($data = mysql_fetch_array($query1,MYSQL_ASSOC)) {
	$j++;
    	echo "<tr><td>";
	echo $data['NamaLengkap'];
	echo "</td>";
	for ($day=1; $day<=30; $day++) {
		$bulan=$_POST['bulan'];
		$tahun=$_POST['tahun'];
		$dhari=$tahun."-".$bulan."-".$day;
		$index[$j] = "SELECT abs FROM presensi WHERE login='".$data['Nama']."' AND Tanggal = '$dhari' ";
		$query_abs = mysql_query($index[$j]);
		$row = mysql_num_rows($query_abs);
		if($row == 0) {
			echo "<td style=\"background-color:#000000;\"> </td>"; 
		} else {
			$hasil = mysql_fetch_array($query_abs,MYSQL_ASSOC);
			$hasil['abs'] == 0 ? $bg="#000000" : $bg="#FFFFFF";
			echo "<td style=\"background-color:'$bg';\">".$hasil['abs']."</td>";
		}
	} //end FOR
	echo "</tr>";
	}
 	echo "</table>";
	}
}

?>