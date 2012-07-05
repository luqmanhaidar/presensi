<?php
require_once("adm.db.php");
include     ("func_date.php");
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
<body>
   
    <?php
    if (isset($_POST['submit'])){
        $bln      = $_POST['bulan'];
        $thn      = $_POST['tahun'];
        $jur      = $_POST['jurusan'];
        $bt       = $bln."-".$thn;
        $hal      = $_POST['hal'];
        $x        = $_POST['bulan'];
        $fakk     = $_SESSION['userdata']['Fak'];
        $start    = $thn."-".$bln."-1";
        $end      = $thn."-".$bln."-31";
        $i=1;
        $j=0;
        $hadir   =array();
        $izin_ap =array();
        $izin_tg =array();
        $izin_sk =array();
        $manual  =array();
        $cuti    =array();
        $libur   = countRow("hari_libur","where Tanggal BETWEEN '".$start."' AND '".$end."'");
        $jml_hbln  = hitung_hari($bln,$thn);
        //$jml_tming = hitung_minggu($start,$end);
        $jml_tming = count_minggu($jml_hbln,$bln,$thn);
        $jml_tsabt = hitung_sabtu($start,$end);
        $jml_hkttl = $jml_hbln-$jml_tming-$jml_tsabt-$libur;
        $row = fetchDistinct("profile","where Jabatan='Dosen' AND Fak='$fakk' and Jurusan='$jur' and status='1' order by sort asc","(Nama),(NamaLengkap),(Nip),(Jurusan)");
        //echo $jur;
        echo "<table id=\"theader\"><tr><td>Rekap Kehadiran Dosen</td><td></td></tr>";
        echo "<tr><td>Unit Kerja</td><td>: ".$fakk."</td></tr>";
        echo "<tr><td>Bulan / Tahun</td><td>: ".bulan_id($bln)." ".$thn."</td></tr>";
        echo "<tr><td>Jumlah Hari kerja</td><td>: $jml_hkttl Hari</td></tr>";
        // echo "<tr><td>libur</td><td>: $libur Hari</td></tr>";
        echo "</table><br />";
        echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\" align=\"center\"><b>Jurusan</b></td><td  colspan=\"6\" align=\"center\"><b>Jumlah</b></td></tr>";
        echo "<tr><td><b>Hadir</b></td><td><b>Tugas Luar</b></td><td><b>Izin <br />Alasan Penting</b></td><td><b>Izin Sakit</b></td><td><b>Cuti</b></td><td><b>Tanpa Ket</b></td></tr>";
        foreach($row as $r){
            $j++;
            //print_r($_jur);
            echo "<tr><td>$i</td><td>$r[NamaLengkap]</td><td>".jur_det($jur)."</td>";
            /**
            $hadir[$j]  = numRow("presensi","where login='$r[Nama]' AND abs='1' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $izin_ap[$j]= numRow("presensi","where login='$r[Nama]' AND abs='4' AND JamMasuk='00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $izin_tg[$j]= numRow("presensi","where login='$r[Nama]' AND abs='3' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $izin_sk[$j]= numRow("presensi","where login='$r[Nama]' AND abs='6' AND JamMasuk='00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $manual[$j] = numRow("presensi","where login='$r[Nama]' AND abs='5' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'","JamMasuk");
            **/
            $hadir[$j]  = countRow("presensi","where login='$r[Nama]' AND abs='1' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $izin_ap[$j]= countRow("presensi","where login='$r[Nama]' AND abs='4' AND JamMasuk='00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $izin_tg[$j]= countRow("presensi","where login='$r[Nama]' AND abs='3' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $izin_sk[$j]= countRow("presensi","where login='$r[Nama]' AND abs='6' AND JamMasuk='00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","JamMasuk");
            $manual[$j] = countRow("presensi","where login='$r[Nama]' AND abs='5' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'","JamMasuk");
            $cuti[$j]   = countRow("presensi","where login='$r[Nama]' AND abs='7' AND date_format( presensi.Tanggal, '%m-%Y') = '$bt'","JamMasuk");
            $tt_hadir= $hadir[$j]+$manual[$j];
                echo "<td><b>$hadir[$j]</b></td>";
                $abs=$jml_hkttl-$hadir[$j]-$izin_ap[$j]-$izin_sk[$j]-$izin_tg[$j]-$cuti[$j];
           echo "<td><b>$izin_tg[$j]</b></td><td><b>$izin_ap[$j]</b></td><td><b>$izin_sk[$j]</b></td><td><b>$cuti[$j]</b></td><td><b>$abs</b></td></tr>"; 
            
        $i++; 
        }
        echo "</table>";
    }
    ?>
</body>
</html>