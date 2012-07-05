<?php
define("ACCESS","adm_satpam");
require("adm.db.php");
require("adm.init.php");
include("adm.header.php");
include ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <h1>Jumlah kehadiran Satpam / Petugas Jaga Malam</h1>
    <?php
        if(isset($_POST['submit']))
        {
            $Tgl=$_POST['Tanggal'];
            $fak=$_POST['Fakultas'];
            $i=1;
            $satp=fetchRow("profile,satpam","where profile.Nama=satpam.login and satpam.Tanggal='".$Tgl."' and profile.Fak='".$fak."' and profile.Jurusan='Security'");
            echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Kembali</a></div>";
            echo "<table width=\"100%\" id=\"data\">";
            echo "<tr><th>No</th><th>Nama lengkap</th><th>Shift</th><th>Jam Masuk</th><th>Jam keluar</th><th>Foto Masuk</th><th>Foto Keluar</th></tr>";
            foreach ($satp as $satpam)
            {
               $masuk  = explode (" ",$satpam['JamMasuk']);
               $keluar = explode (" ",$satpam['JamKeluar']);
                echo "<tr><td>".$i."</td><td>".$satpam['NamaLengkap']."</td><td>".$satpam['Shift']."</td><td>".$masuk[1]."</td><td>".$keluar[1]."</td><td><img src=\"../".$satpam['FotoMasuk']."\" width=\"95\"></td><td><img src=\"../".$satpam['FotoKeluar']."\" width=\"95\"</td></tr>";
                $i++;
            }
            ?>
           <tr><th colspan="7" class="pagination" scope="col" ></th></tr>
            </table>
           
            
        <?php }else { ?>
            
            <form class="nice" method="post">
                <p class="left">
                    <label><b>Tanggal</b></label>
                    <input type="text" class="dateinput" name="Tanggal">
                </p>
                <p class="right">
                    <label><b>Bagian / Jurusan</b></label>
                    <?php $sat=fetchDistinct("adm_jurusan","","Fakultas");?>
                    <select name="Fakultas" class="inputText">
                        <?php
                            foreach($sat as $bag)
                            {
                                echo "<option value=\"$bag[Fakultas]\">$bag[Fakultas]</option>\n";
                            }
                        ?>
                    </select>
                    <br clear="all">
                    <button type="submit" class="green" name="submit">Submit</button>
                </p>
                <div class="clear"></div>
            </form>
            <?php } ?>
    
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>