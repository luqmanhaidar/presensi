<?php
define      ("ACCESS","adm_rekap_mas");
require_once("adm.db.php");
require     ("adm.init.php");
include     ("adm.header.php");
include     ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <?php
        if(isset($_POST['submit'])){
            $jur=$_POST['jurusan'];
            $str=$_POST['start'];
            $tgx=explode("-",$str);
            $thn=$tgx[0];
            $bln=$tgx[1];
            $tgl=$tgx[2];
            $bt =$bln."-".$thn;
            $i  =1;
            $SQL=fetchRow("profile,presensi","where presensi.login=profile.Nama AND profile.Jabatan='Mahasiswa' AND profile.Jurusan='$jur' AND presensi.Tanggal='$str' ","profile.Nip,profile.NamaLengkap,profile.Jurusan,presensi.Tanggal,presensi.FotoMasuk,FotoKeluar,presensi.JamMasuk,presensi.JamKeluar,date_format(presensi.Tanggal,'%a') AS hari");
            echo "<h1>Daftar Presensi Tugas Akhir Mahasiswa</h1>";
            echo "<table width=\"100%\" id=\"data\">";
            echo "<tr><th><b>No</b></th><th><b>Nama Lengkap</b></th><th><b>NIM</b></th><th><b>Tanggal</b></th><th><b>Jam Masuk</b></th><th><b>Jam keluar</b></th><th><b>Foto masuk</b></th><th><b>Foto keluar</b></th></tr>";
            foreach($SQL as $data){
                echo "<tr><td>$i</td><td>".$data['NamaLengkap']."</td><td>".$data['Nip']."</td><td>".indonesian_date($data['hari'])." ".dateConv($data['Tanggal'])."</td><td>".$data['JamMasuk']."</td><td>".$data['JamKeluar']."</td><td><a href=\"../".$data['FotoMasuk']."\" title=\"Foto Masuk ".$data['NamaLengkap']."\" class=\"thickbox\"><img src='../".$data['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$data['FotoKeluar']."\" title=\"Foto Keluar ".$data['NamaLengkap']."\" class=\"thickbox\"><img src='../".$data['FotoKeluar']."' width='95'></a></td></tr>";
                $i++;
            }
            echo "</table";
            echo "<a href=\"cetak.ta.php?cat=harian&jur=".$jur."&bln=".$bln."&thn=".$thn."&tgl=".$tgl."\" title=\"Cetak Presensi\"><img src=\"images/Printer.png\"></a>";
        }else{
            echo "<div></div>";
            echo "<h1>Daftar Presensi Tugas Akhir Mahasiswa</h1>";
            echo "<br />";
            echo "<form method=\"post\" class=\"nice\">";
            echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
            $fakk=$_SESSION['userdata']['Fak'];
            $subag=fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen'");
            echo "<select name=\"jurusan\" class=\"inputText\">";
            echo "<option value=\"\"> -Jurusan- </option>\n";
            //echo "<option value=\"all\"> -Tampil Semua- </option>\n";
            foreach ($subag as $s){
                    echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
            }
            echo "</select>\n";
            echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
            echo "</form>";
        }
    ?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php");?>
