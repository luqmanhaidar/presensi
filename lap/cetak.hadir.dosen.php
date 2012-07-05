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
include ("../koneksi.php");
	//$Nip=$_POST['Nip'];
	$Nama=mysql_escape_string($_POST['Nama']);
        $start =mysql_escape_string($_POST['start']);
        $end = mysql_escape_string($_POST['end']);
	$noUrut=1;
	$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND presensi.Tanggal BETWEEN '$start' AND '$end'  AND profile.Nama=presensi.login AND profile.Nama='$Nama'";
	$Data = mysql_query($Query);
	$num_rows = mysql_num_rows($Data);
        $row = mysql_fetch_object($Data);
        $Namalengkap = $row->NamaLengkap;
        $Nip = $row->Nip;
        $Jurusan = $row->Jurusan;
	echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
	echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
	echo "<table>";
	echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Namalengkap."</td></tr>";
	echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Nip."</td></tr>";
        echo "<tr><td><b>Jurusan&nbsp;</b></td><td>:&nbsp;".$Jurusan."</td></tr>";
	echo "</table>";
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
	echo "<tr><td><b>No</b></td><td><b>Nama</b></td><td><b>Nip</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Jam Masuk</b></td></tr>";
	while ($Hasil=mysql_fetch_array($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".$Hasil['Tanggal']."</td><td>".$Hasil['hari']."</td><td>".$Hasil['JamMasuk']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$num_rows."</td></tr>";
	echo "</table>";
?>