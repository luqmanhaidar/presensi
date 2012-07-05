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
<?
require_once("adm.db.php");
include      ("func_date.php");
	$bt    = $_POST['bt'];
	//$Nip=$_POST['Nip'];
	$Nama  = $_POST['Nama'];
	$bt_id = explode("-",$bt);
	$bln   = $bt_id[0];
	$thn   = $bt_id[1];
	$Tawal 	     = "1-".$bln."-".$thn;
	$Takhir	     = "31-".$bln."-".$thn;
	$JmlSabtu    = hitung_sabtu($Tawal,$Takhir);
	$JmlMinggu   = hitung_minggu($Tawal,$Takhir);
	$JmlJumat    = hitung_jumat($Tawal,$Takhir);
	$JmlHari     = hitung_hari($bln,$thn);
	$libur       = numRow("hari_libur","where date_format(Tanggal,'%m-%Y')='".$bt."'","id");
	$hariNormal  = $JmlHari - $JmlMinggu - $JmlSabtu - $libur;
	$noUrut=1;
	$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND profile.Nama=presensi.login AND presensi.login='$Nama' ORDER BY presensi.Tanggal ASC";
	$hadir = countRow("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal,'%m-%Y') = '$bt' AND abs='1'");
	$tugas = countRow("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal,'%m-%Y') = '$bt' AND abs='3'");
	$ijin  = countRow("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal,'%m-%Y') = '$bt' AND abs='4'");
	$sakit = countRow("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal,'%m-%Y') = '$bt' AND abs='6'");
	$cuti  = countRow("presensi","WHERE login='$Nama' AND date_format(presensi.Tanggal,'%m-%Y') = '$bt' AND abs='7'");
	$Data = mysql_query($Query);
	$abs  = $hariNormal-$hadir-$tugas-$ijin-$sakit-$cuti;
	$num_rows = mysql_num_rows($Data);
	$sql="SELECT NamaLengkap,Nip,Jurusan FROM profile WHERE Nama='$Nama'";
	$Dt=mysql_query($sql);
	$row=mysql_fetch_object($Dt);
	$Namalengkap = $row->NamaLengkap;
        $Nip = $row->Nip;
        $Jurusan = $row->Jurusan;

	echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
	echo "DOSEN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
	echo "<h2 align=\"center\">Bulan: &nbsp;".bulan_id($bln)." ".$thn."</h2>";
	echo "<table>";
	echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Namalengkap."</td></tr>";
	echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Nip."</td></tr>";
        echo "<tr><td><b>Jurusan&nbsp;</b></td><td>:&nbsp;".jur_det($Jurusan)."</td></tr>";
	echo "</table>";
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
	echo "<tr><td><b>No</b></td><td><b>Nama</b></td><td><b>Nip</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Jam Masuk</b></td></tr>";
	while ($Hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".dateConv($Hasil['Tanggal'])."</td><td>".indonesian_date($Hasil['hari'])."</td><td>".$Hasil['JamMasuk']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Hari Kerja</b></td><td>".$hariNormal." Hari</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$hadir." Hari</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Tugas Dinas</b></td><td>".$tugas." Hari</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Izin Sakit</b></td><td>".$sakit." Hari</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Izin Alasan Penting</b></td><td>".$ijin." Hari</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Cuti</b></td><td>".$cuti." Hari</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Tanpa Keterangan</b></td><td>".$abs." Hari</td></tr>";
	echo "</table>";
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
	//echo "c. Jumlah kerja Normal Bulan ini : <b>".$Hasil2['JamKerja']."</b> Jam<br />";
	//echo "d. Jumlah real jam yang bersangkutan dalam bulan ini:<b> ".$Hasil1['jumlah']."</b> Jam<br />";
	//echo "e. Kekurangan jam kerja yang bersangkutan untuk bulan ini:<b> ".$kekurangan."</b> Jam<br />";
	//echo "f. Kelebihan jam kerja yang bersangkutan untuk bulan ini</p>";
?>