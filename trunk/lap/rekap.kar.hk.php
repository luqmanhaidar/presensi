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
    require_once("adm.db.php");
    include     ("func_date.php");
if(isset($_POST['submit'])){
    $subbag    = $_POST['subbag'];
    $Fakk      = $_SESSION['userdata']['Fak'];
    $bag       = $_SESSION['userdata']['ulname'];
    $end       = date('Y-m-d');
    $tgl       = explode('-',$end);
    $thn       = $tgl[0];
    $bln       = $tgl[1];
    $start     = $thn."-".$bln."-1";
    $tend      = $thn."-".$bln."-31";
    $i         = 1;
    $j         = 0;
    $arr       = array();
    $arr1      = array();
    $arr2      = array();
    $arr3      = array();
    $arr4      = array();
    $arr5      = array();
    $arr6      = array();
    $arr7      = array();
    $arr8      = array();
    $arr9      = array();
    $arr10     = array();
    $arr11     = array();
    $SQLi      = mysql_query("SELECT COUNT(*) FROM hari_libur WHERE Tanggal BETWEEN '".$start."' AND '".$end."'");
    $SQLttli   = mysql_query("SELECT COUNT(*) FROM hari_libur WHERE Tanggal BETWEEN '".$start."' AND '".$tend."'");
    $ttlibur   = mysql_result($SQLttli,0,0);
    $libur     = mysql_result($SQLi,0,0);
    $jml_hari  = dateDiff($start,$end);
    $jml_httl  = $jml_hari+1;
    $jml_mingu = hitung_minggu($start,$end);
    $jml_sabtu = hitung_sabtu($start,$end);
    $jml_hk    = $jml_httl-$jml_mingu-$jml_sabtu-$libur;
    $jml_hbln  = hitung_hari($bln,$thn);
    $jml_tming = hitung_minggu($start,$tend);
    $jml_tsabt = hitung_sabtu($start,$tend);
    $jml_hkttl = $jml_hbln-$jml_tming-$jml_tsabt-$ttlibur;
    switch($bag){
        case "BUPK" :
            if($subbag == 'all'){
                $SQL= mysql_query("SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='BUPK' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC");
            }else{
                $SQL= mysql_query("SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='BUPK' AND bag='$Fakk' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC");
            }
            break;
        case "BAKI"  :
            if($subbag == 'all'){
                $SQL= mysql_query("SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='BAKI' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC");
            }else{
                $SQL= mysql_query("SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='BAKI' AND bag='$Fakk' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC");
            }
            break;
        default     :
            if($subbag == 'all'){
                $SQL= mysql_query("SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan <> 'PKL' AND status='1' ORDER BY Gol DESC");
            }else{
                $SQL= mysql_query("SELECT DISTINCT (NamaLengkap),(Nama),(Jurusan),(Gol) FROM profile WHERE Jabatan='Karyawan' AND Fak='$Fakk' AND Jurusan = '$subbag' AND status='1' ORDER BY Gol DESC");
            }
            break;
    }
    echo "<table>";
    echo "<tr><td><b>Rekap Kehadiran</b></td><td></td></tr>";
    echo "<tr><td><b>Dari</b></td><td>: ".dateConv($start)."&nbsp;&nbsp; s/d &nbsp;&nbsp;".dateConv($end)."</td></tr>";
    echo "<tr><td><b>Jumlah Hari Kerja</b></td><td>: ".$jml_hk." hari</td></tr>";
    echo "<tr><td><b>Jumlah Hari Kerja Bulan ".bulan_id($bln)."</b></td><td>: ".$jml_hkttl." hari</td></tr>";
    //echo "<tr><td><b>Jumlah Hari Hari Sabtu ".bulan_id($bln)."</b></td><td>: ".$jml_sabtu." hari</td></tr>";
    //echo "<tr><td><b>Jumlah Hari Hari Minggu ".bulan_id($bln)."</b></td><td>: ".$jml_mingu." hari</td></tr>";
    //echo "<tr><td><b>Jumlah Libur ".bulan_id($bln)."</b></td><td>: ".$libur." hari</td></tr>";
    //echo "<tr><td><b>Jumlah Hari Total ".bulan_id($bln)."</b></td><td>: ".$jml_httl." hari</td></tr>";
    echo "<tr><td><b>Unit Kerja Utama</b></td><td>: ".$Fakk."</td></tr>";
    echo "</table>";
    echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\"><b>Unit Kerja</b></td><td colspan=\"8\" align=\"center\"><b>JUMLAH</b></td></tr>";
    echo "<tr><td><b>Hadir</b></td><td><b>Terlambat</b></td><td><b>Pulang Cepat</b></td><td><b>Dinas Luar</b></td><td><b>Izin AP</b></td><td><b>Izin Sakit</b></td><td><b>Cuti</b></td><td><b>Tanpa Ket</b></td></tr>";
    while ($Res= mysql_fetch_assoc($SQL)){
        $j++;
        echo "<tr><td>$i</td><td>".$Res['NamaLengkap']."</td><td>".jur_det($Res['Jurusan'])."</td>";
        $arr[$j]  = "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND abs='1' LIMIT 23";
        $arr1[$j] = "SELECT id FROM presensi WHERE JamMasuk >=071100 AND JamMasuk <> '00:00:00' AND login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' LIMIT 23";
        $arr2[$j] = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND JamKeluar <> '00:00:00' AND login='".$Res['Nama']."' AND dayname( presensi.Tanggal ) <> 'friday' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' LIMIT 23";
        $arr3[$j] = "SELECT id FROM presensi WHERE presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND dayname( presensi.Tanggal ) = 'friday' AND login = '".$Res['Nama']."' AND JamKeluar <=135959 AND JamKeluar <> '00:00:00' LIMIT 23";
        $arr4[$j] = "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND dayname( presensi.Tanggal ) <> 'friday'";
        $arr5[$j] = "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND dayname( presensi.Tanggal ) = 'friday'";
        $arr6[$j] = "SELECT id FROM presensi WHERE JamMasuk IS NULL AND login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' LIMIT 23";
        $arr7[$j] = "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND abs = '4' LIMIT 23";
        $arr8[$j] = "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND abs = '3' LIMIT 23";
        $arr9[$j] = "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND abs = '6' LIMIT 23";
        $arr10[$j]= "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND abs = '5' LIMIT 23";
        $arr11[$j]= "SELECT id FROM presensi WHERE login='".$Res['Nama']."' AND presensi.Tanggal BETWEEN '".$start."' AND '".$end."' AND abs = '7' LIMIT 23";
        //
        $QRes     = mysql_query($arr[$j]);
        $QRes1    = mysql_query($arr1[$j]);
        $QRes2    = mysql_query($arr2[$j]);
        $QRes3    = mysql_query($arr3[$j]);
        $QRes4    = mysql_query($arr4[$j]);
        $QRes5    = mysql_query($arr5[$j]);
        $QRes6    = mysql_query($arr6[$j]);
        $QRes7    = mysql_query($arr7[$j]);
        $QRes8    = mysql_query($arr8[$j]);
        $QRes9    = mysql_query($arr9[$j]);
        $QRes10   = mysql_query($arr10[$j]);
        $QRes11   = mysql_query($arr11[$j]);
        //
        $hadir    = mysql_num_rows($QRes);
        $telat    = mysql_num_rows($QRes1);
        $plg_awal = mysql_num_rows($QRes2);
        $plg_awal1= mysql_num_rows($QRes3);
        $plg_awal2= mysql_num_rows($QRes4);
        $plg_awal3= mysql_num_rows($QRes5);
        $telat1   = mysql_num_rows($QRes6);
        $ijin     = mysql_num_rows($QRes7);
        $tugas    = mysql_num_rows($QRes8);
        $sakit    = mysql_num_rows($QRes9);
        $manual   = mysql_num_rows($QRes10);
        $cuti     = mysql_num_rows($QRes11);
        $ttlhadir = $hadir+$manual;
        $ttltelat = $telat+$telat1;
        $ttlplgawl= $plg_awal+$plg_awal1+$plg_awal2+$plg_awal3;
        $absen    = $jml_hk-$ttlhadir-$ijin-$tugas-$sakit-$cuti;
            echo "<td align=\"center\">".$ttlhadir."</td><td align=\"center\">".$ttltelat."</td><td align=\"center\">".$ttlplgawl."</td><td align=\"center\">".$tugas."</td><td align=\"center\">".$ijin."</td><td align=\"center\">".$sakit."</td><td>".$cuti."</td>";
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