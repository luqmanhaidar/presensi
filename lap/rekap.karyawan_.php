<?php
session_start();
  if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
  }
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
    /*text-align:left;*/
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
<body onload="window.print()">
<?php
  include_once ("adm.db.php");
  include      ("func_date.php");
  //if(isset($_POST['submit'])){
    /**
    $Fakk=$_SESSION['userdata']['Fak'];
    $bulan=$_POST['bulan'];
    $tahun=$_POST['tahun'];
    $subbag=$_POST['subbag'];
    $bt=$bulan."-".$tahun;
    $hal=$_POST['hal'];
    $x=$_POST['bulan'];
    **/
    $Fakk="FT";
    $bulan="2";
    $tahun="2011";
    $bt   =$bulan."-".$tahun;
    $hal  = "all";
    $x="2";
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
    if($subbag == "all"){
	if($hal == "all"){
		$Query  = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC";
	}else{
      		$Query  = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC LIMIT $hal";
	}    
}else{
	if($hal == "all"){
      	$Query  = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan = '$subbag' AND status='1' ORDER BY Gol DESC";
    }else{
	$Query  = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan = '$subbag' AND status='1' ORDER BY Gol DESC LIMIT $hal";

	}
    }
    $Query1  = "SELECT JmlHari FROM harikerja WHERE Bulan='$bt'";
    $data    = mysql_query($Query);
    $data5   = mysql_query($Query1);
    $obj     = mysql_fetch_object($data5);
    $Jmlhari = $obj->JmlHari;
    $SQL_sub = "SELECT JurDet FROM adm_jurusan WHERE JurDet='$subbag'";
    $Data_sub= mysql_query($SQL_sub);
    $OBJ_sub = mysql_fetch_object($Data_sub);
    $unit_krj= $OBJ_sub->JurDet;
    $i=1;
    $j=0;
    $arr=array();
    $arr1=array();
    $arr2=array();
    $arr3=array();
    $arr4=array();
    $arr5=array();
    $arr6=array();
    $arr7=array();
    $arr8=array();
    $arr9=array();
    //$arr9=array();
    echo "<table>";
    echo "<tr><td><b>Rekap Kehadiran</b></td><td></td></tr>";
    echo "<tr><td><b>Bulan</b></td><td>: ".$bln."&nbsp;&nbsp;".$tahun."</td></tr>";
    echo "<tr><td><b>Unit Kerja Utama</b></td><td>: ".$Fakk."</td></tr>";
    echo "</table>";
    echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\"><b>Unit Kerja</b></td><td colspan=\"7\" align=\"center\"><b>JUMLAH</b></td></tr>";
    echo "<tr><td>Hadir</td><td>Terlambat</td><td>Pulang Cepat</td><td>Dinas Luar</td><td>Izin AP</td><td>Izin Sakit</td><td>Tanpa Ket</td></tr>";
    while ($hasil  = mysql_fetch_assoc($data)){
      $j++;
    echo "<tr><td>$i</td><td>".$hasil['NamaLengkap']."</td>";
    //<td align=\"center\">".$hasil['Jurusan']."</td>";
    $arr[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' LIMIT 23";
    $arr1[$j] = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND JamMasuk <> '00:00:00' AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
    $arr2[$j] = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND JamKeluar <> '00:00:00' AND login='".$hasil['Nama']."' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
    $arr3[$j] = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday' AND login = '".$hasil['Nama']."' AND JamKeluar <=135959 AND JamKeluar <> '00:00:00' LIMIT 23";
    $arr4[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";
    $arr5[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND  date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";
    $arr6[$j] = "SELECT id FROM presensi WHERE JamMasuk IS NULL AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
    $arr7[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '4' LIMIT 22";
    $arr8[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '3' LIMIT 22";
    $arr9[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '6' LIMIT 22";
    //$arr9[$j] = "SELECT JurDet FROM adm_jurusan WHERE JurId='".$hasil['Jurusan']."'";
    $data1 = mysql_query($arr[$j]);
    $data2 = mysql_query($arr1[$j]);
    $data3 = mysql_query($arr2[$j]);
    $data4 = mysql_query($arr3[$j]);
    $data6 = mysql_query($arr4[$j]);
    $data7 = mysql_query($arr5[$j]);
    $data8 = mysql_query($arr6[$j]);
    $data9 = mysql_query($arr7[$j]);
    $data10= mysql_query($arr8[$j]);
    $data11= mysql_query($arr9[$j]);
    //$data11= mysql_query($arr9[$j]);
    $telat = mysql_num_rows($data2);
    $telat1= mysql_num_rows($data8);
    $izin  = mysql_num_rows($data9);
    $tugas = mysql_num_rows($data10);
    $sakit = mysql_num_rows($data11);
    //$unit  = mysql_fetch_object($data11);
    //$unit_k= $unit->JurDet;
    $ttltelat=$telat1 + $telat;
    $hadir = mysql_num_rows($data1);
    $cepat = mysql_num_rows($data3);
    $cepat1= mysql_num_rows($data4);
    $cepat2= mysql_num_rows($data6);
    $cepat3= mysql_num_rows($data7);
    $absen = $Jmlhari-$hadir-$izin-$tugas-$sakit;
    $plgcepat = $cepat+$cepat1+$cepat2+$cepat3;
    echo "<td>".$hasil['jurusan']."</td>";
    /**
    if($subbag == 'Umper/Cleaning'){
      echo "<td>Umum dan Perlengkapan</td>";
    }else{
       echo "<td>".$unit_krj."</td>";
    }
    **/
     echo "<td align=\"center\">".$hadir."</td><td align=\"center\">".$ttltelat."</td><td align=\"center\">".$plgcepat."</td><td align=\"center\">".$tugas."</td><td align=\"center\">".$izin."</td><td align=\"center\">".$sakit."</td><td align=\"center\">".$absen."</td></tr>";
    $i++;
    }
    echo "</table>";
    echo "<br />";
    echo "<b>Catatan :</b><br />";
    echo "Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.11<br />Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
    echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
  //}
?>
</body>
</html>