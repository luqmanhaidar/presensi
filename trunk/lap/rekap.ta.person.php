<?php
define("ACCESS","adm_rekap_per");
require_once("adm.db.php");
require     ("adm.init.php");
include     ("adm.header.php");
$fakk=$_SESSION['userdata']['Fak'];
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <div></div>
    <h1>Rekap Personal Presensi Tugas Akhir Mahasiswa</h1>
    <form method="post" class="nice">
    <select name="bln" class="inputTS">
    <option>-Bulan-</option>
    <option value="01">Januari</option>
    <option value="02">Februari</option>
    <option value="03">Maret</option>
    <option value="04">April</option>
    <option value="05">Mei</option>
    <option value="06">Juni</option>
    <option value="07">Juli</option>
    <option value="08">Agustus</option>
    <option value="09">September</option>
    <option value="10">Oktober</option>
    <option value="11">November</option>
    <option value="12">Desember</option>
    </select>
    <select name="thn" class="inputTS">
    <option>-Tahun-</option>
        <?php
        for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        ?>
    </select>
    <select name="nama" class="inputTS">
    <option>-Nama-</option>
    <?php
        $nama=fetchRow("profile","where Jabatan='Mahasiswa' and Fak='$fakk' order by NamaLengkap ASC","NamaLengkap,Nama,id");
        foreach($nama as $n){
            echo "<option value=\"".$n['Nama']."\">".$n['NamaLengkap']."</option>\n";
        }
    ?>
    </select>
    <button type="submit" class="green" name="submit">Tampil</button>
    </form>
    <?php
    if($_POST['nama']){
        $uid=$_POST['nama'];
        $bln=$_POST['bln'];
        $thn=$_POST['thn'];
        $bt =$bln."-".$thn;
        $i  =1;
        $data=fetchRow("profile,presensi","where profile.Nama=presensi.login and date_format(presensi.Tanggal,'%m-%Y')='$bt' and presensi.login='$uid' ","profile.NamaLengkap,profile.Nip,profile.Jurusan,presensi.Tanggal,presensi.JamKeluar,presensi.JamMasuk,presensi.FotoMasuk,presensi.FotoKeluar,profile.id");
        echo "<table width=\"100%\" id=\"data\">";
        echo "<tr><th>No</th><th>Nama Lengkap</th><th>NiM</th><th>Hari Tanggal</th><th>Jam Masuk</th><th>JamKeluar</th><th>Foto Masuk</th><th>Foto Keluar</th></tr>";
        foreach($data as $d){
            echo "<tr><td>$i</td><td>".$d['NamaLengkap']."</td><td>".$d['Nip']."</td><td>".$d['Tanggal']."</td><td>".$d['JamMasuk']."</td><td>".$d['JamKeluar']."</td><td><a href=\"../".$d['FotoMasuk']."\" title=\"Foto Masuk ".$d['NamaLengkap']."\" class=\"thickbox\"><img src='../".$d['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$d['FotoKeluar']."\" title=\"Foto Keluar ".$d['NamaLengkap']."\" class=\"thickbox\"><img src='../".$d['FotoKeluar']."' width='95'></a></td></tr>";
            $nim=$d['id'];
            $i++;
        }
        echo "</table>";
        echo "<a href=\"cetak.ta.php?cat=person&nim=".$nim."&bln=".$bln."&thn=".$thn."\" title=\"Cetak Presensi\"><img src=\"images/Printer.png\"></a>";
    }
    ?>
</div>
</div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>