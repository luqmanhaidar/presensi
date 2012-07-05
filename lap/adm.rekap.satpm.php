<?php
define("ACCESS","adm_rekap_satpam");
require("adm.db.php");
require("adm.init.php");
include("adm.header.php");
include ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <h1>Rekap Presensi Satpam / Petugas Jaga Malam</h1>
    <form method="post" class="nice">
        <p class="left">
            <label><b>Bulan</b></label>
            <select class="inputText" name="bulan">
                <option>-Pilih Bulan-</option>
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
            <label>Tahun</label>
            <select class="inputText" name="Tahun">
                <option>-Pilih Tahun-</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
            </select>    
        </p>
        <p class="right">
            <label><b> Nama Pegawai</b></label>
            <select class="inputText" name="pegawai">
                <option>-Pilih Pegawai-</option
                <?php
                    $peg=fetchRow("profile","where jurusan = 'Security'");
                    foreach ($peg as $sec)
                    {
                        echo "<option value=\"".$sec['Nama']."\">".$sec['NamaLengkap']."</option>";
                    }
                ?>
            </select>
            <br clear="all">
            <button type="submit" class="green" name="submit">submit</button>
            
        </p>
        <br clear="all">
    </form>
    <?php
        if(isset($_POST['submit']))
        {
            $bulan  =$_POST['bulan'];
            $tahun  =$_POST['Tahun'];
            $bt     =$bulan."-".$tahun;
            $nama   =$_POST['pegawai'];
            $i=1;
            echo "<table width=\"100%\" id=\"data\">";
            echo "<tr><th><b>No</b></th><th><b>Nama lengkap</b></th><th><b>Tanggal</b></th><th>Shift</th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th>Jam Kerja</th></tr>";
            $pegawai=fetchRow("profile,satpam","where profile.Nama=satpam.login and satpam.login='".$nama."' and date_format(satpam.Tanggal,'%m-%Y')='".$bt."'","profile.NamaLengkap, profile.Nip, satpam.Tanggal, satpam.Shift,satpam.nip,satpam.JamMasuk,satpam.JamKeluar,TIMEDIFF( JamKeluar, JamMasuk ) AS Jumlah");
            //print_r($pegawai);
            foreach ($pegawai as $pegw)
            {
                echo "<tr><td>".$i."</td><td>".$pegw['NamaLengkap']."</td><td>".$pegw['Tanggal']."</td><td>".$pegw['Shift']."</td><td>".$pegw['JamMasuk']."</td><td>".$pegw['JamKeluar']."</td><td>".$pegw['Jumlah']."</td></tr>";
                $i++;
            }
            $kerja=fetchRow("satpam","where login='".$nama."' AND date_format(satpam.Tanggal,'%m-%Y')='".$bt."' ","sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS JamKerja,count(Tanggal) AS Jmlhadir");
            foreach($kerja as $ker)
            {
                echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja</b></th><th>".$ker['JamKerja']."</th></tr>";
                $JamKerj=$ker['JamKerja'];
            }
            $query=mysql_query("SELECT JamKerja FROM harikerja WHERE Bulan='".$bt."'");
            while ($row=mysql_fetch_object($query))
            {
                $JK= $row->JamKerja;
                
            }
            //$Kkurang= $JK - $JamKerj ;
            /**
            $a=10;
            $b=20;
            if($a > $b){
                $x=$a-$b;
                echo $x;
                echo "<br/>";
                echo abs($x);
            }else{
                $x=$a-$b;
                echo $x;
                echo abs($x);
            }
            **/
            if($JK > $JamKerj){
                $kurang= $JK - $JamKerj;
                $lebih= 0;
                
            }else{
                $lbh=$JK - $JamKerj;
                $lebih = abs($lbh);
                $kurang= 0;
            }
            echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\"><b>Jumlah kehadiran</b></th><th><b>".$ker['Jmlhadir']."</b></th></tr>";
            echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\"><b>Kekurangan Jam</b></th><th><b>".$kurang."</b></th></tr>";
            echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\"><b>Kelebihan jam</th><th><b>".$lebih."</b></th></tr>";
            echo "</table>";
        }
    ?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include ("adm.footer.php"); ?>