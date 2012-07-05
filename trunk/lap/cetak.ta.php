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
    #theader
    {
      font-family:Verdana, Arial, Helvetica, sans-serif;
      }
      #tabel td, #tabel th 
      {
      font-size:13px;
      
      }
      #tabel th 
      {
      font-size:13px;
      color:#ffffff;
      }
      #tabel tr.alt td 
      {
      color:#000000;
      background-color:#EAF2D3;
    }
    #tabel
    {
    font-family:Verdana, Arial, Helvetica, sans-serif;
    width:100%;
    border-collapse:collapse;
    }
    #tabel td, #tabel th 
    {
    font-size:12px;
    border:1px solid #000;
    padding:3px 7px 2px 7px;
    }
    #tabel th 
    {
    font-size:12px;
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
$bln= $_GET['bln'];
$thn= $_GET['thn'];
$tgl= $_GET['tgl'];
$bt = $bln."-".$thn;
$nim= $_GET['nim'];
$jur= $_GET['jur'];
$str= $thn."-".$bln."-".$tgl;
$i  =1;
$j  =1;
$arr= array();
switch($_GET['cat']){
    case "harian" :
            $sql=fetchRow("profile,presensi","where presensi.login=profile.Nama AND profile.Jabatan='Mahasiswa' AND profile.Jurusan='$jur' AND presensi.Tanggal='$str' ","profile.Nip,profile.NamaLengkap,profile.Jurusan,presensi.Tanggal,presensi.FotoMasuk,FotoKeluar,presensi.JamMasuk,presensi.JamKeluar,date_format(presensi.Tanggal,'%a') AS hari");
            echo "<h2 align=\"center\">REKAP PRESENSI TUGAS AKHIR MAHASISWA</h2>";
            echo "<h2 align=\"center\">Fakultas Teknik Universitas Negeri Yogyakarta<br />";
            echo "Jurusan : ".jur_det($jur)."</h2>";
            //echo "Bulan : ".bulan_id($bln)." $thn</hr2>";
            echo "<table width=\"100%\" id=\"tabel\">";
            echo "<tr><td><b>No</b></td><td><b>Nama Lengkap</d></td><td><b>NIM</b></td><td><b>Tanggal</b></td><td><b>Jam Masuk</b></td><td><b>Jam keluar</b></td><td><b>Foto masuk</b></td><td><b>Foto keluar</b></td></tr>";
            foreach($sql as $data){
                echo "<tr><td>$i</td><td>".$data['NamaLengkap']."</td><td>".$data['Nip']."</td><td>".indonesian_date($data['hari'])." ".dateConv($data['Tanggal'])."</td><td>".$data['JamMasuk']."</td><td>".$data['JamKeluar']."</td><td><img src='../".$data['FotoMasuk']."' width='95'></td><td><img src='../".$data['FotoKeluar']."' width='95'></td></tr>";
                $i++;
            }
            echo "</table";
        break;
    case "bulanan":
        $usr=fetchDistinct("profile","where Jabatan='Mahasiswa' and Jurusan='$jur'","Nama,NamaLengkap,Jurusan,Nip");
        echo "<h2 align=\"center\">REKAP PRESENSI TUGAS AKHIR MAHASISWA</h2>";
        echo "<h2 align=\"center\">Fakultas Teknik Universitas Negeri Yogyakarta<br />";
        echo "Jurusan : ".jur_det($jur)."<br />";
        echo "Bulan : ".bulan_id($bln)." $thn</hr2>";
        echo "<table width=\"100%\" id=\"tabel\">";
        echo "<tr><td>No</td><td>Nama</td><td>NIM</td><td>Jurusan</td><td>Jumlah Kehadiran</td></tr>";
        foreach($usr as $u){
            echo "<tr><td>$i</td><td>".$u['NamaLengkap']."</td><td>".$u['Nip']."</td><td>".jur_det($u['Jurusan'])."</td>";
            $arr[$j]= numRow("presensi","where login='".$u['Nama']."' and abs='1' and date_format(Tanggal,'%m-%Y')='$bt'");
            echo "<td>".$arr[$j]."</td></tr>";
            $i++;
        }
        echo "</table>";
        break;
    case "person" :
        $sql=fetchRow("profile,presensi","where profile.Nama=presensi.login and profile.id='".$nim."' and date_format(presensi.Tanggal,'%m-%Y')='$bt'","profile.NamaLengkap,profile.Nip,profile.Jurusan,profile.Jurusan,presensi.JamMasuk,presensi.JamKeluar,presensi.Tanggal,presensi.FotoMasuk,presensi.FotoKeluar");
        echo "<h2 align=\"center\">REKAP PRESENSI TUGAS AKHIR MAHASISWA</h2>";
        echo "<h2 align=\"center\">Fakultas Teknik Universitas Negeri Yogyakarta<br />";
        echo "Bulan : ".bulan_id($bln)." $thn</h2>";
        echo "<table width=\"100%\" id=\"tabel\">";
        echo "<tr><td>No</td><td>Nama Lengkap</td><td>NiM</td><td>Hari Tanggal</td><td>Jam Masuk</td><td>JamKeluar</td><td>Foto Masuk</td><td>Foto Keluar</td></tr>";
        foreach($sql as $d){
           echo "<tr><td>$i</td><td>".$d['NamaLengkap']."</td><td>".$d['Nip']."</td><td>".$d['Tanggal']."</td><td>".$d['JamMasuk']."</td><td>".$d['JamKeluar']."</td><td><img src='../".$d['FotoMasuk']."' width='95'></td><td><img src='../".$d['FotoKeluar']."' width='95'></td></tr>";
            $i++;
        }
        echo "</table>";
        break;
    default       :
        echo "Data Tidak Sesuai...";
        break;
}
?>
</body>
</html>