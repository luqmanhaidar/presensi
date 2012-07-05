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
    h2 {
      font-family: “times new roman”;
      font-size:20px;
    }
    p{
      font-family: “times new roman”;
      font-size:12px;
    }
    #tabel
    {
    font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
    width:100%;
    border-collapse:collapse;
    }
    #tabel td, #tabel th 
    {
    font-size:16px;
    border:1px solid #000;
    padding:3px 7px 2px 7px;
    }
    #tabel th 
    {
    font-size:18px;
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
  if(isset($_POST['submit'])){
    $Fakk	= $_POST['Fak'];
    $bln	= $_POST['bulan'];
    $thn	= $_POST['tahun'];
    //$subbag	= 'all';
    $bt		= $bln."-".$thn;
    //$hal	= 'all';
    //$x	       	= $_POST['bulan'];
    $start     	= $thn."-".$bln."-1";
    $end      	= $thn."-".$bln."-31";
    
    $Query  	= "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC";  
    $data    	= mysql_query($Query);
    $jml_hari  = dateDiff($start,$end);
    $jml_httl  = $jml_hari+1;
    $jml_mingu = hitung_minggu($start,$end);
    $jml_sabtu = hitung_sabtu($start,$end);
    $jml_hk    = $jml_httl-$jml_mingu-$jml_sabtu-$libur;
    $jml_hbln  = hitung_hari($bln,$thn);
    $jml_tming = hitung_minggu($start,$end);
    $jml_tsabt = hitung_sabtu($start,$end);
    
    $libur   	= mysql_result(mysql_query("SELECT COUNT(*) FROM hari_libur WHERE Tanggal BETWEEN '".$start."' AND '".$end."'"),0,0);
    $SQL_sub 	= "SELECT JurDet FROM adm_jurusan WHERE JurDet='$subbag'";
    $Data_sub	= mysql_query($SQL_sub);
    $OBJ_sub 	= mysql_fetch_object($Data_sub);
    $unit_krj	= $OBJ_sub->JurDet;
    $jml_hkttl = $jml_hbln-$jml_tming-$jml_tsabt-$libur;
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
    echo "<tr><td><b>Bulan</b></td><td>: ".bulan_id($bln)."&nbsp;&nbsp;".$thn."</td></tr>";
    echo "<tr><td><b>Unit Kerja Utama</b></td><td>: ".$Fakk."</td></tr>";
    echo "<tr><td><b>Jumlah Hari Kerja Bulan ".bulan_id($bln)."</b></td><td>: ".$jml_hkttl." hari</td></tr>";
    echo "</table>";
    echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\"><b>Unit Kerja</b></td><td colspan=\"7\" align=\"center\"><b>JUMLAH</b></td></tr>";
    echo "<tr><td><b>Hadir</b></td><td><b>Terlambat</b></td><td><b>Pulang Cepat</b></td><td><b>Dinas Luar</b></td><td><b>Izin AP</b></td><td><b>Izin Sakit</b></td><td><b>Tanpa Ket</b></td></tr>";
    while ($hasil  = mysql_fetch_assoc($data)){
      $j++;
    echo "<tr><td>$i</td><td>".$hasil['NamaLengkap']."</td><td>".jur_det($hasil['Jurusan'])."</td>";
    //<td align=\"center\">".$hasil['Jurusan']."</td>";
    $arr[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1' LIMIT 23";
    $arr1[$j] = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND JamMasuk <> '00:00:00' AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
    $arr2[$j] = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND JamKeluar <> '00:00:00' AND login='".$hasil['Nama']."' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
    $arr3[$j] = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday' AND login = '".$hasil['Nama']."' AND JamKeluar <=135959 AND JamKeluar <> '00:00:00' LIMIT 23";
    $arr4[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";
    $arr5[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND  date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";
    $arr6[$j] = "SELECT id FROM presensi WHERE JamMasuk IS NULL AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
    $arr7[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '4' LIMIT 23";
    $arr8[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '3' LIMIT 23";
    $arr9[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '6' LIMIT 23";
    $arr10[$j]= "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '5' LIMIT 23";
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
    
    $data12= mysql_query($arr10[$j]);
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
    $manual= mysql_num_rows($data12);
    $tt_hadir=$hadir+$manual;
    $absen = $jml_hkttl-$tt_hadir-$izin-$tugas-$sakit;
    $plgcepat = $cepat+$cepat1+$cepat2+$cepat3;
     echo "<td align=\"center\">".$tt_hadir."</td><td align=\"center\">".$ttltelat."</td><td align=\"center\">".$plgcepat."</td><td align=\"center\">".$tugas."</td><td align=\"center\">".$izin."</td><td align=\"center\">".$sakit."</td>";
     if($absen < 0){
	echo "<td align=\"center\">0</td></tr>";
     }else{
	echo "<td align=\"center\">".$absen."</td></tr>";
     }     
    $i++;
    }
    echo "</table>";
    echo "<br />";
    echo "<b>Catatan :</b><br />";
    echo "Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.11<br />Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
    echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
  }
?>
</body>
</html>