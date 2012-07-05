<?php
require("adm.db.php");
include("func_date.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Universitas Negeri Yogyakarta | Admin-Cetak-Rekap-Dosen</title>
<style type="text/css">
    #tabel
    {
    font-family:Verdana, Arial, Helvetica, sans-serif;
    width:100%;
    border-collapse:collapse;
    }
    #tabel td, #tabel th 
    {
    font-size:11px;
    border:1px solid #000;
    padding:3px 7px 2px 7px;
    }
    #tabel th 
    {
    font-size:11px;
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
    if (isset($_POST['submit'])){
        //$bulan  =$_POST['bulan'];
        //$tahun  =$_POST['tahun'];
        $start  =mysql_escape_string(stripslashes($_POST['start']));
        $end    =mysql_escape_string(stripslashes($_POST['end']));
        $jur    =mysql_escape_string(stripslashes($_POST['jurusan']));
        $pecahTanggal = explode("-", $start);
        $tanggal = $pecahTanggal[2];
        $bulan   = $pecahTanggal[1];
        $tahun   = $pecahTanggal[0];
        $bt     =$bulan."-".$tahun;
        $hal    =$_POST['hal'];
        $x      =$bulan;
        $i=1;
        $j=0;
        $arr=array();
        $query= mysql_query("SELECT JmlHari FROM harikerja WHERE Bulan='$bt'");
        $obj = mysql_fetch_object($query);
        $JmlHari = $obj->JmlHari;
        $row = fetchDistinct("profile","where Jabatan='Dosen' and Jurusan='$jur' and status='1' order by Gol desc","(Nama),(NamaLengkap),(Nip),(Jurusan)");
        echo "<table><tr><td><b>Rekap Kehadiran Dosen</b></td><td><b>Jurusan</b> ".jur_det($jur)."</td></tr>";
        echo "<tr><td><b>Bulan</b></td><td>: ".bulan_id($bulan)." ".$tahun."</td></tr>";
        echo "<tr><td><b>Dari Tgl : </b>".dateConv($start)."</td><td><b>Sampai Tgl: </b>".dateConv($end)."</td></tr>";
        echo "</table><br />";
        echo "<table id=\"tabel\"><tr><td><b>No</b></td><td><b>Nama Lengkap</b></td><td><b>Nip</b></td><td><b>Jurusan</b></td><td><b>Jumlah Kehadiran</b></td></tr>";
        foreach($row as $r){
            $j++;
            echo "<tr><td>$i</td><td>$r[NamaLengkap]</td><td>$r[Nip]</td><td>".jur_det($r[Jurusan])."</td>";
            $arr[$j]= numRow("presensi","where login='$r[Nama]' AND presensi.Tanggal BETWEEN '$start' AND '$end'","JamMasuk");
                echo "<td><b>$arr[$j]</b></td></tr>";
                $abs=$JmlHari-$arr[$j];
           //echo "<td></td></tr>"; 
            
        $i++; 
        }
        echo "</table>";
    }
    ?>
</body>
</html>