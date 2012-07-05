<?php
function DaftarKaryawan($x_fak){
	$fakk=$_SESSION['userdata']['Fak'];
	//$form  = "<br /><br />";
	$form .= "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	$form .= "<br />";
	$form .= "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	$form .= "<form method=\"post\" class=\"nice\">";
	$form .= "<p class=\"left\">";
	$form .= "<label><b>Tahun</b></label>";
	$form .= "<select name=\"tahun\" class=\"inputText\">";
	//$form .= "<option>Tahun</option>\n";
	for ($i=2009; $i<=2020; $i++) {
                $form .= "<option value=\"$i\">".$i."</option>\n";
            }
	$form .= "</select>";
	$form .= "<label><b>Bulan</b></label>";
	$form .= "<select name=\"bulan\" class=\"inputText\">";
	//$form .= "<option>Bulan</option>\n";
	$form .= "<option value=\"01\">Januari</option>\n";
	$form .= "<option value=\"02\">Februari</option>\n";
	$form .= "<option value=\"03\">Maret</option>\n";
	$form .= "<option value=\"04\">April</option>\n";
	$form .= "<option value=\"05\">Mei</option>\n";
	$form .= "<option value=\"06\">Juni</option>\n";
	$form .= "<option value=\"07\">Juli</option>\n";
	$form .= "<option value=\"08\">Agustus</option>\n";
	$form .= "<option value=\"09\">September</option>\n";
	$form .= "<option value=\"10\">Oktober</option>\n";
	$form .= "<option value=\"11\">November</option>\n";
	$form .= "<option value=\"12\">Desember</option>\n";
	$form .= "</select>\n";
	$form .= "</p>";
	$form .= "<p class=\"right\">";
	switch($x_fak){
		case "BAKI"	:
			$User = fetchRow ("profile","where Fak='BAKI' AND bag='".$fakk."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
			
			break;
		case "BUPK"	:
			$User = fetchRow ("profile","where Fak='BUPK' AND bag='".$fakk."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
			break;
		case "WATES"	:
			$User = fetchRow ("profile","where bag='WATES' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
			break;
		default		:
			//$User= array('1'=>'2','2'=>'2');
			$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
			break;
	}
	$form .= "<label><b>Nama</b></label>";
	$form .= "<select name=\"User\" class=\"inputText\">";
	foreach ($User as $t) {
		$form .= "<option value=\"".$t[Nama]."\">".$t[NamaLengkap]."</option>\n";
	}
	$form .= "</select>\n";
	$form .= "<br clear=\"all\" />";
	$form .= "<br />";
	$form .= "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	$form .= "</p>";
	$form .= "<div class=\"clear\"></div>";
	$form .= "</form>";
	echo $form;
	//print_r($_POST);
	TampilKaryawan ();
}

/**
function FormBiro($x_fak){
	$bag=$_SESSION['userdata']['Fak'];
	$form  = "<br /><br />";
	$form .= "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	$form .= "<br />";
	$form .= "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	$form .= "<form method=\"post\" class=\"nice\">";
	$form .= "<select name=\"tahun\" class=\"inputTS\">";
	$form .= "<option>Tahun</option>\n";
	for ($i=2009; $i<=2020; $i++) {
                $form .= "<option value=\"$i\">".$i."</option>\n";
            }
	$form .= "</select>";
	$form .= "<select name=\"bulan\" class=\"inputTS\">";
	$form .= "<option>Bulan</option>\n";
	$form .= "<option value=\"01\">Januari</option>\n";
	$form .= "<option value=\"02\">Februari</option>\n";
	$form .= "<option value=\"03\">Maret</option>\n";
	$form .= "<option value=\"04\">April</option>\n";
	$form .= "<option value=\"05\">Mei</option>\n";
	$form .= "<option value=\"06\">Juni</option>\n";
	$form .= "<option value=\"07\">Juli</option>\n";
	$form .= "<option value=\"08\">Agustus</option>\n";
	$form .= "<option value=\"09\">September</option>\n";
	$form .= "<option value=\"10\">Oktober</option>\n";
	$form .= "<option value=\"11\">November</option>\n";
	$form .= "<option value=\"12\">Desember</option>\n";
	$form .= "</select>\n";
	$User = fetchRow ("profile","where Fak='BAUK' AND bag='".$bag."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
	$form .= "<select name=\"User\" class=\"inputTS\">";
	foreach ($User as $t) {
		$form .= "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	$form .= "</select>\n";
	$form .= "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	$form .= "</form>";
	echo $form;
	TampilKaryawan ();
}
**/
/**
function FormBAUK(){
	$bag=$_SESSION['userdata']['Fak'];
	$form  = "<br /><br />";
	$form .= "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	$form .= "<br />";
	$form .= "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	$form .= "<form method=\"post\" class=\"nice\">";
	$form .= "<select name=\"tahun\" class=\"inputTS\">";
	$form .= "<option>Tahun</option>\n";
	for ($i=2009; $i<=2020; $i++) {
                $form .= "<option value=\"$i\">".$i."</option>\n";
            }
	$form .= "</select>";
	$form .= "<select name=\"bulan\" class=\"inputTS\">";
	$form .= "<option>Bulan</option>\n";
	$form .= "<option value=\"01\">Januari</option>\n";
	$form .= "<option value=\"02\">Februari</option>\n";
	$form .= "<option value=\"03\">Maret</option>\n";
	$form .= "<option value=\"04\">April</option>\n";
	$form .= "<option value=\"05\">Mei</option>\n";
	$form .= "<option value=\"06\">Juni</option>\n";
	$form .= "<option value=\"07\">Juli</option>\n";
	$form .= "<option value=\"08\">Agustus</option>\n";
	$form .= "<option value=\"09\">September</option>\n";
	$form .= "<option value=\"10\">Oktober</option>\n";
	$form .= "<option value=\"11\">November</option>\n";
	$form .= "<option value=\"12\">Desember</option>\n";
	$form .= "</select>\n";
	$User = fetchRow ("profile","where Fak='BAUK' AND bag='".$bag."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
	$form .= "<select name=\"User\" class=\"inputTS\">";
	foreach ($User as $t) {
		$form .= "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	$form .= "</select>\n";
	$form .= "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	$form .= "</form>";
	echo $form;
	TampilKaryawan ();
}
**/
/**
function FormBAAKPSI(){
	$bag=$_SESSION['userdata']['Fak'];
	$form  = "<br /><br />";
	$form .= "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	$form .= "<br />";
	$form .= "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	$form .= "<form method=\"post\" class=\"nice\">";
	$form .= "<select name=\"tahun\" class=\"inputTS\">";
	$form .= "<option>Tahun</option>\n";
	for ($i=2009; $i<=2020; $i++) {
                $form .= "<option value=\"$i\">".$i."</option>\n";
            }
	$form .= "</select>";
	$form .= "<select name=\"bulan\" class=\"inputTS\">";
	$form .= "<option>Bulan</option>\n";
	$form .= "<option value=\"01\">Januari</option>\n";
	$form .= "<option value=\"02\">Februari</option>\n";
	$form .= "<option value=\"03\">Maret</option>\n";
	$form .= "<option value=\"04\">April</option>\n";
	$form .= "<option value=\"05\">Mei</option>\n";
	$form .= "<option value=\"06\">Juni</option>\n";
	$form .= "<option value=\"07\">Juli</option>\n";
	$form .= "<option value=\"08\">Agustus</option>\n";
	$form .= "<option value=\"09\">September</option>\n";
	$form .= "<option value=\"10\">Oktober</option>\n";
	$form .= "<option value=\"11\">November</option>\n";
	$form .= "<option value=\"12\">Desember</option>\n";
	$form .= "</select>\n";
	$User = fetchRow ("profile","where Fak='BAAKPSI' AND bag='".$bag."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
	$form .= "<select name=\"User\" class=\"inputTS\">";
	foreach ($User as $t) {
		$form .= "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	$form .= "</select>\n";
	$form .= "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	$form .= "</form>";
	echo $form;
	TampilKaryawan();
}
**/
function FormKarFT(){
	$fakk=$_SESSION['userdata']['Fak'];
	$form  = "<br /><br />";
	$form .= "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	$form .= "<br />";
	$form .= "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	$form .= "<form method=\"post\" class=\"nice\">";
	$form .= "<select name=\"tahun\" class=\"inputTS\">";
	$form .= "<option>Tahun</option>\n";
	for ($i=2009; $i<=2020; $i++) {
                $form .= "<option value=\"$i\">".$i."</option>\n";
            }
	$form .= "</select>";
	$form .= "<select name=\"bulan\" class=\"inputTS\">";
	$form .= "<option>Bulan</option>\n";
	$form .= "<option value=\"01\">Januari</option>\n";
	$form .= "<option value=\"02\">Februari</option>\n";
	$form .= "<option value=\"03\">Maret</option>\n";
	$form .= "<option value=\"04\">April</option>\n";
	$form .= "<option value=\"05\">Mei</option>\n";
	$form .= "<option value=\"06\">Juni</option>\n";
	$form .= "<option value=\"07\">Juli</option>\n";
	$form .= "<option value=\"08\">Agustus</option>\n";
	$form .= "<option value=\"09\">September</option>\n";
	$form .= "<option value=\"10\">Oktober</option>\n";
	$form .= "<option value=\"11\">November</option>\n";
	$form .= "<option value=\"12\">Desember</option>\n";
	$form .= "</select>\n";
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Karyawan' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' ORDER BY NamaLengkap ASC");
	$form .= "<select name=\"User\" class=\"inputTS\">";
	foreach ($User as $t) {
		$form .= "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	$form .= "</select>\n";
	$form .= "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	$form .= "</form>";
	echo $form;
	//print_r($_POST);
	KarFT();
}

function DaftarDosen(){
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<br /><br />";
	echo "<h1>Rekap Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<p class=\"left\">";
	echo selectBT();
	echo "</p>";
	echo "<p class=\"right\">";
	$userjurusan=$_SESSION['userdata']['uname'];
	switch ($userjurusan){
		case 'elka':
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Elektronika' ORDER BY NamaLengkap ASC");
		break;
		case 'elektro':
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Elektro' ORDER BY NamaLengkap ASC");
		break;
		case 'mesin':
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Mesin' ORDER BY NamaLengkap ASC");
		break;
		case 'otomotif':
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Otomotif' ORDER BY NamaLengkap ASC");
		break;
		case 'TSP':
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='SipilPerencanaan' ORDER BY NamaLengkap ASC");
		break;
		case 'PTBB':
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='BogaBusana' ORDER BY NamaLengkap ASC");
		break;
		default:
		$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' ORDER BY NamaLengkap ASC");
		break;
	
	}
//	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' ORDER BY NamaLengkap ASC");
	echo "<label><b>Nama</b></label>";
	echo "<select name=\"User\" class=\"inputText\">";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	echo "</select>\n";
	echo "<br clear=\"all\" />";
	//echo "</td><td>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	//echo "</td></tr>";
	//echo "</table>";
	echo "</p>";
	echo "<div class=\"clear\"></div>";
	echo "</form>\n";
	TampilDosen ();
}



function TampilDosen (){
	$fakk  = $_SESSION['userdata']['Fak'];
	$bulan = stripslashes ($_POST['bulan']);
	$tahun = stripslashes ($_POST['tahun']);
	$User  = $_POST['User'];
	$bt    = $bulan."-".$tahun;
	$noUrut= 1;
	if (isset($_POST['submit'])){
	$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal,presensi.abs, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND profile.Nama=presensi.login AND presensi.login = '$User'  ORDER BY presensi.Tanggal";
	$SQL   = "SELECT id FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4' LIMIT 23";
	$SQL1  = "SELECT id FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3' LIMIT 23";	
	$SQL2  = "SELECT JmlHari FROM harikerja WHERE Bulan='$bt'";
	$SQL3  = "SELECT id FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='1' LIMIT 23";
	$SQL4  = "SELECT id FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5' LIMIT 23";
	$Data  = mysql_query($Query);
	$Data1 = mysql_query($SQL);
	$Data2 = mysql_query($SQL1);
	$Data3 = mysql_query($SQL2);
	$Data4 = mysql_query($SQL3);
	$Data5 = mysql_query($SQL4);
	$tugas = mysql_num_rows($Data2);
	$ijin  = mysql_num_rows($Data1);
	$hadir1 = mysql_num_rows($Data4);
	$hadir2 = mysql_num_rows($Data5);
	$hadir  = $hadir1+$hadir2;
	$num_rows = mysql_num_rows($Data);
	//$obj  = mysql_fetch_object($Data3);
	//$hari = $obj->JmlHari;
	$Tawal 	     = "1-".$bulan."-".$tahun;
	$Takhir	     = "31-".$bulan."-".$tahun;
	$JmlSabtu    = hitung_sabtu($Tawal,$Takhir);
	//$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bulan,$tahun);
	$JmlMinggu   = count_minggu($JmlHari,$bulan,$tahun);
	$libur       = numRow("hari_libur","where date_format(Tanggal,'%m-%Y')='".$bt."'","id");
	$hariNormal = $JmlHari - $JmlMinggu - $JmlSabtu - $libur;
	$abs = $hariNormal-$hadir-$tugas-$ijin;
	echo "<form method=\"post\" action=\"prints.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th><th><b>Ket</b></th></tr>";
	while ($Hasil=mysql_fetch_array($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".dateConv($Hasil['Tanggal'])."</td><td>".indonesian_date($Hasil['hari'])."</td>";
	if($Hasil['JamMasuk'] == '00:00:00')
	{
		echo "<td><b>IJIN</b></td></tr>";
	}
	else
	{
		echo "<td>".$Hasil['JamMasuk']."</td>";
	}
	switch($Hasil['abs']){
		case "1" :
			echo "<td>Hadir</td></tr>";
			break;
		case "4" :
			echo "<td>Izin Alasan Penting</td></tr>";					
			break;
		case "3" :
			echo "<td>Tugas Dinas</td></tr>";
			break;
		case "5" :
			echo "<td>Manual/Lupa</td></tr>";
			break;
		case "6" :
			echo "<td>Izin Sakit</td></tr>";
			break;
		default  :
			echo "<td>".$Hasil['abs']."</td></tr>";
			break;
	}
	$noUrut++;
	}
	echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\" ><b>Jumlah Tugas Dinas</b></th><th>".$tugas." Hari</th></tr>";
	echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\" ><b>Jumlah Izin Alasan Penting</b></th><th>".$ijin." Hari</th></tr>";
	echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$hadir." Hari</th></tr>";
	echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\" ><b>Jumlah Tidak Masuk</b></th><th>".$abs." Hari</th></tr>";
	echo "</table>";
	$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /></p> ";
	//echo "Hari Kerja". $hariNormal."<br />";
	//echo "Hadir". $hadir."<br />";
	//echo "Tugas". $tugas."<br />";
	//echo "Ijin". $ijin."<br />";
	//echo "<br />";
	//echo $SQL1;
	}
}


function TampilKaryawan (){
	$bulan = stripslashes ($_POST['bulan']);
	$tahun = stripslashes ($_POST['tahun']);
	$User  = stripslashes ($_POST['User']);
	$bt    = $bulan."-".$tahun;
	//Hitung jam Kerja
	/**
	$awal   = "1-".$bulan."-".$tahun;
        $akhir  = "31-".$bulan."-".$tahun;
        $Jml_sabtu = hitung_sabtu($awal,$akhir);
        $Jml_minggu= hitung_minggu($awal,$akhir);
	$Jml_jumat = hitung_jumat($awal,$akhir);
        $Jml_hari  = hitung_hari($x,$y);
        $Jml_hari_x= $Jml_hari - $Jml_minggu -$Jml_sabtu-$Jml_jumat;
        $JK_biasa  = $Jml_hari_x*9;
        $JK_sabtu  = $Jml_sabtu*5;
        $JamKerja=$JK_sabtu+$JK_biasa;
        $JK_total=$JamKerja.":00:00";
        **/
	// END
	$Tawal 	     = "1-".$bulan."-".$tahun;
	$Takhir	     = "31-".$bulan."-".$tahun;
	$JmlSabtu    = hitung_sabtu($Tawal,$Takhir);
	//$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bulan,$tahun);
	$JmlMinggu   = count_minggu($JmlHari,$bulan,$tahun);
	$libur       = numRow("hari_libur","where date_format(Tanggal,'%m-%Y')='".$bt."'","id");
	$ThariNormal = $JmlHari - $JmlMinggu - $JmlSabtu - $JmlJumat - $libur;
	$JkNormal    = jamKerja('8:00',$ThariNormal);
	$JkJumat     = jamKerja('5:30',$JmlJumat);
	//$JkTotal     = $JkNormal['tampil'] + $JkJumat['tampil'];
	$JkTotal     = sum_the_time($JkNormal['tampil'],$JkJumat['tampil']);
	$noUrut= 1;
	$i     = 0;
	$jJumat=array();
	//$z     = 1;
	if (isset($_POST['submit'])){
	$Query   = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
		profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
		presensi.id, presensi.JamMasuk,presensi.FotoMasuk,presensi.FotoKeluar,
		presensi.JamKeluar,presensi.Tanggal,presensi.abs,
		date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile
		WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$User' AND profile.Jurusan <> 'PKL' AND profile.Jurusan <> 'Umper/Cleaning' ORDER BY Tanggal ASC LIMIT 23";
	$Query1  = "SELECT NamaLengkap, Nip FROM profile WHERE Nama='$User' LIMIT 1";
	$Query2  = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	//$Query3  = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
	$Query4  = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND login='$User' AND JamMasuk <> '00:00:00'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	$Query5  = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND JamMasuk <> '00:00:00' AND login='$User'
		AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	$Query6  = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'
		AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 AND JamMasuk <> '00:00:00' LIMIT 23";
	$Query7  = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1'
		AND login = '$User' LIMIT 23";
	$Query8  = "SELECT id FROM presensi WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";
	$Query9  = "SELECT id FROM presensi WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";
	$Query10 = "SELECT id FROM presensi WHERE login='$User' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL 
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";
	$Query11 = "SELECT id FROM presensi WHERE login='$User' AND JamMasuk = '00:00:00' AND JamKeluar = '00:00:00' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'";
	$ijinAP  = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4'"),0,0);
	$tugas   = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3'"),0,0);
	$sakit   = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6'"),0,0);
	$manual  = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5'"),0,0);
	$cuti    = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='7'"),0,0);
	$Data1   = mysql_query($Query1);
	$Data    = mysql_query($Query);
	$Data2   = mysql_query($Query2);
	//$Data3   = mysql_query($Query3);
	$Data4   = mysql_query($Query4);
	$Data5   = mysql_query($Query5);
	$Data6   = mysql_query($Query6);
	$Data7   = mysql_query($Query7);
	$Data8   = mysql_query($Query8);
	$Data9   = mysql_query($Query9);
	$Data10  = mysql_query($Query10);
	$Data11  = mysql_query($Query11);
	$bolos   = mysql_num_rows($Data5);
	$bolos1  = mysql_num_rows($Data6);
	$bolos2  = mysql_num_rows($Data8);
	$bolos3  = mysql_num_rows($Data9);
	$telat   = mysql_num_rows($Data4);
	$telat1  = mysql_num_rows($Data10);
	$ijin    = mysql_num_rows($Data11);
	$ttlbolos  = $bolos + $bolos1+$bolos2+$bolos3;
	$ttltelat  = $telat + $telat1;
	$hadir     = mysql_num_rows($Data7);
	$kehadiran = $hadir+$manual;
	$Hasil1    = mysql_fetch_assoc($Data2);
	//$Hasil2    = mysql_fetch_assoc($Data3);
	$Hasil     = mysql_fetch_assoc($Data1);
	//echo $Query;
	//echo "<table>";
	//echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Hasil['NamaLengkap']."</td></tr>";
	//echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Hasil['Nip']."</td></tr>";
	//echo "</table>";
	echo "<form method=\"post\" action=\"printz.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Tanggal</b></th><th><b>Datang</b></th><th><b>Pulang</b></th><th><b>JamKerja</b></th></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$hasil['FotoKeluar']."\" title=\"Foto Keluar ".$Hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoKeluar']."' width='95'></a></td><td>".dateConv($hasil['Tanggal'])."</td>";
	$day= indonesian_date($hasil['hari']);
	if($hasil['hari']  == 'Fri')
	{
		$jJumat[$i]=$hasil['hari'];
	}else
	{ $jMinggu[$i]=$hasil['hari']; }
	
	//echo "<td>".$day."</td>";
	/**
	if($hasil['JamMasuk'] == '00:00:00' && $hasil['JamKeluar'] == '00:00:00')
		{
			echo "<td><b>IJIN</b></td><td><b>IJIN</b></td>";
			//$jamkerja == '00:00:00';
		}
		else
		{
			echo "<td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td>";
		}
	**/
	switch ($hasil['abs']){
			case '3'	:
				$jMasuk = "DINAS LUAR";
				$jKeluar= "DINAS LUAR";
				break;
				
			case '4'	:
				//$jKerja = "IZIN AP";
				$jMasuk = "IZIN AP";
				$jKeluar= "IZIN AP";
				break;
			case '6'	:
				$jMasuk = "SAKIT";
				$jKeluar= "SAKIT";
				break;
			default		:
				$jMasuk	= $hasil['JamMasuk'];
				$jKeluar= $hasil['JamKeluar'];
				break;
	}
	echo "<td>".$jMasuk."</td><td>".$jKeluar."</td>";
	if($hasil['hari'] == 'Fri'){
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				$jamkerja == '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja = '00:00:00';
				}else{
					$jamkerja = TimeDiff('01:30:00',$hasil['selisih']);
				}
				
			}
		}
	}else{
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				$jamkerja = '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja  = '00:00:00';
				}else{
					$jamkerja  = TimeDiff('00:30:00',$hasil['selisih']);
				}
				
			}
		}
	}
	echo "<td>".$jamkerja."</td></tr>";
	$noUrut++;
	$i++;
	}
	$jumat  = count($jJumat);
	$jhari  = $noUrut - $jumat -1;
	$Ijumat = jamKerja('1:30',$jumat);
	$Inormal= jamKerja('0:30',$jhari);
	
	$istrht = sum_the_time($Ijumat['tampil'],$Inormal['tampil']);
	$sql	= mysql_query("SELECT TIMEDIFF('".$Hasil1['jumlah']."','".$istrht."')");
	$Total  = mysql_result($sql, 0, 0);
	$SQL_lk = mysql_query("SELECT TIMEDIFF('$JkTotal','$Total')");
	$lk	= mysql_result($SQL_lk,0,0);
	if($lk < 0){
		$SQL_lbh    = mysql_query("SELECT TIMEDIFF('$Total','$JkTotal')");
		$kelebihan  = mysql_result($SQL_lbh,0,0);
		$kekurangan = 0;
	}else{
		$kelebihan  = 0;
		$kekurangan = $lk;
	}
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja Bulan ini</b></th><th>".$JkTotal."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja pegawai</b></th><th>".$Total."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kekurangan Jam Kerja</b></th><th>".$kekurangan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kelebihan Jam Kerja</b></th><th>".$kelebihan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$kehadiran."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Datang Terlambat</b></th><th>".$ttltelat."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Pulang Awal</b></th><th>".$ttlbolos."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Alasan Penting</b></th><th>".$ijinAP."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Sakit</b></th><th>".$sakit."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Tugas Dinas</b></th><th>".$tugas."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Cuti</b></th><th>".$cuti."&nbsp;Kali</th></tr>";
	echo "</table>";
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
	echo "c. Jam Kerja hari biasa (Senin s/d kamis) = Jam Pulang - Jam Datang - Istirahat 30 menit <br />";
	echo "d. Jam Kerja hari Jumat = Jam Pulang - Jam Datang - Istirahat 1 jam 30 menit <br />";
	echo "e. Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.11<br />";
	echo "f.  Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
	echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
	}
}

