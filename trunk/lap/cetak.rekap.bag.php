<?php
require("adm.db.php");
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
  if(isset($_POST['submit'])){
    //$Fakk=$_SESSION['userdata']['Fak'];
    $bulan=$_POST['bulan'];
    $tahun=$_POST['tahun'];
    $jab  =$_POST['jab'];
    $bag  =$_POST['bag'];
    //$subbag=$_POST['subbag'];
    $bt=$bulan."-".$tahun;
    $hal=$_POST['hal'];
    $x=$_POST['bulan'];
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
        if($jab == 'Dosen'){
            $i=1;
            $j=0;
            $Count= array();
            $Cizin= array();
            $Ctugs= array();
            $Cmanl= array();
            $Csakt= array();
            $Query  = "SELECT JmlHari FROM harikerja WHERE Bulan='$bt'";
            $Query1 = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Nip) FROM profile WHERE Jabatan='Dosen' AND Fak='$bag' AND status='1' ORDER BY Jurusan DESC";            
            $data   = mysql_query($Query);
            $data1  = mysql_query($Query1);
            $obj    = mysql_fetch_object($data);
            $Jmlhari= $obj->JmlHari;
            echo "<table><tr><td>Rekap Kehadiran Dosen</td><td></td></tr>";
            echo "<tr><td>Bulan</td><td>: $bln tahun $tahun</td></tr>";
            echo "<tr><td>Jumlah Hari kerja</td><td>: $Jmlhari Hari</td></tr>";
            echo "</table><br />";
            echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\"><b>Nip</b></td><td rowspan=\"2\"><b>Jurusan</b></td><td colspan=\"5\" align=\"center\"><b>JUMLAH</b></td></tr>";
            echo "<tr><td><b>Hadir</b></td><td><b>Dinas Luar</b></td><td><b>Izin AP</b></td><td><b>Izin Sakit</b></td><td><b>Tanpa <br />Keterangan</b></td></tr>";
            while ($res = mysql_fetch_assoc($data1)){
                $j++;
                echo "<tr><td>$i</td><td>$res[NamaLengkap]</td><td>$res[Nip]</td><td>".jur_det($res[Jurusan])."</td>";
                $Count[$j] = "SELECT id FROM presensi WHERE login='".$res['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1' LIMIT 22";
                $Cizin[$j] = "SELECT id FROM presensi WHERE login='".$res['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='4' LIMIT 22";
                $Ctugs[$j] = "SELECT id FROM presensi WHERE login='".$res['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='3' LIMIT 22";
                $Cmanl[$j] = "SELECT id FROM presensi WHERE login='".$res['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='5' LIMIT 22";
                $Csakt[$j] = "SELECT id FROM presensi WHERE login='".$res['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='6' LIMIT 22";
                $Cdata     = mysql_query($Count[$j]);
                $Idata     = mysql_query($Cizin[$j]);
                $Tdata     = mysql_query($Ctugs[$j]);
                $Sdata     = mysql_query($Csakt[$j]);
                $Mdata     = mysql_query($Cmanl[$j]);
                $izin      = mysql_num_rows($Idata);
                $tugas     = mysql_num_rows($Tdata);
                $Cres      = mysql_num_rows($Cdata);
                $sakit     = mysql_num_rows($Sdata);
                $manual    = mysql_num_rows($Mdata);
                $tt_hadir  = $Cres+$manual;
                $abs       = $Jmlhari-$tt_hadir-$izin-$tugas-$sakit;
                if($abs < 0) {
                    $Cabs= "0" ;
                }else{
                    $Cabs= $abs;
                }
                echo "<td><b>$tt_hadir</b></td>";
                echo "<td><b>$tugas</b></td>";
                echo "<td><b>$izin</b></td>";
                echo "<td><b>$sakit</b></td>";
                echo "<td><b>$Cabs</b></td></tr>";
                $i++;
            }
            echo "</table>";
        }else{
            $Query  = "SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='$jab' AND Fak='$bag' AND Jurusan <> 'PKL' AND Jurusan <> 'Umper/Cleaning' AND status='1' ORDER BY Gol DESC ";    
            $Query1 = "SELECT JmlHari FROM harikerja WHERE Bulan='$bt'";
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
            $arr5=array();
            $arr6=array();
            $arr7=array();
            echo "<table>";
            echo "<tr><td><b>Rekap Kehadiran</b></td><td></td></tr>";
            echo "<tr><td><b>Bulan</b></td><td>: ".$bln."&nbsp;&nbsp;".$tahun."</td></tr>";
            echo "<tr><td><b>Unit Kerja Utama</b></td><td>: ".$Fakk."</td></tr>";
            echo "</table>";
            echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\"><b>Unit Kerja</b></td><td colspan=\"7\" align=\"center\"><b>JUMLAH</b></td></tr>";
            echo "<td><b>Hadir</b></td><td><b>Terlambat</b></td><td><b>Pulang Cepat</b></td><td><b>Dinas Luar</b></td><td><b>Izin AP</b></td><td><b>Izin Sakit</b></td><td><b>Tanpa<br/>Keterangan</b></td></tr>";
            while ($hasil  = mysql_fetch_assoc($data)){
              $j++;
            echo "<tr><td>$i</td><td>".$hasil['NamaLengkap']."</td><td align=\"center\">".jur_det($hasil['Jurusan'])."</td>";
            //hadir
            $arr[$j]   = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1' LIMIT 23";
            //Terlambat
            $arr1[$j]  = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND JamMasuk <> '00:00:00' AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
            //pulang cepat 1
            $arr2[$j]  = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND JamMasuk <> '00:00:00' AND login='".$hasil['Nama']."' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
            //pulang cepat 2
            $arr3[$j]  = "SELECT id FROM presensi WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday' AND login = '".$hasil['Nama']."' AND JamKeluar <=135959 LIMIT 23";
            //pulang cepat 3
            $arr4[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'";
            //pulang cepat 4
            $arr5[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'";
            //datang terlambat
            $arr6[$j]  = "SELECT id FROM presensi WHERE JamMasuk IS NULL AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23";
            //tugas dinas
            $arr7[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='3' LIMIT 22";
            //Ijin alasan penting
            $arr8[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='4' LIMIT 22";
            //presensi manual
            $arr9[$j]  = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='5' LIMIT 22";
            //ijin sakit
            $arr10[$j] = "SELECT id FROM presensi WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND abs='6' LIMIT 22";
            $data1     = mysql_query($arr[$j]);//Query Kehadiran
            $data2     = mysql_query($arr1[$j]);//Query terlambat
            $data3     = mysql_query($arr2[$j]);//Query Pulang cepat
            $data4     = mysql_query($arr3[$j]);//Query Pulang cepat
            $data6     = mysql_query($arr4[$j]);//Query Pulang cepat
            $data7     = mysql_query($arr5[$j]);//Query Pulang cepat
            $data8     = mysql_query($arr6[$j]);//Query terlambat
            $Dmanual   = mysql_query($arr9[$j]);//Query presensi manual
            $Dtugas    = mysql_query($arr7[$j]);//Query Tugas Dinas
            $Dijin     = mysql_query($arr8[$j]);//Query Ijin Alasan penting
            $Dsakit    = mysql_query($arr10[$j]);//Query Ijin Sakit
            $manual    = mysql_num_rows($Dmanual);//jumlah presensi manual
            $ijin      = mysql_num_rows($Dijin);//jumlah ijin alasan penting
            $sakit     = mysql_num_rows($Dsakit);//jumlah sakit
            $tugas     = mysql_num_rows($Dtugas);//jumlah tugas dinas
            $telat     = mysql_num_rows($data2);//jumlah terlambat
            $telat1    = mysql_num_rows($data8);//jumlah terlambat
            $hadir     = mysql_num_rows($data1);//jumlah kehadiran
            $cepat     = mysql_num_rows($data3);//jumlah pulang cepat
            $cepat1    = mysql_num_rows($data4);//jumlah pulang cepat
            $cepat2    = mysql_num_rows($data6);//jumlah pulang cepat
            $cepat3    = mysql_num_rows($data7);//jumlah pulang cepat
            $ttltelat  =$telat1 + $telat;//total telat
            $tt_hadir  = $hadir + $manual;//total hadir
            $absen = $Jmlhari-$tt_hadir-$sakit-$ijin-$tugas;
            $plgcepat = $cepat+$cepat1+$cepat2+$cepat3;
            if($absen < 0){
                $abs="0";
            }else{
                $abs=$absen;
            }
             echo "<td align=\"center\">".$tt_hadir."</td><td align=\"center\">".$ttltelat."</td><td align=\"center\">".$plgcepat."</td><td align=\"center\">".$tugas."</td><td align=\"center\">".$ijin."</td><td align=\"center\">".$sakit."</td><td align=\"center\">".$abs."</td></tr>";
            $i++;
            }
            echo "</table>";
            echo "<br />";
            echo "<b>Catatan :</b><br />";
            echo "Terlambat dihitung apabila datang telah lewat atau sama dengan pukul 07.11<br />Pulang cepat dihitung apabila pulang lebih cepat dari pukul :";
            echo "<blockquote>(senin s.d. kamis sebelum 15.30 dan jum'at sebelum 14.00)</blockquote>";
        }
        
  }
?>
</body>
</html>