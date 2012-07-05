<?php
define("ACCESS","adm_rekap_bul");
require_once("adm.db.php");
require     ("adm.init.php");
include     ("adm.header.php");
include     ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <?php
    echo "<div></div>";
    echo "<h1>Rekap Bulanan Presensi Tugas Akhir Mahasiswa</h1>";
    echo "<form method=\"post\" class=\"nice\">";
    echo "<select name=\"thn\" class=\"inputTS\">";
    echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
    echo "</select>";
    echo "<select name=\"bln\" class=\"inputTS\">";
    echo "<option>Bulan</option>\n";
    echo "<option value=\"01\">Januari</option>\n";
    echo "<option value=\"02\">Februari</option>\n";
    echo "<option value=\"03\">Maret</option>\n";
    echo "<option value=\"04\">April</option>\n";
    echo "<option value=\"05\">Mei</option>\n";
    echo "<option value=\"06\">Juni</option>\n";
    echo "<option value=\"07\">Juli</option>\n";
    echo "<option value=\"08\">Agustus</option>\n";
    echo "<option value=\"09\">September</option>\n";
    echo "<option value=\"10\">Oktober</option>\n";
    echo "<option value=\"11\">November</option>\n";
    echo "<option value=\"12\">Desember</option>\n";
    echo "</select>";
    $fakk=$_SESSION['userdata']['Fak'];
            $subag=fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen'");
            echo "<select name=\"jurusan\" class=\"inputTS\">";
            echo "<option value=\"\"> -Jurusan- </option>\n";
            //echo "<option value=\"all\"> -Tampil Semua- </option>\n";
            foreach ($subag as $s){
                    echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
            }
            echo "</select>\n";
            echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
    echo "</form>";
     if(isset($_POST['submit'])){
        $bln=$_POST['bln'];
        $thn=$_POST['thn'];
        $jur=$_POST['jurusan'];
        $bt =$bln."-".$thn;
        $j=1;
        $i=1;
        $ar= array();
        $SQL=fetchDistinct("profile","where Jabatan='Mahasiswa' and Jurusan='".$jur."'","Nama,NamaLengkap,Nip,Jurusan");
        echo "<div></div>";
        echo "<table width=\"100%\" id=\"data\">";
        echo "<tr><th>No</th><th>Nama</th><th>NIM</th><th>Jurusan</th><th>Jumlah Kehadiran</th></tr>";
        foreach($SQL as $dt){
            echo "<tr><td>$i</td><td>".$dt['NamaLengkap']."</td><td>".$dt['Nip']."</td><td>".jur_det($dt['Jurusan'])."</td>";
            $ar[$j]=numRow("presensi","where login='".$dt['Nama']."' and abs='1' and date_format(Tanggal,'%m-%Y')='$bt'");
            echo "<td>".$ar[$j]."</td></tr>";
            $i++;
        }
        echo "</table>";
        echo "<a href=\"cetak.ta.php?cat=bulanan&jur=".$jur."&bln=".$bln."&thn=".$thn."\" title=\"Cetak Presensi\"><img src=\"images/Printer.png\"></a>";        
    }
    ?>
</div>
</div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>