function KarFT (){
	$bulan = stripslashes ($_POST['bulan']);
	$tahun = stripslashes ($_POST['tahun']);
	$User  = stripslashes ($_POST['User']);
	$bt    = $bulan."-".$tahun;
	$Tawal 	     = "1-".$bulan."-".$tahun;
	$Takhir	     = "31-".$bulan."-".$tahun;
	$JmlSabtu    = hitung_sabtu($Tawal,$Takhir);
	$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bulan,$tahun);
	$libur       = numRow("hari_libur","where date_format(Tanggal,'%m-%Y')='".$bt."'","id");
	$ThariNormal = $JmlHari - $JmlMinggu - $JmlSabtu - $JmlJumat - $libur;
	$JhariKerja  = $JmlHari - $JmlMinggu - $JmlSabtu - $libur;
	$JkNormal    = jamKerja('8:30',$ThariNormal);
	$JkJumat     = jamKerja('7:00',$JmlJumat);
	//$JkTotal     = $JkNormal['tampil'] + $JkJumat['tampil'];kkkk
	$JkTotal     = sum_the_time($JkNormal['tampil'],$JkJumat['tampil']);
	$noUrut= 1;
	$i     = 0;
	$jJumat=array();
	//$z     = 1;
	if (isset($_POST['submit'])){
	$Query   = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
		profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
		presensi.id, presensi.JamMasuk,presensi.FotoMasuk,presensi.FotoKeluar, presensi.JamKeluar,presensi.Tanggal,presensi.abs,
		date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile
		WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$User' AND profile.Jurusan <> 'PKL' AND profile.Jurusan <> 'Umper/Cleaning' ORDER BY Tanggal ASC LIMIT 23";
	
	$Query2  = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	//	
	$telat   = countRow("presensi","WHERE JamMasuk >=071600 AND login='$User' AND JamMasuk <> '00:00:00' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
	$bolos	 = countRow("presensi","WHERE JamKeluar <=152959 AND JamMasuk <> '00:00:00' AND login='$User' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
	$bolos1  = countRow("presensi","WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 AND JamMasuk <> '00:00:00' LIMIT 23");
	$hadir   = countRow("presensi","WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1' AND login = '$User' LIMIT 23");	
	$bolos2  = countRow("presensi","WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'");	
	$bolos3  = countRow("presensi","WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'");		
	$telat1  = countRow("presensi","WHERE login='$User' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'");		
	$ijin    = countRow("presensi","WHERE login='$User' AND JamMasuk = '00:00:00' AND JamKeluar = '00:00:00' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'");
	$ijinAP  = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4'");
	$tugas   = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3'");
	$sakit   = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6'");
	$manual  = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5'");
	
	$Data    = mysql_query($Query);
	$Data2   = mysql_query($Query2);
	$ttlbolos  = $bolos + $bolos1+$bolos2+$bolos3;
	$ttltelat  = $telat + $telat1;
	$kehadiran = $hadir+$manual;
	$Hasil1    = mysql_fetch_assoc($Data2);
	$PK	   = $kehadiran / $JhariKerja * 100;
	$PI	   = $ijinAP / $Jharikerja * 100;
	$PT        = $tugas / $JhariKerja * 100;
	$PS        = $sakit / $JhariKerja *100;
	$PTT	   = $ttltelat / $JhariKerja *100;
	$PPA	   = $ttlbolos / $Jharikerja *100;
	echo "<form method=\"post\" action=\"printz.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<input name=\"bag\" type=\"hidden\" value=\"ft\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th><th><b>Pulang</b></th><th><b>JamKerja</b></th><th>Tampil Foto</th></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
	$day= indonesian_date($hasil['hari']);
	if($hasil['hari']  == 'Fri')
	{
		$jJumat[$i]=$hasil['hari'];
	}else
	{ $jMinggu[$i]=$hasil['hari']; }
	
	echo "<td>".$day."</td>";
	switch ($hasil['abs']){
			case '3'	:
				$jMasuk = "DINAS LUAR";
				$jKeluar= "DINAS LUAR";
				break;
				
			case '4'	:
				//$jKerja = "IZIN AP";
				$jMasuk = "IZIN AP";
				$jKeluar= "IZIN AP";
				break;
			case '6'	:
				$jMasuk = "SAKIT";
				$jKeluar= "SAKIT";
				break;
			default		:
				$jMasuk	= $hasil['JamMasuk'];
				$jKeluar= $hasil['JamKeluar'];
				break;
	}
	echo "<td>".$jMasuk."</td><td>".$jKeluar."</td>";
	if($hasil['hari'] == 'Fri'){
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				$jamkerja == '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja = '00:00:00';
				}else{
					//$jamkerja = TimeDiff('01:30:00',$hasil['selisih']);
					$jamkerja = $hasil['selisih'];
				}
				
			}
		}
	}else{
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				$jamkerja = '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja  = '00:00:00';
				}else{
					//$jamkerja  = TimeDiff('00:30:00',$hasil['selisih']);
					$jamkerja = $hasil['selisih'];
				}
				
			}
		}
	}
	echo "<td>".$jamkerja."</td><td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\">Masuk</a>|<a href=\"../".$hasil['FotoKeluar']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\">Keluar</a></td></tr>";
	$noUrut++;
	$i++;
	}
	$Total  = $Hasil1['jumlah'];
	$SQL_lk = mysql_query("SELECT TIMEDIFF('$JkTotal','$Total')");
	$lk	= mysql_result($SQL_lk,0,0);
	if($lk < 0){
		$SQL_lbh    = mysql_query("SELECT TIMEDIFF('$Total','$JkTotal')");
		$kelebihan  = mysql_result($SQL_lbh,0,0);
		$kekurangan = 0;
	}else{
		$kelebihan  = 0;
		$kekurangan = $lk;
	}
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja Bulan ini</b></th><th>".$JkTotal."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja pegawai</b></th><th>".$Total."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kekurangan Jam Kerja</b></th><th>".$kekurangan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kelebihan Jam Kerja</b></th><th>".$kelebihan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$kehadiran."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Datang Terlambat</b></th><th>".$ttltelat."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Pulang Awal</b></th><th>".$ttlbolos."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Alasan Penting</b></th><th>".$ijinAP."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Sakit</b></th><th>".$sakit."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Tugas Dinas</b></th><th>".$tugas."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Prosentase Kehadiran</b></th><th>".round($PK,2)."&nbsp;%</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Prosentase Izin AP</b></th><th>".round($PI,2)."&nbsp;%</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Prosentase Tugas Dinas</b></th><th>".round($PT,2)."&nbsp;%</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Prosentase Izin Sakit</b></th><th>".round($PS,2)."&nbsp;%</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Prosentase Terlambat</b></th><th>".round($PTT,2)."&nbsp;%</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Prosentase Pulang Awal</b></th><th>".round($PPA,2)."&nbsp;%</th></tr>";
	echo "</table>";
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
	echo "c. Jam Kerja hari biasa (Senin s/d kamis) = Jam Pulang - Jam Datang - Istirahat 30 menit <br />";
	echo "d. Jam Kerja hari Jumat = Jam Pulang - Jam Datang - Istirahat 1 jam 30 menit <br />";
	echo "e. Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.16<br />";
	echo "f.  Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
	echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
	echo $libur;
	}
}

