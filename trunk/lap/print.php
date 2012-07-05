<?php
  session_start();
  if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
  }
?>
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
include      ("func_date.php");
if (isset($_POST['Submit'])){
$fakk=$_SESSION['userdata']['Fak'];
$bt=$_POST['bt'];
$query = "SELECT presensi.Nip, profile.NamaLengkap,
SUM( time_to_Sec( TIMEDIFF( presensi.JamKeluar, presensi.JamMasuk ) ) ) AS detik,
sec_to_time( SUM( time_to_Sec( TIMEDIFF( presensi.JamKeluar, presensi.JamMasuk ) ) ) ) AS jumlah,
SUM(presensi.abs) AS hadir
FROM presensi, profile
WHERE presensi.login = profile.Nama
AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'
AND profile.Jabatan = 'Karyawan' AND profile.Fak = '$fakk'
GROUP BY NIP ORDER BY profile.NamaLengkap";
$Query = "SELECT harikerja.JmlHari, harikerja.JamKerja FROM harikerja WHERE harikerja.Bulan='$bt'";
$Data = mysql_query($Query);
$data = mysql_query($query);
$i=1;
echo "<h3 align=\"center\">REKAPITULASI KEHADIRAN KERJA<br />";
echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h3>";
echo "<table>";
$Hasil = mysql_fetch_array($Data);
echo "<tr><td><b>Bulan</b></td><td>:&nbsp;".$bt."</td></tr>";
echo "<tr><td><b>Jumlah Hari Kerja</b></td><td>:&nbsp;".$Hasil['JmlHari']."&nbsp;Hari</td></tr>";
echo "<tr><td><b>Jumlah Jam Kerja</b></td><td>:&nbsp;".$Hasil['JamKerja']."&nbsp;jam</td></tr>";
echo "</table>";
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
echo "<tr><td><b>NO</b></td><td><b>NIP</b></td><td><b>Nama </b></td><td><b>Masuk Kerja</b></td><td><b>Absen</b></td><td><b>Jumlah Jam Kerja</b></td><td><b>Kekurangan Jam Kerja</b></td><td><b>kelebihan jam kerja</b></td></tr>";
while ($hasil = mysql_fetch_array($data))
			{
			$kekurangan = $Hasil['JamKerja'] -$hasil['jumlah'];
			$absen= $Hasil['JmlHari'] -$hasil['hadir'];
			$Query1 = "";
		echo "<tr><td>".$i."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td><b>".$hasil['hadir']."</b></td><td><b>".$absen."</b></td><td>&nbsp;".$hasil['jumlah']."</td><td><b>".$kekurangan."</b></td><td>&nbsp;</td></tr>";
		$i++;
			}
		echo "</table>";
		echo "<br /><br />";
		echo "<p><b>Keterangan :</b></p>";
		echo "<blockquote><p>";
		echo "a. Data Kehadiran berdasar database dalam ft-cam Attendance system<br>";
		echo "b. Ketidaksesuaian bisa terjadi karena Id yang dimasukkan tidak valid dan tidak ingatnya karyawan melakukan presensi saat datang/pulang kerja</p>";
		echo "</blockquote>";
}
?>