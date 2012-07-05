<?php
define("ACCESS","adm_profile");
require_once("adm.db.php");
require		("adm.init.php");
include		("adm.header.php");
?>
<div class="grid_9 cnt" id="left">
	<div id="ipsum">
		<div></div>
		<h1>Profile Admin Presensi</h1>
		<?php
		if(isset($_POST['submit'])){
			$oldpass=$_POST['opass'];
			$newpass=$_POST['npass'];
			$rptpass=$_POST['rpass'];
			$enpass=md5($newpass);
			if($oldpass !== '' && $newpass !=='' && $rptpass !==''){
				if($oldpass == $_SESSION['userdata']['upassn']){
					if($rptpass == $newpass){
						if(strlen($newpass) >5){
							$sql=mysql_query("UPDATE adm_user SET upassn='".$newpass."',upass='".$enpass."' WHERE uname='".$_SESSION['userdata']['uname']."'");
							if($sql){
								echo "<script type=\"text/javascript\">alert('Sukses'); window.location =\"adm.profile.php\";</script>";
							}else{
								echo "<script type=\"text/javascript\">alert('gagal'); window.location =\"adm.profile.php\";</script>";
							}
						}else{
							echo "<script type=\"text/javascript\">alert('Password yang dijinkan minimal 5 karakter'); window.location =\"adm.profile.php\";</script>"; 
						}
					}else{
						echo "<script type=\"text/javascript\">alert('Password baru tidak sama SIlahkan ulangi'); window.location =\"adm.profile.php\";</script>"; 
					}
				}else{
					echo "<script type=\"text/javascript\">alert('Password lama tidak sesuai'); window.location =\"adm.profile.php\";</script>"; 
				}
			}else{
				echo "<script type=\"text/javascript\">alert('Mohon diisi seluruhnya'); window.location =\"adm.profile.php\";</script>"; 
			}
			
		}else{
			echo "<form method=\"post\" class=\"nice\">";
			echo "<p class=\"left\">";
			echo "<label>Nama</label>";
			echo "<input type=\"text\" class=\"inputText\" name=\"nama\" value=\"".$_SESSION['userdata']['ufname']." ".$_SESSION['userdata']['ulname']."\" DISABLED>";
			echo "<label>User</label>";
			echo "<input type=\"text\" class=\"inputText\" name=\"user\" value=\"".$_SESSION['userdata']['uname']."\" DISABLED>";
			echo "<label>Password Lama</label>";
			echo "<input type=\"password\" class=\"inputText\" name=\"opass\">";
			echo "</p>";
			echo "<p class=\"right\">";
			echo "<label>Password Baru</label>";
			echo "<input type=\"password\" class=\"inputText\" name=\"npass\">";
			echo "<label>Ulangi</label>";
			echo "<input type=\"password\" class=\"inputText\" name=\"rpass\">";
			echo "<br clear=\"all\" />";
            echo "<br clear=\"all\" />";
            echo "<button type=\"submit\" class=\"green\" name=\"submit\">Simpan</button>\n";
			echo "</p>";
			echo "<div class=\"clear\"></div>";
			echo "</form>";
		}
	//print_r($_SESSION['userdata']);
	// "<br />";
	//echo $_SESSION['userdata']['uname'];
		?>
		
	</div>
</div>
<?php
include		("adm.menu.php");
include		("adm.footer.php");
?>