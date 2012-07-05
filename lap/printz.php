<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Universitas Negeri Yogyakarta | Kehadiran Karyawan <?php echo $_POST['bt'];?> </title>
<style type="text/css">
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	padding: 3px;
}
tr {
	height: 20px;
}
.tableContent{
	border-top-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-left-color: #000000;
}
.tableContent td{
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	border-right-width: 1px;
	border-right-style: solid;
	border-right-color: #000000;
}
#td{
	padding: 0px;
	height: 10px;
}

</style>
</head>
<body onload="window.print()">
<?
require_once("adm.db.php");
include      ("func_date.php");
	$bt     = stripslashes($_POST['bt']);
	$Nip    = stripslashes($_POST['Nip']);
	$Nama   = stripslashes($_POST['Nama']);
	$bag    = stripslashes($_POST['bag']);
	
	if($bag == 'ft'){
		$x_y    = explode ("-",$bt);
		$x	= $x_y[0];
		$y 	= $x_y[1];
		$bln    = bulan_id($x);
		$start  = $y."-".$x."-01";
		$end    = $y."-".$x."-31";
		$libur    = countRow("hari_libur","WHERE Tanggal BETWEEN '".$start."' AND '".$end."'");
		$sabtu    = hitung_sabtu($start,$end);
		//$minggu   = hitung_minggu($start,$end);
		$jumat    = hitung_jumat($start,$end);
		$jmlHari  = hitung_hari($x,$y);
		$minggu   = count_minggu($jmlHari,$x,$y);
		$hNormal  = $jmlHari-$libur-$jumat-$sabtu-$minggu;
		$JkNormal = jamKerja('8:30',$hNormal);
		$JkJumat  = jamKerja('7:00',$jumat);
		$JkTotal  = sum_the_time($JkNormal['tampil'],$JkJumat['tampil']);
		$noUrut   = 1;
		$i        = 0;
		$jJumat   = array();
		$jMinggu  = array();
		$presensi  = fetchRow("profile,presensi","WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
			AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$Nama' ORDER BY Tanggal ASC","TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih, profile.Nip,
			profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.abs,presensi.id, presensi.JamMasuk,
			presensi.JamKeluar,presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari");
		$profile   = fetch("profile","WHERE Nama='$Nama'","NamaLengkap,Nip");
		$jumlah    = fetch("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'","sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah");
		$telat     = countRow("presensi","WHERE JamMasuk >=071600 AND login='$Nama' AND JamMasuk <> '00:00:00'
			AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
		$bolos	   = countRow("presensi","WHERE JamKeluar <=152959 AND login='$Nama' AND JamMasuk <> '00:00:00'
			AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
		$bolos1	   = countRow("presensi","WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND JamMasuk <> '00:00:00'
			AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 LIMIT 23");
		$hadir	   = countRow("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='1' LIMIT 23");
		$bolos2	   = countRow("presensi","WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00'
			AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'");
		$bolos3    = countRow("presensi","WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00'
			AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'");
		$telat1    = countRow("presensi","WHERE login='$Nama' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL 
			AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'");
		$ijinAP    = countRow("presensi","WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4'");
		$tugas     = countRow("presensi","WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3'");
		$sakit     = countRow("presensi","WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6'");
		$manual    = countRow("presensi","WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5'");
		$cuti	   = countRow("presensi","WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='7'");
		$ttlbolos  = $bolos+$bolos1+$bolos2+$bolos3;
		$ttltelat  = $telat + $telat1;
		$kehadiran = $hadir+$manual;
		echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
		echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
		echo "<h2 align=\"center\">Bulan: &nbsp;".$bln." ".$y."</h2>";
		echo "<table>";
		echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$profile['NamaLengkap']."</td></tr>";
		echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$profile['Nip']."</td></tr>";
		echo "<tr><td><b>Unit Kerja&nbsp;</b></td><td>:&nbsp;Sub.Bag&nbsp;".jur_det($Hasil['Jurusan'])."</td></tr>";
		echo "<tr><td><b>Unit Kerja Utama&nbsp;</b></td><td>:&nbsp;".$Hasil['Fak']."</td></tr>";
		echo "</table>";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
		echo "<tr><td><b>No</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Datang</b></td><td><b>Pulang</b></td><td><b>JamKerja</b></td></tr>";
		foreach ($presensi as $pre){	
		echo "<tr><td>".$noUrut."</td><td>".dateConv($pre['Tanggal'])."</td>";
		echo "<td>".indonesian_date($pre['hari'])."</td>";
		if($pre['hari']   == 'Fri'){
			$jJumat[$i]  = $pre['hari'];
			switch ($hasil['abs']){
				case '3'	:
					$jKerja    = TimeDiff('01:30:00',$pre['selisih']);
					$jMasuk = "DINAS LUAR";
					$jKeluar= "DINAS LUAR";
					break;
				case '4'	:
					$jKerja = "IZIN AP";
					$jMasuk = "IZIN AP";
					$jKeluar= "IZIN AP";
					break;
				case '6'	:
					$jKerja = "SAKIT";
					$jMasuk = "SAKIT";
					$jKeluar= "SAKIT";
					break;
				case '7'	:
					$jKerja = "CUTI";
					$jMasuk = "CUTI";
					$jKeluar= "CUTI";
					break;
				default		:
					$jMasuk	= $pre['JamMasuk'];
					$jKeluar= $pre['JamKeluar'];
					if($jMasuk == NULL){
						$jKerja    = '00:00:00';
					}else{
						$jKerja    = TimeDiff('01:30:00',$pre['selisih']);
					}
					break;
			}
			
			
		}else{
			$jMinggu[$i] = $pre['hari'];
			switch ($pre['abs']){
				case '3'	:
					$jKerja    = TimeDiff('00:30:00',$pre['selisih']);
					$jMasuk = "DINAS LUAR";
					$jKeluar= "DINAS LUAR";
					break;
				case '4'	:
					$jKerja = "IZIN AP";
					$jMasuk = "IZIN AP";
					$jKeluar= "IZIN AP";
					break;
				case '6'	:
					$jKerja = "SAKIT";
					$jMasuk = "SAKIT";
					$jKeluar= "SAKIT";
					break;
				case '7'	:
					$jKerja = "CUTI";
					$jMasuk = "CUTI";
					$jKeluar= "CUTI";
					break;
				default		:
					$jMasuk	= $pre['JamMasuk'];
					$jKeluar= $pre['JamKeluar'];
					if($jMasuk == NULL){
						$jKerja    = '00:00:00';
					}else{
						$jKerja    = TimeDiff('00:30:00',$pre['selisih']);
					}
					if($jKeluar == NULL){
						$jKerja   = '00:00:00';
					}
					break;
			}
			
		}
		
		echo "<td>&nbsp;".$jMasuk."</td><td>&nbsp;".$jKeluar."</td><td>&nbsp;".$jKerja."</td></td></tr>";
		$noUrut++;
		$i++;
		}
		$JKpegawai= $jumlah['jumlah'];
		$Sql_lbhkr= mysql_result(mysql_query("SELECT TIMEDIFF('$JkTotal','$JKpegawai')"),0,0);
		if($Sql_lbhkr < 0){
			$lebih  = mysql_result(mysql_query("SELECT TIMEDIFF('$JKpegawai','$JkTotal')"),0,0);
			$kurang = 0;
		}else{
			$lebih  = 0;
			$kurang = $Sql_lbhkr;
		}
		//echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Jam Kerja Bulan ini</b></td><td>".$JkTotal."</td></tr>";
		//echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Jam Kerja Pegawai</b></td><td>".$JKpegawai."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kekurangan Jam Kerja</b></td><td>".$kurang."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kelebihan Jam Kerja</b></td><td>".$lebih."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$kehadiran."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Datang Terlambat</b></td><td>".$ttltelat."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Pulang Awal</b></td><td>".$ttlbolos."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Izin Alasan Penting</b></td><td>".$ijinAP."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Tugas Dinas</b></td><td>".$tugas."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Izin Sakit</b></td><td>".$sakit."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Cuti</b></td><td>".$cuti."&nbsp;Kali</td></tr>";
		echo "</table>";
		echo "<p><b>Keterangan :</b><br />";
		echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
		echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
		echo "c. Jam Kerja hari biasa (Senin s/d kamis) = Jam Pulang - Jam Datang <br />";
		echo "d. Jam Kerja hari Jumat = Jam Pulang - Jam Datang<br />";
		echo "e. Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.16<br />";
		echo "f. Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
		echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
	}else{
		$x_y    = explode ("-",$bt);
		$x	= $x_y[0];
		$y 	= $x_y[1];
		$bln    = bulan_id($x);
		$start  = $y."-".$x."-01";
		$end    = $y."-".$x."-31";
		//$start  = "2011-04-01";
		//$end    = "2011-04-31";
		$libur	  = mysql_result(mysql_query("SELECT COUNT(*) FROM hari_libur WHERE Tanggal BETWEEN '".$start."' AND '".$end."'"),0,0);
		$sabtu    = hitung_sabtu($start,$end);
		//$minggu   = hitung_minggu($start,$end);
		$jumat    = hitung_jumat($start,$end);
		$jmlHari  = hitung_hari($x,$y);
		$minggu   = count_minggu($jmlHari,$x,$y);
		$hNormal  = $jmlHari-$libur-$jumat-$sabtu-$minggu;
		$JkNormal = jamKerja('8:00',$hNormal);
		$JkJumat  = jamKerja('5:30',$jumat);
		$JkTotal  = sum_the_time($JkNormal['tampil'],$JkJumat['tampil']);
		$noUrut   = 1;
		$i        = 0;
		$jJumat   = array();
		$jMinggu  = array();
		$Query  = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih, profile.Nip,
			profile.NamaLengkap, profile.Jabatan, profile.Jurusan,profile.Fak, presensi.abs,presensi.id, presensi.JamMasuk,
			presensi.JamKeluar,presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi,
			profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
			AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$Nama' ORDER BY Tanggal ASC";
		$Query1 = "SELECT DISTINCT NamaLengkap, Nip, Jurusan, Fak FROM profile WHERE Nama='$Nama'";
		$Query2 = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
			FROM presensi WHERE login='$Nama' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'";
		//$Query3 = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
		$Query4 = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND login='$Nama' AND JamMasuk <> '00:00:00'
			AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";//telat
		$Query5 = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND login='$Nama' AND JamMasuk <> '00:00:00'
			AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";//bolos
		$Query7 = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND JamMasuk <> '00:00:00'
			AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 LIMIT 23";//bolos1
		$Query6 = "SELECT id FROM presensi WHERE login='$Nama' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='1' LIMIT 23";//hadir
		$Query8 = "SELECT id FROM presensi WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00'
			AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";//bolos2
		$Query9 = "SELECT id FROM presensi WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00'
			AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";//bolos3
		$Query10 = "SELECT id FROM presensi WHERE login='$Nama' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL 
			AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";//telat1
		$Query11 = "SELECT id FROM presensi WHERE login='$Nama' AND JamMasuk = '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";
		$ijinAP  = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4'"),0,0);
		$tugas   = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3'"),0,0);
		$sakit   = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6'"),0,0);
		$manual  = mysql_result(mysql_query("SELECT COUNT(*) FROM presensi WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5'"),0,0);
		$cuti	 = countRow("presensi","WHERE login='$Nama' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt' AND abs='7'");
		$Data1  = mysql_query($Query1);
		$Data   = mysql_query($Query);
		$Data2  = mysql_query($Query2);
		$Data3  = mysql_query($Query3);
		$Data4  = mysql_query($Query4);
		$Data5  = mysql_query($Query5);
		$Data6  = mysql_query($Query6);
		$Data7  = mysql_query($Query7);
		$Data8  = mysql_query($Query8);
		$Data9  = mysql_query($Query9);
		$Data10 = mysql_query($Query10);
		$Data11 = mysql_query($Query11);
		$bolos  = mysql_num_rows($Data5);
		$bolos1 = mysql_num_rows($Data7);
		$bolos2 = mysql_num_rows($Data8);
		$bolos3 = mysql_num_rows($Data9);
		$ijin   = mysql_num_rows($Data11);
		$ttlbolos  = $bolos+$bolos1+$bolos2+$bolos3;
		$telat     = mysql_num_rows($Data4);
		$telat1    = mysql_num_rows($Data10);
		$ttltelat  = $telat + $telat1;
		$hadir 	   = mysql_num_rows($Data6);
		$kehadiran = $hadir+$manual;
		$Hasil1    = mysql_fetch_assoc($Data2);
		$Hasil2    = mysql_fetch_assoc($Data3);
		$Hasil     = mysql_fetch_assoc($Data1);
		echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
		echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
		echo "<h2 align=\"center\">Bulan: &nbsp;".$bln." ".$y."</h2>";
		echo "<table>";
		echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Hasil['NamaLengkap']."</td></tr>";
		echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Hasil['Nip']."</td></tr>";
		echo "<tr><td><b>Unit Kerja&nbsp;</b></td><td>:&nbsp;&nbsp;".jur_det($Hasil['Jurusan'])."</td></tr>";
		echo "<tr><td><b>Unit Kerja Utama&nbsp;</b></td><td>:&nbsp;".$Hasil['Fak']."</td></tr>";
		echo "</table>";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
		echo "<tr><td><b>No</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Datang</b></td><td><b>Pulang</b></td><td><b>JamKerja</b></td></tr>";
		while ($hasil=mysql_fetch_assoc($Data)) {
		echo "<tr><td>".$noUrut."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		echo "<td>".indonesian_date($hasil['hari'])."</td>";
		if($hasil['hari']   == 'Fri'){
			$jJumat[$i]  = $hasil['hari'];
			switch ($hasil['abs']){
				case '3'	:
					$jKerja    = TimeDiff('01:30:00',$hasil['selisih']);
					$jMasuk = "DINAS LUAR";
					$jKeluar= "DINAS LUAR";
					break;
				case '4'	:
					$jKerja = "IZIN AP";
					$jMasuk = "IZIN AP";
					$jKeluar= "IZIN AP";
					break;
				case '6'	:
					$jKerja = "SAKIT";
					$jMasuk = "SAKIT";
					$jKeluar= "SAKIT";
					break;
				case '7'	:
					$jKerja = "CUTI";
					$jMasuk = "CUTI";
					$jKeluar= "CUTI";
					break;
				default		:
					$jMasuk	= $hasil['JamMasuk'];
					$jKeluar= $hasil['JamKeluar'];
					if($jMasuk == NULL){
						$jKerja    = '00:00:00';
					}else{
						$jKerja    = TimeDiff('01:30:00',$hasil['selisih']);
					}
					break;
			}
			
			
		}else{
			$jMinggu[$i] = $hasil['hari'];
			switch ($hasil['abs']){
				case '3'	:
					$jKerja    = TimeDiff('00:30:00',$hasil['selisih']);
					$jMasuk = "DINAS LUAR";
					$jKeluar= "DINAS LUAR";
					break;
				case '4'	:
					$jKerja = "IZIN AP";
					$jMasuk = "IZIN AP";
					$jKeluar= "IZIN AP";
					break;
				case '6'	:
					$jKerja = "SAKIT";
					$jMasuk = "SAKIT";
					$jKeluar= "SAKIT";
					break;
				case '7'	:
					$jKerja = "CUTI";
					$jMasuk = "CUTI";
					$jKeluar= "CUTI";
					break;
				default		:
					$jMasuk	= $hasil['JamMasuk'];
					$jKeluar= $hasil['JamKeluar'];
					if($jMasuk == NULL){
						$jKerja    = '00:00:00';
					}else{
						$jKerja    = TimeDiff('00:30:00',$hasil['selisih']);
					}
					if($jKeluar == NULL){
						$jKerja   = '00:00:00';
					}
					break;
			}
			
		}
		echo "<td>&nbsp;".$jMasuk."</td><td>&nbsp;".$jKeluar."</td><td>&nbsp;".$jKerja."</td></td></tr>";
		$noUrut++;
		$i++;
		}
		$jmlJumat = count($jJumat);
		$jmlMinggu= count($jMinggu);
		$jmlHari  = $noUrut-$jmlJumat-1;
		$IstJumat = jamKerja('1:30',$jmlJumat);
		$IstNormal= jamKerja('0:30',$jmlHari);
		$istirahat= sum_the_time($IstJumat['tampil'],$IstNormal['tampil']);
		$Sql_JkPeg= mysql_query("SELECT TIMEDIFF('".$Hasil1['jumlah']."','".$istirahat."')");
		$JKpegawai= mysql_result($Sql_JkPeg,0,0);
		$Sql_lbhkr= mysql_result(mysql_query("SELECT TIMEDIFF('$JkTotal','$JKpegawai')"),0,0);
		if($Sql_lbhkr < 0){
			$lebih  = mysql_result(mysql_query("SELECT TIMEDIFF('$JKpegawai','$JkTotal')"),0,0);
			$kurang = 0;
		}else{
			$lebih  = 0;
			$kurang = $Sql_lbhkr;
		}
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Jam Kerja Bulan ini</b></td><td>".$JkTotal."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Jam Kerja Pegawai</b></td><td>".$JKpegawai."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kekurangan Jam Kerja</b></td><td>".$kurang."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kelebihan Jam Kerja</b></td><td>".$lebih."</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$kehadiran."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Datang Terlambat</b></td><td>".$ttltelat."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Pulang Awal</b></td><td>".$ttlbolos."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Izin Alasan Penting</b></td><td>".$ijinAP."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Tugas Dinas</b></td><td>".$tugas."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Izin Sakit</b></td><td>".$sakit."&nbsp;Kali</td></tr>";
		echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Cuti</b></td><td>".$cuti."&nbsp;Kali</td></tr>";
		echo "</table>";
		echo "<p><b>Keterangan :</b><br />";
		echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
		echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
		echo "c. Jam Kerja hari biasa (Senin s/d kamis) = Jam Pulang - Jam Datang - Istirahat 30 menit <br />";
		echo "d. Jam Kerja hari Jumat = Jam Pulang - Jam Datang - Istirahat 1 jam 30 menit<br />";
		echo "e. Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.11<br />";
		echo "f. Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
		echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
	}
?>
</body>
</html>