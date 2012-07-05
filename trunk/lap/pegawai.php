<?php
define("ACCESS","daftar_pegawai");
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
            $fakk=$_SESSION['userdata']['Fak'];
	    $bag=$_SESSION['userdata']['ulname'];
            $Nip=$_POST['Nip'];
            $Nama=$fakk.$_POST['Nama'];
            $NamaLengkap=$_POST['NamaLengkap'];
            $pass=$_POST['pass'];
            $Jab=$_POST['Jab'];
            $Jur=$_POST['Jur'];
            $Gol=$_POST['Gol'];
            if (!$user=numRow("profile","where Nama='$Nama'")>0){
                if(!$Pass=numRow("profile","where pass='$pass'")){
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
                    echo "<p class=\"error\">Maaf Password Sudah Digunakan Silahkan ganti dengan Password yg lain</p>";
                }
            }else{
                echo "<p class=\"error\">Maaf User Sudah Digunakan Silahkan ganti dengan User yg lain</p>";
			
            } 
            
        }else{
            $fakk=$_SESSION['userdata']['Fak'];
            echo $fakk;
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
            echo "<label><b>Jabatan</b></label>";
            echo "<select name=\"Jab\" class=\"inputText\">";
            echo "<option>- Pilih Jabatan -</option>\n";
            echo "<option value =\"Dosen\">Dosen</option>\n";
            echo "<option value =\"Karyawan\">Karyawan</option>\n";
	    if($fakk == 'FT'){
		echo "<option value =\"Mahasiswa\">Mahasiswa</option>\n";
	    }
            echo "</select>";
            echo "<label><b>Bagian / Jurusan</b></label>";
            $jur=fetchRow("adm_jurusan","where Fakultas='$fakk'","JurId,JurDet");
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
		//print_r($_POST);
		$sql="INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,Jamkeluar,abs) VALUES ('$Nip','$Nama','1010-01-10','00:00:00','00:00:00','1') ";
		if($res=mysql_query($sql)){
		   echo $Nama;
		   echo "<script type=\"text/javascript\">alert('Insert Dummie Sukses'); window.location =\"pegawai.php\";</script>"; 
		}else{
		    echo "<script type=\"text/javascript\">alert('Gagal'); window.location =\"pegawai.php\";</script>";
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
		$Status=$_POST['Status'];
		$sort=$_POST['sort'];
                $cPass=fetch("profile","where id='$id'");
                if(!$jml=numRow("profile","where pass='$pass'")>0){
                    $sql2="UPDATE profile SET Nip='$Nip',NamaLengkap='$NamaLengkap',pass='$pass',Jabatan='$Jab',Jurusan='$Jur',Gol='$Gol',status='$Status',sort='$sort' WHERE id='$id'";
                    if($res2=mysql_query($sql2)){
                        echo "<script type=\"text/javascript\">alert('Sukses'); window.location =\"pegawai.php\";</script>";
                    }else {
                        echo "<script>alert('Gagal'); window.location=\"pegawai.php\"</script>";
                    }
                }else {
                    if($pass==$cPass[pass]){
                        $sql3="UPDATE profile SET Nip='$Nip',NamaLengkap='$NamaLengkap',pass='$pass',Jabatan='$Jab',Jurusan='$Jur',Gol='$Gol',status='$Status',sort='$sort' WHERE id='$id'";
                        if($res3=mysql_query($sql3)){
                            echo "<script>alert('Sukses'); window.location=\"pegawai.php\"</script>";
                        }else{
                            echo "<script>alert('Gagal'); window.location=\"pegawai.php\"</script>";
                        }
                    }else{
			   echo "<script>alert('Password telah Digunakan Silahkan Ganti dengan Password yang lain'); window.location=\"pegawai.php\"</script>";

                    }
                }
            }else{
                $Usr=fetch("profile","where id='$id'");
                echo "<h1>Edit Data Pegawai</h1>";
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/backs.png\" alt=\"Back\" border=\"0\" />&nbsp;Back</a></div>";
                echo "<br />";
                echo "<div>";
                echo "<form method=\"post\" class=\"nice\">";
                echo "<p class=\"left\">";
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
                $jur=fetchRow("adm_jurusan","where Fakultas='$fakk'","JurId,JurDet");
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
		echo "<label><b>No Urut</b></label>";
                echo "<input name=\"sort\" class=\"inputText\" type=\"text\" value=\"$Usr[sort]\"/>";
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
	if($_SESSION['userdata']['ugroup']=='3'){
		echo "<script>alert('Maaf Anda Tidak diijinkan Menghapus profile'); window.location=\"pegawai.php\"</script>";
	}else{

		$id=abs((int)$_GET['id']);
		$sql="DELETE FROM profile WHERE id='$id'";
		if($res=mysql_query($sql)){
	     		echo "<script>alert('Hapus profile Sukses'); window.location=\"pegawai.php\"</script>";
		}else{
	     		echo "<script>alert('Hapus profile Gagal'); window.location=\"pegawai.php\"</script>";
		}
	}
	break;
    default     :
	$fakk=$_SESSION['userdata']['Fak'];
        echo "<h1>Managemen Pegawai </h1>";
	echo $fakk;
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
        
	
	$bag= $_SESSION['userdata']['ulname'];
        $max=30;
        $i=1;
	$listnav=new CnnNav($max,"profile","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
	$start=$_GET['offset']?$_GET['offset']*$max:0;
	switch($bag){
	    case "BUPK"	:
		$nUser=fetchRow("profile","where Fak='BUPK' AND bag='$fakk' order by Gol desc limit ".$start.",".$max."");
		break;
	    case "BAKI" :
		$nUser=fetchRow("profile","where Fak='BAKI' AND bag='$fakk' order by Gol desc limit ".$start.",".$max."");
		break;
	    case "WATES" :
		$nUser=fetchRow("profile","where bag='WATES' order by Gol desc limit ".$start.",".$max."");
		break;
	    default	:
		$nUser=fetchRow("profile","where Fak='$fakk' order by Gol desc limit ".$start.",".$max."");
		break;
	}
        if(isset($_POST['search'])){
            $cari=$_POST['cari'];
            switch($bag){
		case "BUPK"	:
		    $sql=fetchRow("profile","where Fak='BUPK' AND bag='$fakk' AND NamaLengkap like '%$cari%'");
		    break;
		case "BAKI"	:
		    $sql=fetchRow("profile","where Fak='BAKI' AND bag='$fakk' AND NamaLengkap like '%$cari%'");
		    break;
		case "WATES"	:
		    $sql=fetchRow("profile","where Fak='WATES' AND NamaLengkap like '%$cari%'");
		    break;
		default		:
		    $sql=fetchRow("profile","where Fak='$fakk' AND NamaLengkap like '%$cari%'");
		    break;
	    }
            if(numRow("profile","where NamaLengkap like '%$cari%'")>0){
            echo "<div>";
            echo "<table id=\"data\">";
            echo "<tr><th>No</th><th>Nama Lengkap</th><th>Nip</th><th>Jabatan</th><th>Bag / Jurusan</th><th>Last Login</th><th>Edit</th><th>Hapus</th></tr>";
                foreach($sql as $se){
                    echo "<tr><td>$i</td><td>$se[NamaLengkap]</td><td>$se[Nip]</td><td>$se[Jabatan]</td><td>$se[Jurusan]</td><td>$se[lastlogin]</td><td><a href='pegawai.php?cat=edit&id=$se[id]'><img src='images/icon_calendar.gif'></a></td><td><a href='pegawai.php?cat=del&id=$se[id]'><img src='images/icon_delete.gif'></a></td></tr>";
                    $i++;
                }
            echo "</table>";
            echo "</div>";
            }else{
                echo "<div><h1>Data Tidak Ada</h1></div>";
            }
            
        }else{
        echo "<div>";
        echo "<table width=\"100%\" id=\"data\">";
        echo "<tr><th>No</th><th>Nama Lengkap</th><th>Nip</th><th>Jabatan</th><th>Bag / Jurusan</th><th>Edit</th><th>Hapus</th></tr>";
        foreach($nUser as $u){
            echo "<tr><td>$i</td><td>$u[NamaLengkap]</td><td>$u[Nip]</td><td>$u[Jabatan]</td><td>$u[Jurusan]</td><td><a href='pegawai.php?cat=edit&id=$u[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"pegawai.php?cat=del&id=$u[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
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