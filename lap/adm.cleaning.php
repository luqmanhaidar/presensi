<?php
  define("ACCESS","rekap_cleaning");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.daftar.php");
?>
  <div class="grid_9 cnt" id="left">
    <div id="ipsum">
        <h1>Rekap Presensi Cleaning Service</h1>
	<form method="post" class="nice">
            <p class="left">
                <label><b>Tahun</b></label>
                <select class="inputText" name="Tahun">
                    <option>-Pilih Tahun-</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                </select>
                <label><b>Bulan</b></label>
                <select class="inputText" name="Bulan">
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
            </p>
            <p class="right">
                <label><b>Nama Lengkap</b></label>
                <select class="inputText" name="Nama">
                    <option>-Pilih Nama-</option>
                    <?php
                        $fak=$_SESSION['userdata']['Fak'];
                        $pkl=fetchRow("profile","where Fak='".$fak."' and Jabatan='Karyawan' and Jurusan='Umper/Cleaning' and status='1'");
                        foreach($pkl as $sis)
                        {
                            echo "<option value=\"".$sis['Nama']."\">".$sis['NamaLengkap']."</option>\n";
                        }
                    ?>
                </select>
                <br clear="all">
                <br clear="all">
                <button type="submit" class="green" name="Submit">Submit</button>
            </p>
            <div class="clear"></div>
        </form>
        <div></div>
        <div>
            <?php
                if(isset($_POST['Submit']))
                {
                    $thn    =$_POST['Tahun'];
                    $bln    =$_POST['Bulan'];
                    $nama   =$_POST['Nama'];
                    $bt     =$bln."-".$thn;
                    $i=1;
                    $data   =fetchRow("profile,presensi","where profile.Nama=presensi.login and presensi.login='".$nama."' and date_format(presensi.Tanggal,'%m-%Y')='".$bt."'");
                    echo "<form method=\"post\" action=\"cetak.cleaning.php\">";
		    echo "<input name=\"Nama\" type=\"hidden\" value=\"$nama\" />";
		    echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
		    echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
		    echo "</form>";
		    echo "<br />";
		    echo "<table width=\"100%\" id=\"data\">";
                    echo "<tr><th>No</th><th>Nama Lengkap</th><th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Foto Masuk</th><th>Foto Keluar</th></tr>";
                    foreach ($data as $PK)
                    {
                        echo "<tr><td>".$i."</td><td>".$PK['NamaLengkap']."</td><td>".$PK['Tanggal']."</td><td>".$PK['JamMasuk']."</td><td>".$PK['JamKeluar']."</td><td><img src=\"../".$PK['FotoMasuk']."\" width=\"95px\"></td><td><img src=\"../".$PK['FotoMasuk']."\" width=\"95px\"></td></tr>";
                        $i++;
                    }
                    echo "<tr><th colspan=\"6\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kedatangan</b></th><th>".count($data)." Hari</th></tr>";
                    echo "</table>";
                    //echo count($data );
                    //echo "1";
                }
            ?>
        </div>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
