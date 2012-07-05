<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Universitas Negeri Yogyakarta | Admin</title>
<style type="text/css">
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
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
include     ("func_date.php");
	$bt     = $_POST['bt'];
	$Nip    = $_POST['Nip'];
	$Nama   = $_POST['Nama'];
	$x_y    = explode ("-",$bt);
	$x	= $x_y[0];
	$y 	= $x_y[1];
	switch ($x) {
		case 1  : $bln = "Januari";   break;
		case 2  : $bln = "Februari";  break;
		case 3  : $bln = "Maret";     break;
		case 4  : $bln = "April";     break;
		case 5  : $bln = "Mei";       break;
		case 6  : $bln = "Juni";      break;
		case 7  : $bln = "Juli";      break;
		case 8  : $bln = "Agustus";   break;
		case 9  : $bln = "September"; break;
		case 10 : $bln = "Oktober";   break;
		case 11 : $bln = "November";  break;
		case 12 : $bln = "Desember";
	}
        $awal   = "1-".$x."-".$y;
        $akhir  = "31-".$x."-".$y;
        $Jml_sabtu = hitung_sabtu($awal,$akhir);
        $Jml_minggu= hitung_minggu($awal,$akhir);
        $Jml_hari  = hitung_hari($x,$y);
        $Jml_hari_x= $Jml_hari - $Jml_minggu -$Jml_sabtu;
        $JK_biasa  = $Jml_hari_x*9;
        $JK_sabtu  = $Jml_sabtu*5;
        $JamKerja=$JK_sabtu+$JK_biasa;
        $JK_total=$JamKerja.":00:00";
	$noUrut = 1;
        $sabtu  = 0;
        $senin  = 0;
	$Query  = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih, profile.Nip,
		profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk,
		presensi.JamKeluar,presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi,
		profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$Nama' ORDER BY Tanggal ASC";
	$Query1 = "SELECT DISTINCT NamaLengkap, Nip FROM profile WHERE Nama='$Nama'";
	$Query2 = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$Nama' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt'";
	$Query3 = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
	$Query4 = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND login='$Nama' AND JamMasuk <> '00:00:00'
		AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	$Query5 = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND login='$Nama' AND JamMasuk <> '00:00:00'
		AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
	$Query7 = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND JamMasuk <> '00:00:00'
		AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 LIMIT 23";
	$Query6 = "SELECT id FROM presensi WHERE login='$Nama' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND JamMasuk <> '00:00:00' LIMIT 23";
	$Query8 = "SELECT id FROM presensi WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";
	$Query9 = "SELECT id FROM presensi WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";
	$Query10 = "SELECT id FROM presensi WHERE login='$Nama' AND JamMasuk IS NULL AND  JamKeluar IS NOT NULL AND JamMasuk <> '00:00:00'
		AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";
	$Query11 = "SELECT id FROM presensi WHERE login='$Nama' AND JamMasuk = '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'";
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
	$kehadiran = mysql_num_rows($Data6);
	$Hasil1    = mysql_fetch_assoc($Data2);
	$Hasil2    = mysql_fetch_assoc($Data3);
	$Hasil     = mysql_fetch_assoc($Data1);
	echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
	echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
	echo "<h2 align=\"center\">Bulan: &nbsp;".$bln." ".$y."</h2>";
	echo "<table>";
	echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Hasil['NamaLengkap']."</td></tr>";
	echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Hasil['Nip']."</td></tr>";
	echo "</table>";
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
	echo "<tr><td><b>No</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Datang</b></td><td><b>Pulang</b></td><td><b>Jam Kerja</b></td><td><b>Target<br /> Jam Kerja</b></td></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".dateConv($hasil['Tanggal'])."</td><td>".indonesian_date($hasil['hari'])."</td><td>&nbsp;".$hasil['JamMasuk']."</td><td>&nbsp;".$hasil['JamKeluar']."</td><td>&nbsp;".$hasil['selisih']."</td>";
        if(indonesian_date($hasil['hari']) == 'Sabtu'){
            echo "<td>05:00:00</td>";
            $sabtu++;
        }else{
            echo "<td>09:00:00</td>";
            $senin++;
        }
         /**
        $JK_senin=$senin*9;
        $JK_sabtu=$sabtu*5;
        $JamKerja=$JK_sabtu+$JK_senin;
        $JK_total=$JamKerja.":00:00";
       
        $time= explode(":",$hasil['selisih']);
        $h= abs($time[0]);
        $m= abs($time[1]);
        $s= abs($time[2]);
        $X_time = mktime( $h, $m, $s, 0, 0, 0);
        $Y_time = mktime(9, 0, 0, 0, 0, 0);
        //kekurangan jam Kerja
        if($X_time < $Y_time){
            echo "<td>".get_time_difference($hasil['selisih'], '09:00:00')."</td>";
        }else{
            echo "<td>0</td>";
        }
        **/
        /** Kelebihan Jam Kerja
        if($X_time > $Y_time){
            echo "<td>".get_time_difference('09:00:00', $hasil['selisih'])."</td>";
        }else{
            echo "<td>0</td>";
        }
        */
        //echo "<td>".$hasil['hari']."</td>";
        echo "</tr>";
	$noUrut++;
	}
        echo "<tr><td colspan=\"6\" scope=\"col\" ><b>Jumlah Jam Kerja Normal Bulan ini</b></td><td>".$JK_total."</td></tr>";
	echo "<tr><td colspan=\"6\" scope=\"col\" ><b>Jumlah Jam Kerja Pegawai</b></td><td>".$Hasil1['jumlah']."</td></tr>";
	//echo "<tr><td colspan=\"6\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$kehadiran."&nbsp;Kali</td></tr>";
	echo "<tr><td colspan=\"6\" scope=\"col\" ><b>Jumlah Datang Terlambat</b></td><td>".$ttltelat."&nbsp;Kali</td></tr>";
	echo "<tr><td colspan=\"6\" scope=\"col\" ><b>Jumlah Pulang Awal</b></td><td>".$ttlbolos."&nbsp;Kali</td></tr>";
	echo "<tr><td colspan=\"6\" scope=\"col\" ><b>Jumlah Izin Pribadi</b></td><td>".$ijin."&nbsp;Kali</td></tr>";
	echo "</table>";
	//$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
	if($JK_total > $Hasil1['jumlah']){
		$kekurangan = selisih($Hasil1['jumlah'],$JK_total);
		$kelebihan  = 0;
	}else{
		$kekurangan = 0;
		$lbh  	    = selisih($JK_total,$Hasil1['jumlah']);
		$kelebihan  = abs($lbh);
	}
        //$jml_jam=$Hasil1['jumlah'];
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
        echo "c. Istirahat tiap hari 1 Jam (12.00 s/d 13.00), Hari Jum'at menyesuaikan <br />";
        //echo "Jk total :" .$JK_total;
        //echo "d. Selisih :".selisih($jml_jam,$JK_total)."";
	echo "d. Jumlah kerja Normal Bulan ini : <b>".$JK_total."</b> Jam<br />";
	echo "e. Jumlah real jam yang bersangkutan dalam bulan ini:<b> ".$Hasil1['jumlah']."</b> Jam<br />";
	echo "f. Kekurangan jam kerja yang bersangkutan untuk bulan ini:<b> ".$kekurangan."</b><br />";
	echo "g. Kelebihan Jam kerja yang bersangkutan untuk bulan ini: <b>".$kelebihan."</b>";
        echo "";
?>
</body>
</html>