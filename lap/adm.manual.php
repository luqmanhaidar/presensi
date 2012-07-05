<?php
define("ACCESS","adm_manual");
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
                //$fakk=$_SESSION['userdata']['Fak'];
                //$bag= $_SESSION['userdata']['ulname'];
                if(isset($_POST['submitAd']))
                {
                    $user       =$_POST['Nama'];
                    $Tanggal    = $_POST['hari'];
                    $catatan    = $_POST['Catatan'];
                    $JamMasuk =$_POST['JamMasuk'];
                    $JamKeluar=$_POST['JamKeluar'];
                    $sUser=fetchDistinct("profile","where Nama='".$user."'");                    
                    foreach ($sUser as $Nama)
                    {
                        $namaLengkap = $Nama[NamaLengkap];
                        $nip         = $Nama[Nip];
                        $nama        = $Nama[Nama];
                        $SQL=mysql_query("SELECT id FROM presensi WHERE login='".$nama."' AND Tanggal='".$Tanggal."'");
                        if($row=mysql_num_rows($SQL) >0){
                            echo "<script type=\"text/javascript\">alert('Insert PRESENSI MANUAL Gagal'); window.location =\"presensi.manual.php\";</script>";
                        }else{
                           $sql="INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,Jamkeluar,abs,catatan) VALUES ('$nip','$nama','$Tanggal','$JamMasuk','$JamKeluar','5','$catatan')";
                            if($res=mysql_query($sql)){
                                echo "<script type=\"text/javascript\">alert('Insert PRESENSI MANUAL Sukses'); window.location =\"adm.manual.php\";</script>"; 
                             }else{
                                 echo "<script type=\"text/javascript\">alert('Insert PRESENSI MANUAL Gagal'); window.location =\"adm.manual.php\";</script>";
                             } 
                        }
                        
                    }                    
                }
                else
                    {                        
                        echo "<h1>Tambah Data Presensi Manuali $bag</h1>";
                        echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                        echo "<br />";
                        echo "<div>";
                        echo "<form method=\"post\" class=\"nice\">";
                        echo "<p class=\"left\">";
                        echo "<label><b>Nama Lengkap</b></label>";
                        /**
                        switch($bag){
                            case    "BAUK"  :
                                $gol=fetchDistinct("profile","where Fak='BAUK' AND bag='".$fakk."' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");
                                break;
                            case    "BAAKPSI"   :
                                $gol=fetchDistinct("profile","where Fak='BAAKPSI' AND bag='".$fakk."' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");
                                break;
                        
                            default         :
                                $gol=fetchDistinct("profile","where Fak='".$fakk."' AND Jabatan <> 'Mahasiswa' order by NamaLengkap");
                                break;
                        }***/
                        $gol=fetchDistinct("profile","where Jabatan <> 'Mahasiswa' order by NamaLengkap","Nama,NamaLengkap");
                        echo "<select name=\"Nama\" class=\"inputText\">";
                        echo "<option>- Pilih Pegawai -</option>\n";
                        foreach ($gol as $g){
                            echo "<option value =\"$g[Nama]\">$g[NamaLengkap]</option>\n";
                        }
                        echo "</select>";
                        echo "<label><b>Hari</b></label>";
                        echo "<input name=\"hari\" class=\"dateinput\" type=\"text\" />";
                        echo "<label><b>Jam Masuk</b></label>";
                        echo "<input name=\"JamMasuk\" class=\"inputText\" type=\"text\">";
                        echo "<label><b>Jam Keluar</b></label>";
                        echo "<input name=\"JamKeluar\" class=\"inputText\" type=\"text\">";
                        echo "</p>";
                        echo "<p class=\"right\">";
                        echo "<label><b>Alasan Presensi Manual</b></label><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"1\"/> <b>Jaringan / Presensi Error</b><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"2\" CHECKED/> <b>Lupa Presensi</b><br />";
                        echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Salah Klik Presensi Pulang</b><br />";
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
                    $Tanggal   =$_POST['Tanggal'];
                    $alasan    =$_POST['alasan'];
                    $JamMasuk  =$_POST['JamMasuk'];
                    $JamKeluar =$_POST['JamKeluar'];
                    $FotoMasuk =$_POST['FotoMasuk'];
                    $FotoKeluar=$_POST['FotoKeluar'];
                    if($alasan ==''){
                        echo "<script type=\"text/javascript\">alert('Edit Data PRESENSI MANUAL Gagal Alasan Tidak Boleh Kosong'); window.location =\"adm.manual.php\";</script>"; 
                    }else{
                        switch ($alasan){
                            case "5" :
                                $cat="Jaringan / Presensi Error";
                            break;
                            case "2" :
                                $cat="Lupa Presensi";
                            break;
                            case "8" :
                                $cat="Salah Klik Presensi Pulang";
                            break;
                            default :
                                $cat="Error System";
                            break;
                        }
                        $sql="UPDATE presensi SET Tanggal='".$Tanggal."',catatan='".$cat."',abs='5',JamMasuk='".$JamMasuk."',JamKeluar='".$JamKeluar."' WHERE id='".$id."'";
                        if($res=mysql_query($sql))
                        {
                            echo "<script type=\"text/javascript\">alert('Edit Data PRESENSI MANUAL Sukses'); window.location =\"adm.manual.php\";</script>"; 
                        }
                        else{
                            echo "<script type=\"text/javascript\">alert('Edit Data PRESENSI MANUAL Gagal'); window.location =\"adm.manual.php\";</script>";
                             }
                    }
                    
                }else{
                    if(isset($_POST['submitMov'])){
                        $Tanggal   =$_POST['Tanggal'];
                        $JamMasuk = $_POST['JamKeluar'];
                        $FotoMasuk= $_POST['FotoKeluar'];
                        $alasan    =$_POST['alasan'];
                        if($alasan ==''){
                            echo "<script type=\"text/javascript\">alert('Edit Data PRESENSI MANUAL Gagal Alasan Tidak Boleh Kosong'); window.location =\"adm.manual.php\";</script>"; 
                        }else{
                            switch ($alasan){
                                case "5" :
                                    $cat="Jaringan / Presensi Error";
                                break;
                                case "2" :
                                    $cat="Lupa Presensi";
                                break;
                                case "8" :
                                    $cat="Salah Klik Presensi Pulang";
                                break;
                                default :
                                    $cat="Error System";
                                break;
                            }
                            $sql="UPDATE presensi SET Tanggal='".$Tanggal."',catatan='".$cat."',abs='5',JamMasuk='".$JamMasuk."',JamKeluar=NULL,FotoMasuk='".$FotoMasuk."',FotoKeluar=NULL WHERE id='".$id."'";
                            if($res=mysql_query($sql))
                            {
                                echo "<script type=\"text/javascript\">alert('Edit Data PRESENSI MANUAL Sukses'); window.location =\"adm.manual.php\";</script>"; 
                            }
                            else{
                                echo "<script type=\"text/javascript\">alert('Edit Data PRESENSI MANUAL Gagal'); window.location =\"adm.manual.php\";</script>";
                                 }
                        }
                    }
                    $gol=fetch("profile,presensi","WHERE profile.Nama=presensi.login AND presensi.id='".$id."'");
                
                    echo "<h1>Edit Data PRESENSI MANUAL Atas Nama ".$gol[NamaLengkap]."</h1>";
                    echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                    echo "<br />";
                    echo "<div>";
                    echo "<form method=\"post\" class=\"nice\">";
                    echo "<p class=\"left\">";
                    echo "<label><b>Nama Lengkap</b></label>";
                    echo "<input name=\"Nama\" class=\"inputText\" disabled=\"disabled\" type=\"text\" value=\"".$gol[NamaLengkap]."\">";
                    echo "<label><b>Tanggal</b></label>";
                    echo "<input name=\"Tanggal\" class=\"dateinput\" type=\"text\" value=\"".$gol[Tanggal]."\">";
                    echo "<label><b>Jam Masuk</b></label>";
                    echo "<input name=\"JamMasuk\" class=\"inputText\" type=\"text\" value=\"".$gol[JamMasuk]."\">";
                    //echo "<label><b>Foto Masuk</b></label>";
                    //echo "<input name=\"FotoMasuk\" class=\"inputText\" type=\"text\" value=\"".$gol[FotoMasuk]."\">";
                    echo "<label><b>Jam Keluar</b></label>";
                    echo "<input name=\"JamKeluar\" class=\"inputText\" type=\"text\" value=\"".$gol[JamKeluar]."\">";
                    //echo "<label><b>Foto Keluar</b></label>";
                    //echo "<input name=\"FotoKeluar\" class=\"inputText\" type=\"text\" value=\"".$gol[FotoKeluar]."\">";
                    echo "</p>";
                    echo "<p class=\"right\">";
                    echo "<label><b>Alasan Presensi Manual</b></label><br />";            
                    //echo "<input name=\"Catatan\" class=\"inputText_wide\" type=\"text\" value=\"".$gol[catatan]."\" />";
                    echo "<input name=\"alasan\" type=\"radio\" value=\"1\"/> <b>Jaringan / Presensi Error</b><br />";
                    echo "<input name=\"alasan\" type=\"radio\" value=\"2\" CHECKED/> <b>Lupa Presensi</b><br />";
                    echo "<input name=\"alasan\" type=\"radio\" value=\"3\"/> <b>Salah Klik Presensi Pulang</b><br /><br />";
                    echo "*) Untuk Merubah Jam pada Kesalahan Klik silahkan Pilih checkbox <b>Salah Klik presensi Pulang</b> dan <b>Tombol pindah Jam</b> Kolom yang lain <b>Tidak Perlu Dirubah</b><br />";
                    echo "<br clear=\"all\" />";
                    echo "<button type=\"submit\" class=\"green\" name=\"submitEd\">Submit</button>\n";
                    echo "<button type=\"submit\" class=\"green\" name=\"submitMov\">Pindah Jam</button>\n";
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
                        echo "<script>alert('Hapus PRESENSI MANUAL Sukses'); window.location=\"adm.manual.php\"</script>";
                   }else{
                        echo "<script>alert('Hapus PRESENSI MANUAL Gagal'); window.location=\"adm.manual.php\"</script>";
                   }
                break;
            default         :
                $fakk=$_SESSION['userdata']['Fak'];
                $bag= $_SESSION['userdata']['ulname'];
                echo "<h1>Managemen PRESENSI MANUAL </h1>";
                //echo $fakk;
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."?cat=new\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Tambah Baru</a></div>";
                echo "<div>";
                if($_POST['Nama']){
                    $s_nama=$_POST['Nama'];
                    $s_tgl =$_POST['Tanggal'];
                    $i=1;
                    //print_r($_POST);
                    //$SQL=mysql_query("SELECT id,Tanggal,JamMasuk,JamKeluar FROM presensi WHERE login='".$s_nama."' AND Tanggal='".$s_tgl."'");
                    $row=fetchRow("presensi,profile","where profile.Nama=presensi.login and login='".$s_nama."' and Tanggal='".$s_tgl."'","profile.NamaLengkap,profile.Nip,presensi.id,presensi.JamMasuk,presensi.JamKeluar,presensi.Tanggal");
                    echo "</div>";
                    echo "<table id=\"data\" width=\"100%\">";
                    echo "<tr><th>No</th><th>Nama Lengkap</th><th>NIP</th><th>JamMasuk</th><th>Jam Keluar</th><th>Tanggal</th><th>Edit</th><th>Hapus</th></tr>";
                    foreach($row as $u){
                                echo "<tr><td>$i</td><td>$u[NamaLengkap]</td><td>$u[Nip]</td><td>$u[JamMasuk]</td><td>$u[JamKeluar]</td><td>$u[Tanggal]</td><td><a href='adm.manual.php?cat=edit&id=$u[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"presensi.manual.php?cat=del&id=$u[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
                            $i++;
                            }
                    echo "</table>";
                }else{
                    echo "<br />";
                    echo "<p class=\"info\"><b>Pembenahan Presensi dan Pembuatan Presensi Manual</b><br />Cari Berdasarkan Nama dan Tanggal untuk pembenahan<br />Pilih menu Tambah Baru untuk entri presensi manual</b></p>";
                    echo "<form method=\"post\" class=\"nice\">";
                    echo "<p class=\"left\">";
                    //echo "<label><b>Nama Lengkap</b></label>";
                    /**
                    switch($bag){
                        case    "BAUK"  :
                            $gol=fetchDistinct("profile","where Fak='BAUK' AND bag='".$fakk."' and Jabatan <> 'Mahasiswa' and Jabatan <> 'PKL' order by NamaLengkap");
                            break;
                        case    "BAAKPSI"   :
                            $gol=fetchDistinct("profile","where Fak='BAAKPSI' AND bag='".$fakk."' and Jabatan <> 'Mahasiswa' and Jabatan <> 'PKL' order by NamaLengkap");
                            break;
                        default         :
                            $gol=fetchDistinct("profile","where Fak='".$fakk."' and Jabatan <> 'Mahasiswa' and Jabatan <> 'PKL' order by NamaLengkap");
                            break;
                    }
                    **/
                        $gol=fetchDistinct("profile","where Jabatan <> 'Mahasiswa' and Jabatan <> 'PKL' order by NamaLengkap");
                        echo "<select name=\"Nama\" class=\"inputText\">";
                        echo "<option>- Pilih Pegawai -</option>\n";
                        foreach ($gol as $g){
                            echo "<option value =\"$g[Nama]\">$g[NamaLengkap]</option>\n";
                        }
                        echo "</select>";
                    echo "</p>";
                    echo "&nbsp;&nbsp;<input class=\"dateinput\" name=\"Tanggal\" type=\"text\" id=\"start\">";
                    echo "&nbsp;&nbsp;<button type=\"submit\" class=\"green\" name=\"cari\">cari</button>\n";
                    echo "<div class=\"clear\"></div>";
                    echo "</form>";
                    $max=30;
                    $i=1;
                    $listnav=new CnnNav($max,"presensi","where JamMasuk is NULL","*","id","9","5","3","&laquo;","&raquo;"," ", "");
                    $start=$_GET['offset']?$_GET['offset']*$max:0;
                    /**
                    switch($bag){
                        case    "BAUK"  :
                            $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.JamMasuk is NULL AND profile.Fak='BAUK' AND profile.bag='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                            break;
                        case    "BAAKPSI"   :
                            $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.JamMasuk is NULL AND profile.Fak='BAAKPSI' AND profile.bag='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                            break;
                        default         :
                            $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.JamMasuk is NULL AND profile.Fak='".$fakk."' order by presensi.Tanggal desc limit ".$start.",".$max."");
                            break;
                    }**/
                    $nUser=fetchRow("profile,presensi","where profile.Nama=presensi.login AND presensi.JamMasuk is NULL order by presensi.Tanggal desc limit ".$start.",".$max."");
                    echo "<br />";
                    if(!empty($nUser))
                        {
                            echo "<table id=\"data\" width=\"100%\">";
                            echo "<tr><th><b>No</b></th><th><b>Nama Lengkap</b></th><th><b>NIP</b></th><th><b>JamMasuk</b></th><th><b>Jam Keluar</b></th><th><b>Tanggal</b></th><th><b>Edit</b></th></tr>";
                            foreach($nUser as $u){
                                echo "<tr><td>$i</td><td>$u[NamaLengkap]</td><td>$u[Nip]</td><td>$u[JamMasuk]</td><td>$u[JamKeluar]</td><td>$u[Tanggal]</td><td><a href='adm.manual.php?cat=edit&id=$u[id]'><img src='images/icon_calendar.gif'></a></td></tr>";
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
                            echo "Data PRESENSI MANUAL Tidak Ada (Masih Kosong)";
                            echo "</b></p></div>";
                        }  
                }
                                
            break;
        }
    ?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>