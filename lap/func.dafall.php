<?php
function DaftarKaryawan(){
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<br /><br />";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<table>";
	echo "<tr align=\"center\"><td><b>Tahun</b></td><td><b>Bulan</b></td><td><b>Nama</b></td><td></td></tr>";
	echo "<tr><td>";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "<option value =\"2012\">2012</option>\n";
	echo "<option value =\"2013\">2013</option>\n";
	echo "</select>";
	echo "</td><td>";
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
	echo "</td><td>";
	$User = fetchRow ("profile","where Jabatan='Karyawan' ORDER BY NamaLengkap ASC");
	echo "<select name=\"User\">";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	echo "</select>\n";
	echo "</td><td>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>\n";
	TampilKaryawan ();
}

function DaftarDosen(){
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<br /><br />";
	echo "<h1>Rekap Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<table>";
	echo "<tr align=\"center\"><td><b>Tahun</b></td><td><b>Bulan</b></td><td><b>Nama </b></td><td></td></tr>";
	echo "<tr><td>";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "<option value =\"2012\">2012</option>\n";
	echo "<option value =\"2013\">2013</option>\n";
	echo "</select>";
	echo "</td><td>";
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
	echo "</td><td>";
	$User = fetchRow ("profile","where Jabatan='Dosen' ORDER BY NamaLengkap ASC");
	echo "<select name=\"User\">";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
	echo "</select>\n";
	echo "</td><td>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>\n";
	TampilDosen ();
}

function TampilDosen (){
	$fakk   = $_SESSION['userdata']['Fak'];
	$bulan  = $_POST['bulan'];
	$tahun  = $_POST['tahun'];
	$User   = $_POST['User'];
	$bt     = $bulan."-".$tahun;
	$noUrut = 1;
	if (isset($_POST['submit'])){
	$Query  = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND profile.Nama=presensi.login AND presensi.login = '$User'  ";
	$Data   = mysql_query($Query);
	$num_rows = mysql_num_rows($Data);
	echo "<form method=\"post\" action=\"prints.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th></tr>";
	while ($Hasil=mysql_fetch_array($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".dateConv($Hasil['Tanggal'])."</td><td>".$Hasil['hari']."</td>";
	if($Hasil['JamMasuk'] == '00:00:00')
	{
		echo "<td><b>IJIN</b></td>";
	}else
	{
		echo "<td>".$Hasil['JamMasuk']."</td>";
	}
	
	echo "</tr>";
	$noUrut++;
	}
	echo "<tr><th colspan=\"5\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kedatangan</b></th><th>".$num_rows." Hari</th></tr>";
	echo "</table>";
	$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /></p> ";
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
	$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bulan,$tahun);
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
	$Query3  = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
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
	$Data1   = mysql_query($Query1);
	$Data    = mysql_query($Query);
	$Data2   = mysql_query($Query2);
	$Data3   = mysql_query($Query3);
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
	$Hasil2    = mysql_fetch_assoc($Data3);
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