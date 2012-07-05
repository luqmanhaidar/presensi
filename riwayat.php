<?php
session_start();
  if (!isset($_SESSION['uName'])) {
    header("Location: index.php");
  }
require_once "koneksi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sistem Presensi </title>
    <meta name="author" content="Dwi Agus">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script language="javascript" type="text/javascript" src="lap/js/jquery.js"></script>
    <script src="lap/js/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="lap/js/thickbox.js"></script>
    <link rel="stylesheet" href="lap/css/ui.datepicker.css" type="text/css" media="screen" charset="utf-8" />
    <link rel="stylesheet" href="lap/css/thickbox.css" type="text/css" media="screen" />
    <script type="text/javascript" charset="utf-8">
        jQuery(function($){
        $(".dateinput").datepicker({dateFormat: 'yy-mm-dd'});
        });
    </script>
</head>
<body>
    <div id="container">
	<p align="center"><img src="images/uny.png" />&nbsp;&nbsp;<a href="index.php"><img src="images/logo.png" /></a></p>
    <div id="foto">
    <h3><img src="images/icon.gif" /> Riwayat Presensi Pegawai Universitas Negeri Yogyakarta</h3>
    <p align="right"><img src="images/icon.gif" />&nbsp;&nbsp;<a href="logout"><b>Logout</b></a>&nbsp;&nbsp;</p>
    <div id="Rframe">
	<form id="formRwy" method="post" action="">
        <?php echo "<p>Selamat Datang Saudara/i ".$_SESSION['userdata']['NamaLengkap']."<br /> Silahkan Pilih dari tanggal ? - dengan Tanggal ? Kemudian Klik Tampil<br /> Silahkan Klik pada Gambar / Foto Untuk Memperbesar</p>"; ?>
	</form>
    </div>
    <div id="Rframe">
	<form id="formRwy" method="post" action="">
        <b></b>Dari Tanggal <input class="dateinput" name="start" type="text" id="start"> Sampai tanggal </b><input class="dateinput" name="end" type="text" id="end">
        <button type="submit" class="button" name="submit">Tampil</button>
        </p>
	</form>
    </div>
    <?php
    if (isset($_POST['submit'])){
        $Nama    = $_SESSION['uName'];
        $Jabatan = $_SESSION['userdata']['Jabatan'];
	
        $start   = stripslashes(mysql_escape_string(($_POST['start'])));
        $end     = stripslashes(mysql_escape_string(($_POST['end'])));
        $i=1;
        $pecahTanggal = explode("-", $start);
        $tanggal = $pecahTanggal[2];
        $bulan   = $pecahTanggal[1];
        $tahun   = $pecahTanggal[0];
	
        if ($Jabatan== 'Dosen'){
                $Query= mysql_query("Select profile.NamaLengkap,presensi.Nip,presensi.login,presensi.Tanggal,presensi.JamMasuk,presensi.JamKeluar,FotoMasuk,FotoKeluar from profile,presensi where profile.Nama=presensi.login AND presensi.login='$Nama' AND presensi.Tanggal BETWEEN '$start' AND '$end' ORDER BY presensi.Tanggal DESC");
                echo "<table id=\"data\"><tr><th>No</th><th>Nip</th><th>Nama Lengkap</th><th>Tanggal</th><th>Jam Masuk</th><th>Foto Masuk</th></tr>";
                while($hasil=mysql_fetch_assoc($Query)){
                    echo "<tr><td>".$i."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Tanggal']."</td><td>".$hasil['JamMasuk']."</td><td><a href=\"".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src=\"".$hasil['FotoMasuk']."\" width=\"95\"/></a></td></tr>";
                    $i++;
                }
                echo "</table>";
                $row = mysql_num_rows($Query);
                echo "<p><a href=\"#\">&nbsp;&nbsp; Jumlah Kehadiran = $row Kali</a>";
        }elseif($Jabatan == 'Karyawan'){
                $Query= mysql_query("Select profile.NamaLengkap,presensi.Nip,presensi.login,presensi.Tanggal,presensi.JamMasuk,presensi.JamKeluar,FotoMasuk,FotoKeluar from profile,presensi where profile.Nama=presensi.login AND presensi.login='$Nama' AND presensi.Tanggal BETWEEN '$start' AND '$end' ORDER BY presensi.Tanggal DESC");
                echo "<table id=\"data\"><tr><th>No</th><th>Nip</th><th>Nama Lengkap</th><th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Foto Masuk</th><th>Foto keluar</th></tr>";
                while($hasil=mysql_fetch_assoc($Query)){
                    echo "<tr><td>".$i."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Tanggal']."</td><td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td><td><a href=\"".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src=\"".$hasil['FotoMasuk']."\" width=\"95\"/></a></td><td><a href=\"".$hasil['FotoKeluar']."\" title=\"Foto Keluar ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src=\"".$hasil['FotoKeluar']."\" width=\"95\"/></a></td></tr>";
                    $i++;
                }
                echo "</table>";
                $row = mysql_num_rows($Query);
                echo "<p><a href=\"#\">&nbsp;&nbsp; Jumlah Kehadiran = $row Kali</a>";

        }else {
            echo "error";
        }
    }
    ?>
    </div>
    </div>
</body>
</html>
