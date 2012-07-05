<?php
session_start();
include("koneksi.php");
if(isset($_POST['nama'])){
	if($_POST['nama']!="" && $_POST['sandi']!=""){
		$_sql="select * from profile where Nip='".mysql_real_escape_string($_POST['nama'])."' AND pass='".mysql_real_escape_string($_POST['sandi'])."'";
		$user=mysql_query($_sql) or die($_lang['err_db_syntax']);
		if(mysql_num_rows($user)>0){
			$user=mysql_fetch_assoc($user);
			$_SESSION['isLogged']=TRUE;
			$_SESSION['uName']=$user['Nama'];
			$_SESSION['uPass']=$user['pass'];
			$_SESSION['userdata']=$user;
                        putenv("TZ=Asia/Jakarta");
			$date = date('Y-m-d H:i:s');
			$SQL=mysql_query("UPDATE profile SET lastlogin='$date' WHERE id='".$user['id']."'");
			header("Location: riwayat.php");
		}else{
			$error="<p class=\"error\">User / Pass Anda SALAH!</p>";
		}
	}else{
		$error="<p class=\"error\">Mohon isi seluruh field</p>";
	}
}else{
	$error="<p class=\"error\">Silahkan Masukkan NIP/ID dan Password Anda</p>";	
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login | Presensi Online | Riwayat Presensi</title>
<link href="lap/css/login.css" rel="stylesheet" type="text/css">
</head><body>
<div id="container">
	<img src="lap/images/logo_login.gif" alt="Sleek Admin" width="300" border="0" height="93">
    <div class="login_form">
    <?php echo $error ;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off" method="post" runat="server">
        <label>Nip / ID</label>
        <input class="inputText" name="nama" type="text">
        <label>Password</label>
        <input class="inputText" name="sandi" type="password">
        <br clear="all">
        <button type="submit" class="green" name="submit">Log in</button>
    </form></div>
</div>
</body></html>