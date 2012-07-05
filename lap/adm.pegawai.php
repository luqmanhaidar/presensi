<?php
define("ACCESS","adm_pegawai");
require("adm.db.php");
require("adm.init.php");
include("adm.header.php");
include ("cnn/CnnNav.php");
?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
<?php
switch ($_GET['cat']){
    case "new"  :
        if(isset($_POST['SubmitAd'])){
            //print_r($_POST);
            $fakk=$_POST['Fakk'];
            $Nip=$_POST['Nip'];
            $Nama=$fakk.$_POST['Nama'];
            $NamaLengkap=$_POST['NamaLengkap'];
            $pass=$_POST['pass'];
            $Jab=$_POST['Jab'];
            $Jur=$_POST['Jur'];
            $Gol=$_POST['Gol'];
	    if($Nip !== "" && $Nama !== "" && $NamaLengkap !== "" && $Jab !== "" && $Jur !== "" && $Gol !== "")
	    {
		if (!$user=numRow("profile","where Nama='$Nama'")>0){
		    if(!$Pass=numRow("profile","where pass='$pass'")){
			if(!$pass == ''){
			    if(strlen($pass)>5){
			    $sql="INSERT INTO profile (Nip,Nama,NamaLengkap,pass,Jabatan,Fak,Jurusan,Gol,lastlogin) VALUES ('$Nip','$Nama','$NamaLengkap','$pass','$Jab','$fakk','$Jur','$Gol','0000-00-00 00:00:00')";
				if($res=mysql_query($sql)){
				    $sql1="INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,Jamkeluar,abs) VALUES ('$Nip','$Nama','1010-01-10','00:00:00','00:00:01','1')";
				    if($res1=mysql_query($sql1)){
					echo "<p class=\"info\">Data Berhasil Disimpan</p>";
				    }else {
					echo "<p class=\"error\">Data Gagal Disimpan</p>";
				    }
				    
				}else{
				    echo "<p class=\"error\">Data Gagal Disimpan</p>";
				}
			    }else{
				echo "<p class=\"error\">Password minimal 5 karakter</p>";
			    }
			}else{
				echo "<p class=\"error\">Password minimal Tidak Boleh Kosong</p>";
			    }
			
		    }else{
			echo "<p class=\"error\">Maaf Password Sudah Digunakan Silahkan ganti dengan Password yg lain</p>";
		    }
		}else{
		    echo "<p class=\"error\">Maaf User Sudah Digunakan Silahkan ganti dengan User yg lain</p>";	    
		} 
	    }else{
		    echo "<p class=\"error\">Data Tidak Bolah Kosong</p>";	    
		}
    
            
        }else{
            //$fakk=$_SESSION['userdata']['Fak'];
            //echo $fakk;
            echo "<h1>Tambah Pegawai Baru</h1>";
             echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                echo "<br />";
            echo "<div>";
            echo "<form method=\"post\" class=\"nice\">";
            echo "<p class=\"left\">";
            echo "<label><b>NIP /ID</b></label>";
            echo "<input name=\"Nip\" class=\"inputText\" type=\"text\" />";
            echo "<label><b>User</b></label>";
            echo "<input name=\"Nama\" class=\"inputText\" type=\"text\" />";
            echo "<label><b>Nama Lengkap</b></label>";
            echo "<input name=\"NamaLengkap\" class=\"inputText\" type=\"text\" />";
            echo "<label><b>Password</b></label>";
            echo "<input name=\"pass\" class=\"inputText\" type=\"text\" />";
            echo "</p>";
            echo "<p class=\"right\">";
	    echo "<label><b>Unit Kerja / Fakultas</b></label>";
	    $gol=fetchDistinct("profile","","Fak");
            echo "<select name=\"Fakk\" class=\"inputText\">";
            echo "<option>- Pilih Bagian / Fak -</option>\n";
            foreach ($gol as $g){
                echo "<option value =\"$g[Fak]\">$g[Fak]</option>\n";
            }
            echo "</select>";
            echo "<label><b>Jabatan</b></label>";
            echo "<select name=\"Jab\" class=\"inputText\">";
            echo "<option>- Pilih Jabatan -</option>\n";
            echo "<option value =\"Dosen\">Dosen</option>\n";
            echo "<option value =\"Karyawan\">Karyawan</option>\n";
            echo "</select>";
            echo "<label><b>Bagian / Jurusan</b></label>";
            $jur=fetchDistinct("adm_jurusan","","JurId,JurDet");
            echo "<select name=\"Jur\" class=\"inputText\">";
            echo "<option>- Pilih Bagian / Jurusan -</option>\n";
            foreach ($jur as $j){
               echo "<option value =\"$j[JurId]\">$j[JurDet]</option>\n";
            }
            echo "</select>";
            echo "<label><b>Pangkat / Gol</b></label>";
            $gol=fetchRow("adm_gol");
            echo "<select name=\"Gol\" class=\"inputText\">";
            echo "<option>- Pilih Pangkat / Gol -</option>\n";
            foreach ($gol as $g){
                echo "<option value =\"$g[Gol]\">$g[Pangkat]</option>\n";
            }
            echo "</select>";
            echo "<br clear=\"all\" />";
            echo "<br clear=\"all\" />";
            echo "<button type=\"submit\" class=\"green\" name=\"SubmitAd\">Simpan</button>\n";
            echo "</p>";
            echo "<div class=\"clear\"></div>";
            echo "</form>";
            echo "</div>";
        }
        break;
    case "edit" :
        $id=abs((int)$_GET['id']);
        $fakk=$_SESSION['userdata']['Fak'];
	    if(isset($_POST['InsertDm'])){
		$Nip=$_POST['Nip'];
		$Nama=$_POST['Nama'];
		$sql="INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,Jamkeluar,abs) VALUES ('$Nip','$Nama','1010-01-10','00:00:00','00:00:00','1') ";
		if($res=mysql_query($sql)){
		   echo "<script type=\"text/javascript\">alert('Insert Dummie Sukses'); window.location =\"adm.pegawai.php\";</script>"; 
		}else{
		    echo "<script type=\"text/javascript\">alert('Gagal'); window.location =\"adm.pegawai.php\";</script>";
		}
	    }
            if (isset($_POST['SubmitEd'])){
                $Nip=$_POST['Nip'];
                $Nama=$_POST['Nama'];
                $NamaLengkap=$_POST['NamaLengkap'];
                $pass=$_POST['pass'];
                $Jab=$_POST['Jab'];
                $Jur=$_POST['Jur'];
                $Gol=$_POST['Gol'];
		$Fakk=$_POST['Fakk'];
		$Status=$_POST['Status'];
                $cPass=fetch("profile","where id='$id'");
		if($Nip !== "" && $Nama !== "" && $NamaLengkap !== "" && $Jab !== "" && $Jur !== "" && $Gol !== "" && $Fakk !== "" && $Status !== "" && $pass !== "")
                {
		    if(!$jml=numRow("profile","where pass='$pass'")>0){
			$sql2="UPDATE profile SET Nip='$Nip',NamaLengkap='$NamaLengkap',pass='$pass',Jabatan='$Jab',Fak='$Fakk',Jurusan='$Jur',Gol='$Gol',status='$Status' WHERE id='$id'";
			if($res2=mysql_query($sql2)){
			    echo "<script type=\"text/javascript\">alert('Sukses'); window.location =\"adm.pegawai.php\";</script>";
			}else {
			    echo "<script>alert('Gagal'); window.location=\"adm.pegawai.php\"</script>";
			}
		    }else {
			if($pass==$cPass[pass]){
			    $sql3="UPDATE profile SET Nip='$Nip',NamaLengkap='$NamaLengkap',pass='$pass',Jabatan='$Jab',Fak='$Fakk', Jurusan='$Jur',Gol='$Gol',status='$Status' WHERE id='$id'";
			    if($res3=mysql_query($sql3)){
				echo "<script>alert('Sukses'); window.location=\"adm.pegawai.php\"</script>";
			    }else{
				echo "<script>alert('Gagal'); window.location=\"adm.pegawai.php\"</script>";
			    }
			}else{
			       echo "<script>alert('Password telah Digunakan Silahkan Ganti dengan Password yang lain'); window.location=\"adm.pegawai.php\"</script>";
    
			}
		    }
		}else{
			echo "<script>alert('Data Tidak Bolah Kosong'); window.location=\"adm.pegawai.php\"</script>";
    
		    }
            }else{
                $Usr=fetch("profile","where id='$id'");
                echo "<h1>Edit Data Pegawai</h1>";
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                echo "<br />";
                echo "<div>";
                echo "<form method=\"post\" class=\"nice\">";
                echo "<p class=\"left\">";
		//$pic=fetch("presensi","where login='".$Usr['Nama']."' AND FotoMasuk is NOT NULL order by Tanggal DESC LIMIT 1","FotoMasuk");
		//echo "<a href=\"../".$pic['FotoMasuk']."\">".$pic['FotoMasuk']."</a>";
		//echo "<label><b>Foto</b></label>";
		//echo "<img src='../".$pic['FotoMasuk']."' width='95'>";
                echo "<label><b>NIP</b></label>";
                echo "<input name=\"Nip\" class=\"inputText\" type=\"text\" value=\"$Usr[Nip]\"/>";
                echo "<label><b>User</b></label>";
                echo "<input name=\"Nama_\" class=\"inputText\" type=\"text\" value=\"$Usr[Nama]\" disabled/>";
		echo "<input name=\"Nama\" type=\"hidden\" value=\"$Usr[Nama]\">";
                echo "<label><b>Nama Lengkap</b></label>";
                echo "<input name=\"NamaLengkap\" class=\"inputText\" type=\"text\" value=\"$Usr[NamaLengkap]\" />";
                echo "<label><b>Password</b></label>";
                echo "<input name=\"pass\" class=\"inputText\" type=\"text\" value=\"$Usr[pass]\"/>";
                echo "</p>";
                echo "<p class=\"right\">";
		echo "<label><b>Unit Kerja / Fakultas</b></label>";
                $jur=fetchDistinct("profile","","Fak");
                echo "<select name=\"Fakk\" class=\"inputText\">";
                foreach ($jur as $j){
                    if ($Usr[Fak]==$j[Fak]){
                        echo "<option value =\"$j[Fak]\" SELECTED>$j[Fak]</option>\n";
                    }else{
                        echo "<option value =\"$j[Fak]\">$j[Fak]</option>\n";
                    } 
                }
                echo "</select>";
                echo "<label><b>Jabatan</b></label>";
                echo "<select name=\"Jab\" class=\"inputText\">";
                if ($Usr[Jabatan]=='Dosen'){
                    echo "<option value =\"Dosen\" selected>Dosen</option>\n";
                    echo "<option value =\"Karyawan\">Karyawan</option>\n";
                }else {
                    echo "<option value =\"Karyawan\" selected>Karyawan</option>\n";
                    echo "<option value =\"Dosen\">Dosen</option>\n";
                }
                echo "</select>";
                echo "<label><b>Bagian / Jurusan</b></label>";
                $jur=fetchDistinct("adm_jurusan","","JurId,JurDet");
                echo "<select name=\"Jur\" class=\"inputText\">";
                foreach ($jur as $j){
                    if ($Usr[Jurusan]==$j[JurId]){
                        echo "<option value =\"$j[JurId]\" SELECTED>$j[JurDet]</option>\n";
                    }else{
                        echo "<option value =\"$j[JurId]\">$j[JurDet]</option>\n";
                    } 
                }
                echo "</select>";
                echo "<label><b>Pangkat / Gol</b></label>";
                $gol=fetchRow("adm_gol");
                echo "<select name=\"Gol\" class=\"inputText\">";
                foreach ($gol as $g){
                    if($Usr[Gol]==$g[Gol]){
                        echo "<option value =\"$g[Gol]\" SELECTED>$g[Pangkat]</option>\n";
                    }
                    else {
                        echo "<option value =\"$g[Gol]\">$g[Pangkat]</option>\n";
                    }
                }
                echo "</select>";
		echo "<label><b>Status</b></label>";
               // $gol=fetchRow("status");
                echo "<select name=\"Status\" class=\"inputText\">";
               // foreach ($gol as $g){
                    if($Usr[status]=="1"){
                        echo "<option value =\"1\" SELECTED>Aktif</option>\n";
			echo "<option value =\"2\" >Non Aktif</option>\n";
                    }
                    else {
                        echo "<option value =\"2\">Non Aktif</option>\n";
			echo "<option value =\"1\">Aktif</option>\n";
                    }
                //}
                echo "</select>";
                echo "<br clear=\"all\" />";
                echo "<br clear=\"all\" />";
                echo "<button type=\"submit\" class=\"green\" name=\"SubmitEd\">Simpan</button>\n";
		echo "<button type=\"submit\" class=\"green\" name=\"InsertDm\">Insert Dummie</button>\n";
                echo "</p>";
                echo "<div class=\"clear\"></div>";
                echo "</form>";
                echo "</div>";
            }
        break;
    case "del"	:
	$id=abs((int)$_GET['id']);
	$sql="DELETE FROM profile WHERE id='$id'";
	if($res=mysql_query($sql)){
	     echo "<script>alert('Hapus profile Sukses'); window.location=\"adm.pegawai.php\"</script>";
	}else{
	     echo "<script>alert('Hapus profile Gagal'); window.location=\"adm.pegawai.php\"</script>";
	}
	break;
    default     :
        echo "<h1>Managemen Pegawai </h1>";
        echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."?cat=new\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Tambah Baru</a></div>";
        //echo "<br />";
        echo "<div>";
        echo "<form method=\"post\" class=\"nice\">";
        echo "<p class=\"left\">";
        echo "<label><b>Search</b></label>";
        echo "<input name=\"cari\" class=\"inputText\" type=\"text\" />";
        echo "</p>";
        echo "<p class=\"right\">";
       // echo "<label><b>Search</b></label>";
        echo "<br clear=\"all\" />";
        echo "<button type=\"submit\" class=\"green\" name=\"search\">Search</button>\n";
        echo "</p>";
        echo "<div class=\"clear\"></div>";
        echo "</form>";
        echo "</div>";
        //$fakk=$_SESSION['userdata']['Fak'];
        $max=30;
        $i=1;
	$listnav=new CnnNav($max,"profile","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
	$start=$_GET['offset']?$_GET['offset']*$max:0;
        $nUser=fetchRow("profile","order by Gol desc limit ".$start.",".$max."");
        if(isset($_POST['search'])){
            $cari=$_POST['cari'];
            $sql=fetchRow("profile","where NamaLengkap like '%$cari%'");
            
            if(numRow("profile","where NamaLengkap like '%$cari%'")>0){
            echo "<div>";
            echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id=\"data\">";
            echo "<tr><th>No</th><th>Nama Lengkap</th><th>Nip</th><th>Jabatan</th><th>Bag / Jurusan</th><th>Last Login</th><th>Edit</th><th>Hapus</th></tr>";
                foreach($sql as $se){
                    echo "<tr><td>$i</td><td>$se[NamaLengkap]</td><td>$se[Nip]</td><td>$se[Jabatan]</td><td>$se[Jurusan]</td><td>$se[lastlogin]</td><td><a href='adm.pegawai.php?cat=edit&id=$se[id]'><img src='images/icon_calendar.gif'></a></td><td><a href='adm.pegawai.php?cat=del&id=$se[id]'><img src='images/icon_delete.gif'></a></td></tr>";
                    $i++;
                }
            echo "</table>";
            echo "</div>";
            }else{
                echo "<div><h1>Data Tidak Ada</h1></div>";
            }
            
        }else{
        echo "<div>";
        echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id=\"data\">";
        echo "<tr><th>No</th><th>Nama Lengkap</th><th>Nip</th><th>Jabatan</th><th>Bag / Jurusan</th><th>Edit</th><th>Hapus</th></tr>";
        foreach($nUser as $u){
            echo "<tr><td>$i</td><td>$u[NamaLengkap]</td><td>$u[Nip]</td><td>$u[Jabatan]</td><td>$u[Jurusan]</td><td><a href='adm.pegawai.php?cat=edit&id=$u[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"adm.pegawai.php?cat=del&id=$u[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
        $i++;
        }
        echo "</table>";
        echo "</p>";
        echo "</div>";
        echo "<div>";
        echo "<p class= \"info\"><b>";
        $listnav->printnav();
        echo "</b></p></div>";
        }       
        break;
}
?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>