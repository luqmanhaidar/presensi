<?php
define      ("ACCESS","adm_libur");
require_once("adm.db.php");
require     ("adm.init.php");
include     ("adm.header.php");
include     ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <?php
    switch($_GET['cat']){
        case 'new'  :
            if(isset($_POST['submitAd'])){
                $tanggal= $_POST['tanggal'];
                $ket    = $_POST['ket'];
                $search = mysql_query("SELECT id FROM hari_libur WHERE Tanggal='$tanggal'");
                if($row = mysql_num_rows($search) >0){
                    echo "<script type=\"text/javascript\">alert('Insert Gagal, Data Sudah Ada'); window.location =\"adm.libur.php\";</script>";
                }else{
                    if($sql = mysql_query("INSERT INTO hari_libur (Tanggal,Keterangan) VALUES ('$tanggal','$ket')")){
                        echo "<script type=\"text/javascript\">alert('Insert Data Sukses'); window.location =\"adm.libur.php\";</script>";
                    }else{
                        echo "<script type=\"text/javascript\">alert('Insert Data gagal'); window.location =\"adm.libur.php\";</script>";
                    } 
                }
            }else{
                echo "<h1>Tambah Data Libur Nasional</h1>";
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                echo "<br />";
                echo "<div>";
                echo "<form method=\"post\" class=\"nice\">";
                echo "<p class=\"left\">";
                echo "<label><b>Tanggal</b></label>";
                echo "<input name=\"tanggal\" class=\"dateinput\" type=\"text\" />";
                echo "<label><b>Keterangan</b></label>";
                echo "<input name=\"ket\" class=\"inputText_wide\" type=\"text\" />";
                echo "<br clear=\"all\" />";
                echo "</p>";
                echo "<br clear=\"all\" />";
                echo "<button type=\"submit\" class=\"green\" name=\"submitAd\">Submit</button>\n";
                echo "<div class=\"clear\"></div>";
                echo "</form>";
                echo "</div>";
            }
            break;
        case 'edit' :
            if(isset($_POST['submitEd'])){
                $hid = $_POST['no'];
                $tgl = $_POST['tanggal'];
                $ket = $_POST['ket'];
                if($sql=mysql_query("UPDATE hari_libur SET Tanggal='$tgl',Keterangan='$ket' WHERE id='$hid'")){
                    echo "<script>alert('Edit Data Sukses'); window.location=\"adm.libur.php\"</script>";
                }else{
                    echo "<script>alert('Edit Data Gagal'); window.location=\"adm.libur.php\"</script>";
                }
            }else{
                $id=abs((int)$_GET['id']);
                $row=fetch("hari_libur","where id='$id'");
                echo "<h1>Edit Data Hari Libur Nasional</h1>";
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                echo "<br />";
                echo "<div>";
                echo "<form method=\"post\" class=\"nice\">";
                echo "<p class=\"left\">";
                echo "<label><b>Tanggal</b></label>";
                echo "<input name=\"tanggal\" class=\"dateinput\" type=\"text\" value=\"".$row['Tanggal']."\"/>";
                echo "<label><b>Keterangan</b></label>";
                echo "<input name=\"ket\" class=\"inputText_wide\" type=\"text\" value=\"".$row['Keterangan']."\"/>";
                echo "<input name=\"no\" type=\"hidden\" value=\"".$row['id']."\">";
                echo "<br clear=\"all\" />";
                echo "</p>";
                echo "<br clear=\"all\" />";
                echo "<button type=\"submit\" class=\"green\" name=\"submitEd\">Submit</button>\n";
                echo "<div class=\"clear\"></div>";
                echo "</form>";
                echo "</div>";
            }
            break;
        case 'del'  :
            $id=abs((int)$_GET['id']);
            if($sql=mysql_query("DELETE FROM hari_libur WHERE id='$id'")){
                echo "<script type=\"text/javascript\">alert('Hapus Data Sukses'); window.location =\"adm.libur.php\";</script>";
            }else{
                echo "<script type=\"text/javascript\">alert('Hapus Data Sukses'); window.location =\"adm.libur.php\";</script>";
            }
            break;
        default     :
            echo "<h1>Daftar Hari Libur Nasional</h1>";
            echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."?cat=new\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Tambah Baru</a></div>";
            $max=30;
            $i=1;
            $listnav=new CnnNav($max,"hari_libur","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
            $start=$_GET['offset']?$_GET['offset']*$max:0;
            $row=fetchRow("hari_libur","order by Tanggal desc limit ".$start.",".$max."","id,Tanggal,Keterangan,date_format(Tanggal,'%a') AS hari");
            if(!empty($row)){
                echo "<table width=\"100%\" id=\"data\">";
                echo "<tr><th>No</th><th>Tanggal</th><th>Keterangan</th><th>Edit</th><th>Delete</th></tr>";
                foreach($row as $r){
                    echo "<tr><td>$i</td><td>".dateConv($r['Tanggal'])."</td><td>".$r['Keterangan']."</td><td><a href='adm.libur.php?cat=edit&id=$r[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"adm.libur.php?cat=del&id=$r[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "<p>Data Belum Tersedia</p>";
            }
            break;
    }
    ?>
</div>
</div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>