<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Universitas Negeri Yogyakarta | Admin</title>
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
<?
require_once("adm.db.php");
	
        $bt="05-2010";
        $Nama="wardan";
	$noUrut=1;
	echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
	echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
	echo "<h2 align=\"center\">Bulan: &nbsp;".$bt."</h2>";
	echo "<table>";
	echo "</table>";
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
	echo "<tr><td><b>No</b></td><td><b>Nama</b></td><td><b>Nip</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Jam Masuk</b></td></tr>";
	$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND profile.Nama=presensi.login AND presensi.login = '$Nama'  ";
	$res=mysql_query($Query);
        $num_rows=mysql_num_rows($res);
        while ($Hasil=mysql_fetch_assoc($res)){
            echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".dateConv($Hasil['Tanggal'])."</td><td>".indonesian_date($Hasil['hari'])."</td><td>".$Hasil['JamMasuk']."</td></td></tr>";
            $noUrut++;
        }
        echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$num_rows."</td></tr>";
        echo "</table>";
	
?>