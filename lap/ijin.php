<?php
define("ACCESS","ijin");
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
                    $user       = $_POST['Nama'];
                    $Tanggal    = $_POST['hari'];
                    $alasan     = $_POST['alasan'];
                    $catatan    = $_POST['Catatan'];
                    $sUser=fetchDistinct("profile","where Nama='".$user."'");                    
                    foreach ($sUser as $Nama)
                    {
                        
                        $namaLengkap = $Nama[NamaLengkap];
                        $nip         = $Nama[Nip];
                        $nama        = $Nama[Nama];
                        if($alasan == '3'){
                            $jamMasuk  = '07:00:00';
                            $jamKeluar = '15:30:00';
                        }else{
                            $jamMasuk  = '00:00:00';
                            $jamKeluar = '00:00:00';
                        }
                        $SQL= mysql_query("SELECT id FROM presensi WHERE login='".$nama."' AND Tanggal='$Tanggal'");
                        if($row=mysql_num_rows($SQL)>0){
                            echo "<script type=\"text/javascript\">alert('Insert Izin Gagal Yang Bersangkutan Telah Presensi masuk'); window.location =\"ijin.php\";</script>";
                        
                        }else{
                            $sql="INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,Jamkeluar,abs,catatan) VALUES ('$nip','$nama','$Tanggal','$jamMasuk','$jamKeluar','$alasan','$catatan')";
                            if($res=mysql_query($sql)){
                                echo "<script type=\"text/javascript\">alert('Insert Ijin Sukses'); window.location =\"ijin.php\";</script>"; 
                             }else{
                                 echo "<script type=\"text/javascript\">alert('Insert Ijin Gagal'); window.location =\"ijin.php\";</script>";
                             }
                        }
                    }                    
                }
                else
                    {
                        $bag= $_SESSION['userdata']['ulname'];
                        switch($bag){
                            case    "BAUK"  :
                                $gol=fetchDistinct("profile","where Fak='BAUK' AND bag='".$fakk."' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");                        
                                break;
                            case    "BAAKPSI"   :                               
                                $gol=fetchDistinct("profile","where Fak='BAAKPSI' AND bag='".$fakk."' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");                               
                                break;
                            case    "WATES"   :                               
                                $gol=fetchDistinct("profile","where bag='WATES' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");                               
                                break;
                            default     :
                                $gol=fetchDistinct("profile","where Fak='".$fakk."' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");                                
                                break;
                        }
                        echo "<h1>Tambah Data Ijin Tidak Masuk</h1>";
                        echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                        echo "<br />";
                        echo "<div>";
                        echo "<form method=\"post\" class=\"nice\">";
                        echo "<p class=\"left\">";
                        echo "<label><b>Nama Lengkap</b></label>";                                
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
                        echo "<label><b>Alasan Tidak Masuk</b></label><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Dinas Luar</b><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"4\"/> <b>IZIN Alasan Penting</b><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"6\"/> <b>IZIN Sakit</b><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"7\"/> <b>Cuti</b><br />";
                        echo "<label><b>Keterangan</b></label>";
                        //echo "<input name=\"Catatan\" class=\"inputText_wide\" type=\"text\" />";
                        echo "<textarea name=\"Catatan\" cols=\"\" rows=\"10\" class=\"inputTextArea\"></textarea>";
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
                    $alasan =$_POST['alasan'];
                    $sql="UPDATE presensi SET Tanggal='".$Tanggal."',catatan='".$catatan."',abs='".$alasan."' WHERE id='".$id."'";
                    if($res=mysql_query($sql))
                    {
                        echo "<script type=\"text/javascript\">alert('Edit Data Ijin Sukses'); window.location =\"ijin.php\";</script>"; 
                    }
                    else{
                        echo "<script type=\"text/javascript\">alert('Edit Data Ijin Gagal'); window.location =\"ijin.php\";</script>";
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
                    echo "<label><b>Alasan Tidak Masuk</b></label><br />";
                    switch ($gol[abs]){
                        case "4" :
                            echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Dinas Luar</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"4\" CHECKED/> <b>IZIN Alasan Penting</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"6\"/> <b>IZIN Sakit</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"7\"/> <b>Cuti</b><br />";
                            break;
                        case "3" :
                            echo "<input name=\"alasan\" type=\"radio\" value=\"3\" CHECKED/> <b>Dinas Luar</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"4\"/> <b>IZIN Alasan Penting</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"6\"/> <b>IZIN Sakit</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"7\"/> <b>Cuti</b><br />";
                            break;
                        case "6" :
                            echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Dinas Luar</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"4\"/> <b>IZIN Alasan Penting</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"6\" CHECKED/> <b>IZIN Sakit</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"7\"/> <b>Cuti</b><br />";
                            break;
                        case "7" :
                            echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Dinas Luar</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"4\"/> <b>IZIN Alasan Penting</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"6\"/> <b>IZIN Sakit</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"7\" CHECKED/> <b>Cuti</b><br />";
                            break;
                        default  :
                            echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Dinas Luar</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"4\"/> <b>IZIN Alasan Penting</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"6\"/> <b>IZIN Sakit</b><br />";
                            echo "<input name=\"alasan\" type=\"radio\" value=\"7\"/> <b>Cuti</b><br />";
                            break;
                    }
                    
                    echo "<label><b>Keterangan</b></label>";
                    //echo "<input name=\"Catatan\" class=\"inputText_wide\" type=\"text\" value=\"".$gol[catatan]."\" />";
                    echo "<textarea name=\"Catatan\" cols=\"\" rows=\"10\" class=\"inputTextArea\">".$gol[catatan]."</textarea>";
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
                        echo "<script>alert('Hapus Ijin Sukses'); window.location=\"ijin.php\"</script>";
                   }else{
                        echo "<script>alert('Hapus Ijin Gagal'); window.location=\"ijin.php\"</script>";
                   }
                break;
            default         :
                $fakk=$_SESSION['userdata']['Fak'];
                $bag= $_SESSION['userdata']['ulname'];
                echo "<h1>Managemen Izin Pegawai</h1>";
                //echo $fakk;
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."?cat=new\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Tambah Baru</a></div>";
                echo "<div>";
                $max=30;
                $i=1;
                $listnav=new CnnNav($max,"presensi","where abs <> '1' AND abs <> '2' AND abs <> '5' AND abs <> '0' ","*","id","9","5","3","&laquo;","&raquo;"," ", "");
                $start=$_GET['offset']?$_GET['offset']*$max:0;
                switch($bag){
                    case    "BAUK"  :
                        $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.abs <>'1' AND presensi.abs <> '5' AND presensi.abs <> '2' AND presensi.abs <> '0' AND profile.Fak='BAUK' AND profile.bag='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                        break;
                    case    "BAAKPSI" :
                        $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.abs <>'1' AND presensi.abs <> '5' AND presensi.abs <> '2' AND presensi.abs <> '0' AND profile.Fak='BAAKPSI' AND profile.bag='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                        break;
                    case    "WATES" :
                        $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.abs <>'1' AND presensi.abs <> '5' AND presensi.abs <> '2' AND presensi.abs <> '0' AND profile.bag='WATES' order by presensi.Tanggal desc limit ".$start.",".$max."");
                        break;
                    default :
                        $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.abs <>'1' AND presensi.abs <> '5' AND presensi.abs <> '2' AND presensi.abs <> '0' AND profile.Fak='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                        break;
                }
                echo "<br />";
                if(!empty($nUser))
                    {
                        echo "<table width=\"100%\" id=\"data\">";
                        echo "<tr><th>No</th><th>Nama Lengkap</th><th>Jabatan</th><th>Tanggal</th><th>Alasan</th><th>Keterangan</th><th>Edit</th><th>Hapus</th></tr>";
                        foreach($nUser as $u){
                            echo "<tr><td>$i</td><td>$u[NamaLengkap]</td><td>$u[Jabatan]</td><td>$u[Tanggal]</td>";
                            switch ($u[abs]){
                                case "4" :
                                    echo "<td>Izin Alasan penting</td>";
                                    break;
                                case "3" :
                                    echo "<td>Tugas Dinas</td>";
                                    break;
                                case "6" :
                                    echo "<td>Izin Sakit</td>";
                                    break;
                                case "7" :
                                    echo "<td>Cuti</td>";
                                    break;
                                default  :
                                    echo "<td>Tanpa Keterangan</td>";
                                    break;
                            }
                            echo "<td>$u[catatan]</td><td><a href='ijin.php?cat=edit&id=$u[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"ijin.php?cat=del&id=$u[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
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
                        echo "Data Ijin Tidak Masuk Tidak Ada (Masih Kosong)";
                        echo "</b></p></div>";
                    }                 
            break;
        }
    ?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>