function KarBAAKPSI(){
	$bulan = stripslashes ($_POST['bulan']);
	$tahun = stripslashes ($_POST['tahun']);
	$User  = stripslashes ($_POST['User']);
	$bt    = $bulan."-".$tahun;
	$Tawal 	     = "1-".$bulan."-".$tahun;
	$Takhir	     = "31-".$bulan."-".$tahun;
	$JmlSabtu    = hitung_sabtu($Tawal,$Takhir);
	//$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bulan,$tahun);
	$JmlMinggu   = count_minggu($JmlHari,$bulan,$tahun);
	$libur       = numRow("hari_libur","where date_format(Tanggal,'%m-%Y')='".$bt."'","id");
	$ThariNormal = $JmlHari - $JmlMinggu - $JmlSabtu - $JmlJumat - $libur;
	$JkNormal    = jamKerja('8:00',$ThariNormal);
	$JkJumat     = jamKerja('5:30',$JmlJumat);
	//$JkTotal     = $JkNormal['tampil'] + $JkJumat['tampil'];kkkk
	$JkTotal     = sum_the_time($JkNormal['tampil'],$JkJumat['tampil']);
	$noUrut= 1;
	$i     = 0;
	$jJumat=array();
	//$z     = 1;
	if (isset($_POST['submit'])){
	$Query   = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
		profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
		presensi.id, presensi.JamMasuk, presensi.JamKeluar,presensi.Tanggal,presensi.abs,
		date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile
		WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$User' AND profile.Jurusan <> 'PKL' AND profile.Jurusan <> 'Umper/Cleaning' ORDER BY Tanggal ASC LIMIT 23";
	
	$Query2  = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	//	
	$telat   = countRow("presensi","WHERE JamMasuk >=071100 AND login='$User' AND JamMasuk <> '00:00:00' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
	$bolos	 = countRow("presensi","WHERE JamKeluar <=152959 AND JamMasuk <> '00:00:00' AND login='$User' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
	$bolos1  = countRow("presensi","WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 AND JamMasuk <> '00:00:00' LIMIT 23");
	$hadir   = countRow("presensi","WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1' AND login = '$User' LIMIT 23");	
	$bolos2  = countRow("presensi","WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'");	
	$bolos3  = countRow("presensi","WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'");		
	$telat1  = countRow("presensi","WHERE login='$User' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'");		
	$ijin    = countRow("presensi","WHERE login='$User' AND JamMasuk = '00:00:00' AND JamKeluar = '00:00:00' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'");
	$ijinAP  = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4'");
	$tugas   = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3'");
	$sakit   = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6'");
	$manual  = countRow("presensi","WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5'");
	
	$Data    = mysql_query($Query);
	$Data2   = mysql_query($Query2);
	$ttlbolos  = $bolos + $bolos1+$bolos2+$bolos3;
	$ttltelat  = $telat + $telat1;
	$kehadiran = $hadir+$manual;
	$Hasil1    = mysql_fetch_assoc($Data2);
	echo "<form method=\"post\" action=\"printz.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<input name=\"bag\" type=\"hidden\" value=\"ft\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th><th><b>Pulang</b></th><th><b>JamKerja</b></th></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Nip']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
	$day= indonesian_date($hasil['hari']);
	if($hasil['hari']  == 'Fri')
	{
		$jJumat[$i]=$hasil['hari'];
	}else
	{ $jMinggu[$i]=$hasil['hari']; }
	
	echo "<td>".$day."</td>";
	switch ($hasil['abs']){
			case '3'	:
				$jMasuk = "DINAS LUAR";
				$jKeluar= "DINAS LUAR";
				break;
				
			case '4'	:
				//$jKerja = "IZIN AP";
				$jMasuk = "IZIN AP";
				$jKeluar= "IZIN AP";
				break;
			case '6'	:
				$jMasuk = "SAKIT";
				$jKeluar= "SAKIT";
				break;
			default		:
				$jMasuk	= $hasil['JamMasuk'];
				$jKeluar= $hasil['JamKeluar'];
				break;
	}
	echo "<td>".$jMasuk."</td><td>".$jKeluar."</td>";
	if($hasil['hari'] == 'Fri'){
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				$jamkerja == '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja = '00:00:00';
				}else{
					//$jamkerja = TimeDiff('01:30:00',$hasil['selisih']);
					$jamkerja = $hasil['selisih'];
				}
				
			}
		}
	}else{
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				$jamkerja = '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja  = '00:00:00';
				}else{
					//$jamkerja  = TimeDiff('00:30:00',$hasil['selisih']);
					$jamkerja = $hasil['selisih'];
				}
				
			}
		}
	}
	echo "<td>".$jamkerja."</td></tr>";
	$noUrut++;
	$i++;
	}
	$Total  = $Hasil1['jumlah'];
	$SQL_lk = mysql_query("SELECT TIMEDIFF('$JkTotal','$Total')");
	$lk	= mysql_result($SQL_lk,0,0);
	if($lk < 0){
		$SQL_lbh    = mysql_query("SELECT TIMEDIFF('$Total','$JkTotal')");
		$kelebihan  = mysql_result($SQL_lbh,0,0);
		$kekurangan = 0;
	}else{
		$kelebihan  = 0;
		$kekurangan = $lk;
	}
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja Bulan ini</b></th><th>".$JkTotal."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja pegawai</b></th><th>".$Total."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kekurangan Jam Kerja</b></th><th>".$kekurangan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kelebihan Jam Kerja</b></th><th>".$kelebihan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$kehadiran."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Datang Terlambat</b></th><th>".$ttltelat."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Pulang Awal</b></th><th>".$ttlbolos."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Alasan Penting</b></th><th>".$ijinAP."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Sakit</b></th><th>".$sakit."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Tugas Dinas</b></th><th>".$tugas."&nbsp;Kali</th></tr>";
	echo "</table>";
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
	echo "c. Jam Kerja hari biasa (Senin s/d kamis) = Jam Pulang - Jam Datang - Istirahat 30 menit <br />";
	echo "d. Jam Kerja hari Jumat = Jam Pulang - Jam Datang - Istirahat 1 jam 30 menit <br />";
	echo "e. Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.16<br />";
	echo "f.  Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
	echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
	}
}
function KarBAUK (){
	$bulan = stripslashes ($_POST['bulan']);
	$tahun = stripslashes ($_POST['tahun']);
	$User  = stripslashes ($_POST['User']);
	$bt    = $bulan."-".$tahun;
	$Tawal 	     = "1-".$bulan."-".$tahun;
	$Takhir	     = "31-".$bulan."-".$tahun;
	$JmlSabtu    = hitung_sabtu($Tawal,$Takhir);
	//$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bulan,$tahun);
	$JmlMinggu   = count_minggu($JmlHari,$bulan,$tahun);
	$libur       = numRow("hari_libur","where date_format(Tanggal,'%m-%Y')='".$bt."'","id");
	$ThariNormal = $JmlHari - $JmlMinggu - $JmlSabtu - $JmlJumat - $libur;
	$JkNormal    = jamKerja('8:00',$ThariNormal);
	$JkJumat     = jamKerja('5:30',$JmlJumat);
	//$JkTotal     = $JkNormal['tampil'] + $JkJumat['tampil'];
	$JkTotal     = sum_the_time($JkNormal['tampil'],$JkJumat['tampil']);
	$noUrut= 1;
	$i     = 0;
	$jJumat=array();
	//$z     = 1;
	if (isset($_POST['submit'])){
	$Query   = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
		profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
		presensi.id, presensi.JamMasuk, presensi.JamKeluar,presensi.Tanggal,presensi.abs,
		date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile
		WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$User' AND profile.Jurusan <> 'PKL' AND profile.Jurusan <> 'Umper/Cleaning' ORDER BY Tanggal ASC LIMIT 23";
	$Query1  = "SELECT NamaLengkap, Nip FROM profile WHERE Nama='$User' LIMIT 1";
	$Query2  = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$User' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	//$Query3  = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
	$Query4  = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND login='$User' AND JamMasuk <> '00:00:00'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	$Query5  = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND JamMasuk <> '00:00:00' AND login='$User'
		AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	$Query6  = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'
		AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 AND JamMasuk <> '00:00:00' LIMIT 23";
	$Query7  = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1'
		AND login = '$User' LIMIT 23";
	$Query8  = "SELECT id FROM presensi WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";
	$Query9  = "SELECT id FROM presensi WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";
	$Query10 = "SELECT id FROM presensi WHERE login='$User' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL 
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";
	$Query11 = "SELECT id FROM presensi WHERE login='$User' AND JamMasuk = '00:00:00' AND JamKeluar = '00:00:00' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'";
	$ijinAP  = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4'"),0,0);
	$tugas   = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3'"),0,0);
	$sakit   = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6'"),0,0);
	$manual  = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5'"),0,0);
	$cuti    = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$User' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='7'"),0,0);
	$Data1   = mysql_query($Query1);
	$Data    = mysql_query($Query);
	$Data2   = mysql_query($Query2);
	//$Data3   = mysql_query($Query3);
	$Data4   = mysql_query($Query4);
	$Data5   = mysql_query($Query5);
	$Data6   = mysql_query($Query6);
	$Data7   = mysql_query($Query7);
	$Data8   = mysql_query($Query8);
	$Data9   = mysql_query($Query9);
	$Data10  = mysql_query($Query10);
	$Data11  = mysql_query($Query11);
	$bolos   = mysql_num_rows($Data5);
	$bolos1  = mysql_num_rows($Data6);
	$bolos2  = mysql_num_rows($Data8);
	$bolos3  = mysql_num_rows($Data9);
	$telat   = mysql_num_rows($Data4);
	$telat1  = mysql_num_rows($Data10);
	$ijin    = mysql_num_rows($Data11);
	$ttlbolos  = $bolos + $bolos1+$bolos2+$bolos3;
	$ttltelat  = $telat + $telat1;
	$hadir     = mysql_num_rows($Data7);
	$kehadiran = $hadir+$manual;
	$Hasil1    = mysql_fetch_assoc($Data2);
	//$Hasil2    = mysql_fetch_assoc($Data3);
	$Hasil     = mysql_fetch_assoc($Data1);
	//echo "<table>";
	//echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Hasil['NamaLengkap']."</td></tr>";
	//echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Hasil['Nip']."</td></tr>";
	//echo "</table>";
	echo "<form method=\"post\" action=\"printz.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th><th><b>Pulang</b></th><th><b>JamKerja</b></th></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
	$day= indonesian_date($hasil['hari']);
	if($hasil['hari']  == 'Fri')
	{
		$jJumat[$i]=$hasil['hari'];
	}else
	{ $jMinggu[$i]=$hasil['hari']; }
	
	echo "<td>".$day."</td>";
	/**
	if($hasil['JamMasuk'] == '00:00:00' && $hasil['JamKeluar'] == '00:00:00')
		{
			echo "<td><b>IJIN</b></td><td><b>IJIN</b></td>";
			//$jamkerja == '00:00:00';
		}
		else
		{
			echo "<td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td>";
		}
	**/
	switch ($hasil['abs']){
			case '3'	:
				$jMasuk = "DINAS LUAR";
				$jKeluar= "DINAS LUAR";
				break;
				
			case '4'	:
				//$jKerja = "IZIN AP";
				$jMasuk = "IZIN AP";
				$jKeluar= "IZIN AP";
				break;
			case '6'	:
				$jMasuk = "SAKIT";
				$jKeluar= "SAKIT";
				break;
			default		:
				$jMasuk	= $hasil['JamMasuk'];
				$jKeluar= $hasil['JamKeluar'];
				break;
	}
	echo "<td>".$jMasuk."</td><td>".$jKeluar."</td>";
	if($hasil['hari'] == 'Fri'){
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				$jamkerja == '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja == '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja = '00:00:00';
				}else{
					$jamkerja = TimeDiff('01:30:00',$hasil['selisih']);
				}
				
			}
		}
	}else{
		if($hasil['JamMasuk']== NULL){
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				$jamkerja = '00:00:00';
			}
		}else{
			if($hasil['JamKeluar']== NULL){
				$jamkerja = '00:00:00';
			}else{
				if($hasil['JamMasuk']== '00:00:00' && $hasil['JamKeluar'] == '00:00:00'){
					$jamkerja  = '00:00:00';
				}else{
					$jamkerja  = TimeDiff('00:30:00',$hasil['selisih']);
				}
				
			}
		}
	}
	echo "<td>".$jamkerja."</td></tr>";
	$noUrut++;
	$i++;
	}
	$jumat  = count($jJumat);
	$jhari  = $noUrut - $jumat -1;
	$Ijumat = jamKerja('1:30',$jumat);
	$Inormal= jamKerja('0:30',$jhari);
	
	$istrht = sum_the_time($Ijumat['tampil'],$Inormal['tampil']);
	$sql	= mysql_query("SELECT TIMEDIFF('".$Hasil1['jumlah']."','".$istrht."')");
	$Total  = mysql_result($sql, 0, 0);
	$SQL_lk = mysql_query("SELECT TIMEDIFF('$JkTotal','$Total')");
	$lk	= mysql_result($SQL_lk,0,0);
	if($lk < 0){
		$SQL_lbh    = mysql_query("SELECT TIMEDIFF('$Total','$JkTotal')");
		$kelebihan  = mysql_result($SQL_lbh,0,0);
		$kekurangan = 0;
	}else{
		$kelebihan  = 0;
		$kekurangan = $lk;
	}
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja Bulan ini</b></th><th>".$JkTotal."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja pegawai</b></th><th>".$Total."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kekurangan Jam Kerja</b></th><th>".$kekurangan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kelebihan Jam Kerja</b></th><th>".$kelebihan."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$kehadiran."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Datang Terlambat</b></th><th>".$ttltelat."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Pulang Awal</b></th><th>".$ttlbolos."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Alasan Penting</b></th><th>".$ijinAP."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Izin Sakit</b></th><th>".$sakit."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Tugas Dinas</b></th><th>".$tugas."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Cuti</b></th><th>".$cuti."&nbsp;Kali</th></tr>";
	echo "</table>";
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
	echo "c. Jam Kerja hari biasa (Senin s/d kamis) = Jam Pulang - Jam Datang - Istirahat 30 menit <br />";
	echo "d. Jam Kerja hari Jumat = Jam Pulang - Jam Datang - Istirahat 1 jam 30 menit <br />";
	echo "e. Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.11<br />";
	echo "f.  Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
	echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
	}
}	
?>