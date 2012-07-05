<?php
session_start();
  if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
  }
  ?>
  <style type="text/css">
#tabel
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#tabel td, #customers th 
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
  <?php
  include_once ("../koneksi.php");
  $Fakk=$_SESSION['userdata']['Fak'];
  $bt='2010-02';
  $Query  = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan) FROM profile WHERE Fak='FT' LIMIT 25";
  $Query1 = "SELECT JmlHari FROM harikerja WHERE Bulan='02-2010'";
  $data   = mysql_query($Query);
  $data5  = mysql_query($Query1);
  $obj    = mysql_fetch_object($data5);
  $Jmlhari= $obj->JmlHari;
  $i=1;
  $j=0;
  $arr=array();
  $arr1=array();
  $arr2=array();
  $arr3=array();
  $arr4=array();
  echo "<table>";
  echo "<tr><td>Rekap Kehadiran</td></tr>";
  echo "<tr><td>Bulan</td></tr>";
  echo "<tr><td>Unit Kerja Utama</td></tr>";
  echo "</table>";
  echo "<table id=\"tabel\"><tr><td><b>No</b></td><td><b>Nama Lengkap</b></td><td><b>Unit Kerja</b></td><td><b>Jumlah Masuk</b></td><td><b>Terlambat</b></td><td><b>Pulang Cepat</b></td><td><b>Tidak Masuk</td></b></tr>";
  while ($hasil  = mysql_fetch_assoc($data)){
    $j++;
    echo "<tr><td>$i</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Jurusan']."</td>";
  $arr[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '02-2010' LIMIT 23";
  $arr1[$j] = "SELECT id FROM presensi WHERE JamMasuk >=070200 AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '02-2010' LIMIT 23";
  $arr2[$j] = "SELECT id FROM presensi WHERE JamKeluar <=153100 AND login='".$hasil['Nama']."' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
  $arr3[$j] = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '02-2010' AND dayname( presensi.Tanggal ) = 'friday' AND login = '".$hasil['Nama']."' AND JamKeluar <=140100 LIMIT 23";
  $arr4[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar is NULL AND abs='0' AND date_format( presensi.Tanggal, '%m-%Y' ) = '02-2010'";
  $data1 = mysql_query($arr[$j]);
  $data2 = mysql_query($arr1[$j]);
  $data3 = mysql_query($arr2[$j]);
  $data4 = mysql_query($arr3[$j]);
  $data6 = mysql_query($arr4[$j]);
  $telat = mysql_num_rows($data2);
  $hadir = mysql_num_rows($data1);
  $cepat = mysql_num_rows($data3);
  $cepat1= mysql_num_rows($data4);
  $cepat2= mysql_num_rows($data6);
  $absen = $Jmlhari-$hadir;
  $plgcepat = $cepat+$cepat1+$cepat2;
   echo "<td>".$hadir."</td><td>".$telat."</td><td>".$plgcepat."</td><td>".$absen."</td></tr>";
  
  $i++;
  }
  echo "</table>";
  echo "<br />";
  echo "<b>Catatan :</b><br />";
  echo "Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.01<br />Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
  echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>"
 
?>