<?php 
include_once ("adm.db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Universitas Negeri Yogyakarta | Admin</title>
<style type="text/css">
    #tabel
    {
    font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
    width:100%;
    border-collapse:collapse;
    }
    #tabel td, #tabel th 
    {
    font-size:1em;
    border:1px solid #000;
    padding:3px 7px 2px 7px;
    }
    #tabel th 
    {
    font-size:1.1em;
    text-align:left;
    padding-top:5px;
    padding-bottom:4px;
    background-color:#A7C942;
    color:#ffffff;
    }
    #tabel tr.alt td 
    {
    color:#000000;
    background-color:#EAF2D3;
    }
  </style>
</head>
<body>
<?php 

//$Query = "SELECT COUNT (id) FROM presensi WHERE JamMasuk >=070100 AND Fak='$Fakk' AND date_format(presensi.Tanggal, '%m-%Y') = '03-2010' ";
$Fakk=$_SESSION['userdata'][Fak];
$FT_jumlah = numRow ("profile","WHERE Fak='$Fakk' AND Jabatan='Karyawan'","id");
$FT_Telat = numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND date_format(presensi.Tanggal, '%m-%Y') = '03-2010'","presensi.id");
$FT_Telat_hari= numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND presensi.Tanggal='2010-03-29'","presensi.id"); 
//echo "Fakultas Teknik";
//echo "Jumlah Pegawai= $FT_jumlah <br />";
//echo "Jumlah Pegawai Terlambat bulan ini = $FT_Telat <br />";
//echo "Jumlah Pegawai Terlambat Hari ini  = $FT_Telat_hari <br />";
echo "<table id=\"tabel\"><tr><td>Tgl</td><td>Januari</td><td>Februari</td><td>Maret</td><td>April</td><td>Mei</td><td>Juni</td><td>Juli</td><td>Agst</td><td>Sept</td><td>Oktb</td><td>Novmb</td><td>Dsmbr</td><td>&nbsp;</td></tr>";
echo "<tr><td>";
for ($i=1; $i<=31; $i++){
echo "Tgl $i <br />";
}
echo "</td>";
echo "<td>";
for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-01-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-02-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-03-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-04-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-05-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-06-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-07-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-08-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-09-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-10-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-11-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 echo "<td>";
 for ($i=1; $i<=31; $i++) {
                echo numRow ("profile,presensi","WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-11-$i'","presensi.id");
            	echo "<br />";
 }
 echo "</td>";
 //echo "<td>&nbsp;</td>";
 echo "</tr></table>";
//echo "<table><tr><td><b>Bulan</b></td><td><b>Januari</b></td><td><b>Februari</b></td><td><b>Maret</b></td><td><b>April</b></td><td><b>Mei</b></td><td><b>Juni</b></td><td><b>Juli</b></td><td><b>Agustus</b></td><td><b>September</b></td><td><b>Oktober</b></td><td><b>November</b></td><td><b>Desember</b></td></tr>";
//for ($j=1; $j<=31; $j++) {
//echo "<tr>";
//echo "<td>Tgl $j</td>";
//for ($i=1; $i<=12; $i++) {
// echo "<td>";
 //$index[j]="SELECT presensi.id FROM profile,presensi WHERE presensi.JamMasuk >=070100 AND profile.Nama=presensi.login AND profile.Fak='$Fakk' AND profile.Jabatan='Karyawan' AND presensi.Tanggal='2010-03-$i'";
// echo "</td>";
//}
//}
//echo "</tr>";
//echo "</table>";
?>
</body>
</html>