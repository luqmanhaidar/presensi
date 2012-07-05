<?php
define("ACCESS","tugas");
require("adm.db.php");
require("adm.init.php");
include("adm.header.php");
include ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
    <?php
    switch ($_GET['cat'])
        {
            case    "new"   :
                $fakk=$_SESSION['userdata']['Fak'];
                if(isset($_POST['submitAd']))
                {
                    $user       =$_POST['Nama'];
                    $Tanggal    = $_POST['hari'];
                    $catatan    = $_POST['Catatan'];
                    $sUser=fetchDistinct("profile","where Nama='".$user."'");                    
                    foreach ($sUser as $Nama)
                    {
                        $namaLengkap = $Nama[NamaLengkap];
                        $nip         = $Nama[Nip];
                        $nama        = $Nama[Nama];
                        $sql="INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,Jamkeluar,abs,catatan) VALUES ('$nip','$nama','$Tanggal','00:00:00','00:00:00','3','$catatan')";
                        if($res=mysql_query($sql)){
                            echo "<script type=\"text/javascript\">alert('Insert Ijin Penugasan Sukses'); window.location =\"tugas.php\";</script>"; 
                         }else{
                             echo "<script type=\"text/javascript\">alert('Insert Ijin penugasan Gagal'); window.location =\"tugas.php\";</script>";
                         }
                    }                    
                }
                else
                    {
                        echo "<h1>Tambah Data Ijin Tidak Masuk (Penugasan)</h1>";
                        echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                        echo "<br />";
                        echo "<div>";
                        echo "<form method=\"post\" class=\"nice\">";
                        echo "<p class=\"left\">";
                        echo "<label><b>Nama Lengkap</b></label>";
                        $gol=fetchDistinct("profile","where Fak='".$fakk."' order by NamaLengkap");
                        echo "<select name=\"Nama\" class=\"inputText\">";
                        echo "<option>- Pilih Pegawai -</option>\n";
                        foreach ($gol as $g){
                            echo "<option value =\"$g[Nama]\">$g[NamaLengkap]</option>\n";
                        }
                        echo "</select>";
                        echo "<label><b>Hari</b></label>";
                        echo "<input name=\"hari\" class=\"dateinput\" type=\"text\" />";
                        echo "</p>";
                        echo "<p class=\"right\">";
                        echo "<label><b>Catatan</b></label>";
                        echo "<input name=\"Catatan\" class=\"inputText_wide\" type=\"text\" />";
                        echo "<br clear=\"all\" />";
                        echo "<button type=\"submit\" class=\"green\" name=\"submitAd\">Submit</button>\n";
                        echo "</p>";
                        echo "<div class=\"clear\"></div>";
                        echo "</form>";
                        echo "</div>";
                    }
            break;
            case    "edit"  :
                $id=abs((int)$_GET['id']);
                if(isset($_POST['submitEd']))
                {
                    $Tanggal=$_POST['Tanggal'];
                    $catatan=$_POST['Catatan'];
                    $sql="UPDATE presensi SET Tanggal='".$Tanggal."',catatan='".$catatan."' WHERE id='".$id."'";
                    if($res=mysql_query($sql))
                    {
                        echo "<script type=\"text/javascript\">alert('Edit Data Ijin Penugasan Sukses'); window.location =\"tugas.php\";</script>"; 
                    }
                    else{
                        echo "<script type=\"text/javascript\">alert('Edit Data Ijin penugasan Gagal'); window.location =\"tugas.php\";</script>";
                         }
                }else{
                    $gol=fetch("profile,presensi","WHERE profile.Nama=presensi.login AND presensi.id='".$id."'");
                
                    echo "<h1>Edit Data Ijin Tidak Masuk Atas Nama ".$gol[NamaLengkap]."</h1>";
                    echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                    echo "<br />";
                    echo "<div>";
                    echo "<form method=\"post\" class=\"nice\">";
                    echo "<p class=\"left\">";
                    echo "<label><b>Nama Lengkap</b></label>";
                    echo "<input name=\"Nama\" class=\"inputText\" disabled=\"disabled\" type=\"text\" value=\"".$gol[NamaLengkap]."\">";
                    echo "<label><b>Tanggal</b></label>";
                    echo "<input name=\"Tanggal\" class=\"dateinput\" type=\"text\" value=\"".$gol[Tanggal]."\">";
                    echo "</p>";
                    echo "<p class=\"right\">";
                    echo "<label><b>Catatan</b></label>";
                    echo "<input name=\"Catatan\" class=\"inputText_wide\" type=\"text\" value=\"".$gol[catatan]."\" />";
                    echo "<br clear=\"all\" />";
                    echo "<button type=\"submit\" class=\"green\" name=\"submitEd\">Submit</button>\n";
                    echo "</p>";
                    echo "<div class=\"clear\"></div>";
                    echo "</form>";
                    echo "</div>";
                }
            break;
            case    "del"   :
                $id=abs((int)$_GET['id']);
                $sql="DELETE FROM presensi WHERE id='".$id."' ";
                if($res=mysql_query($sql)){
                        echo "<script>alert('Hapus Ijin Penugasan Sukses'); window.location=\"tugas.php\"</script>";
                   }else{
                        echo "<script>alert('Hapus Ijin Penugasan Gagal'); window.location=\"tugas.php\"</script>";
                   }
                break;
            default         :
                $fakk=$_SESSION['userdata']['Fak'];
                echo "<h1>Managemen Ijin Penugasan Pegawai </h1>";
                //echo $fakk;
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."?cat=new\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Tambah Baru</a></div>";
                echo "<div>";
                $max=30;
                $i=1;
                $listnav=new CnnNav($max,"presensi","where abs='3'","*","id","9","5","3","&laquo;","&raquo;"," ", "");
                $start=$_GET['offset']?$_GET['offset']*$max:0;
                $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.abs='3' AND profile.Fak='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                echo "<br />";
                if(!empty($nUser))
                    {
                        echo "<table id=\"data\">";
                        echo "<tr><th>No</th><th>Nama Lengkap</th><th>Nip</th><th>Jabatan</th><th>Tanggal</th><th>Keterangan</th><th>Edit</th><th>Hapus</th></tr>";
                        foreach($nUser as $u){
                            echo "<tr><td>$i</td><td>$u[NamaLengkap]</td><td>$u[Nip]</td><td>$u[Jabatan]</td><td>$u[Tanggal]</td><td>$u[catatan]</td><td><a href='ijin.php?cat=edit&id=$u[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"ijin.php?cat=del&id=$u[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
                        $i++;
                        }
                        echo "</table>";
                        echo "</p>";
                        echo "</div>";
                        echo "<div>";
                        echo "<p class= \"info\"><b>";
                        $listnav->printnav();
                        echo "</b></p></div>";  
                    }else
                    {
                        echo "</div>";
                        echo "<div>";
                        echo "<p class= \"info\"><b>";
                        echo "Data Ijin Penugasan Tidak Ada (Masih Kosong)";
                        echo "</b></p></div>";
                    }                 
            break;
        }
    ?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>