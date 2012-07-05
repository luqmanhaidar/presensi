<?php
session_start();
  if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
  }
?>
<?php
  include_once ("adm.db.php");
  include      ("func_date.php");
  include      ("adm.header.cetak.php");
  if(isset($_POST['submit'])){
    $Fakk	= $_SESSION['userdata']['Fak'];
    $bln	= mysql_real_escape_string($_POST['bulan']);
    $thn	= mysql_real_escape_string($_POST['tahun']);
    $subbag	= mysql_real_escape_string($_POST['subbag']);
    $bt		= $bln."-".$thn;
    $hal	= $_POST['hal'];
    $start     	= $thn."-".$bln."-1";
    $end      	= $thn."-".$bln."-31";
    if($subbag  == "all"){
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
    $data      = mysql_query($Query);
    $libur     = mysql_result(mysql_query("SELECT COUNT(*) FROM hari_libur WHERE Tanggal BETWEEN '".$start."' AND '".$end."'"),0,0);
    $jml_hbln  = hitung_hari($bln,$thn);
    $jml_tming = count_minggu($jml_hbln,$bln,$thn);
    //$jml_tming = hitung_minggu($start,$end);
    $jml_tsabt = hitung_sabtu($start,$end);
    $jml_hkttl = $jml_hbln-$jml_tming-$jml_tsabt-$libur;
    $i=1;
    $j=0;
    echo "<table>";
    echo "<tr><td><b>Rekap Kehadiran</b></td><td></td></tr>";
    echo "<tr><td><b>Bulan</b></td><td>: ".bulan_id($bln)."&nbsp;&nbsp;".$thn."</td></tr>";
    echo "<tr><td><b>Unit Kerja Utama</b></td><td>: ".$Fakk."</td></tr>";
    echo "<tr><td><b>Jumlah Hari Kerja Bulan ini</b></td><td>: ".$jml_hkttl." hari</td></tr>";
    echo "</table>";
    echo "<table id=\"tabel\"><tr><td rowspan=\"2\"><b>No</b></td><td rowspan=\"2\"><b>Nama Lengkap</b></td><td rowspan=\"2\"><b>Unit Kerja</b></td><td colspan=\"7\" align=\"center\"><b>JUMLAH</b></td></tr>";
    echo "<tr><td><b>Hadir</b></td><td><b>Terlambat</b></td><td><b>Pulang Cepat</b></td><td><b>Dinas Luar</b></td><td><b>Izin AP</b></td><td><b>Izin Sakit</b></td><td><b>Tanpa Ket</b></td></tr>";
    while ($hasil  = mysql_fetch_assoc($data)){
      $j++;
    echo "<tr><td>$i</td><td>".$hasil['NamaLengkap']."</td><td>".jur_det($hasil['Jurusan'])."</td>";
    $hadir[$j]  = countRow("presensi","WHERE login='".$hasil['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND abs='1' LIMIT 23");
    $telat[$j]  = countRow("presensi","WHERE JamMasuk >=071600 AND JamMasuk <> '00:00:00' AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
    $telat1[$j] = countRow("presensi","WHERE JamMasuk IS NULL AND login='".$hasil['Nama']."' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
    $cepat[$j]  = countRow("presensi","WHERE JamKeluar <=152959 AND JamKeluar <> '00:00:00' AND login='".$hasil['Nama']."' AND dayname( presensi.Tanggal ) <> 'friday' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' LIMIT 23");
    $cepat1[$j] = countRow("presensi","WHERE date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday' AND login = '".$hasil['Nama']."' AND JamKeluar <=135959 AND JamKeluar <> '00:00:00' LIMIT 23");
    $cepat2[$j] = countRow("presensi","WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959 AND JamMasuk <> '00:00:00' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) <> 'friday'");
    $cepat3[$j] = countRow("presensi","WHERE login='".$hasil['Nama']."' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959 AND JamMasuk <> '00:00:00' AND  date_format( presensi.Tanggal, '%m-%Y' ) = '$bt' AND dayname( presensi.Tanggal ) = 'friday'");
    $manual[$j] = countRow("presensi","WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '5' LIMIT 23");
    $izin[$j]   = countRow("presensi","WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '4' LIMIT 23");
    $tugas[$j]  = countRow("presensi","WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '3' LIMIT 23");
    $sakit[$j]  = countRow("presensi","WHERE login='".$hasil['Nama']."' AND date_format(presensi.Tanggal,'%m-%Y')='$bt' AND abs = '6' LIMIT 23");
    $ttltelat   = $telat1[$j] + $telat[$j];
    $tt_hadir   = $hadir[$j]+$manual[$j];
    $absen      = $jml_hkttl-$tt_hadir-$izin[$j]-$tugas[$j]-$sakit[$j];
    $plgcepat   = $cepat[$j]+$cepat1[$j]+$cepat2[$j]+$cepat3[$j];
     echo "<td align=\"center\">".$tt_hadir."</td><td align=\"center\">".$ttltelat."</td><td align=\"center\">".$plgcepat."</td><td align=\"center\">".$tugas[$j]."</td><td align=\"center\">".$izin[$j]."</td><td align=\"center\">".$sakit[$j]."</td>";
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