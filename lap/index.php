<?php
define("ACCESS","indexs");
require("adm.db.php");
include("cnn/CnnFormH.php");
include("cnn/CnnFormV.php");
if(isset($_POST['nama'])){
	if($_POST['nama']!="" && $_POST['sandi']!=""){
		$_sql="select * from adm_user where uname='".mysql_real_escape_string($_POST['nama'])."' AND upass=md5('".$_POST['sandi']."');";
		$user=mysql_query($_sql) or die($_lang['err_db_syntax']);
		if(mysql_num_rows($user)>0){
			$user=mysql_fetch_assoc($user);
			$_SESSION['isLogged']=TRUE;
			$_SESSION['uname']=$user['uname'];
			$_SESSION['upass']=$user['upass'];
			$_SESSION['userdata']=$user;
			putenv("TZ=Asia/Jakarta");
			$date = date('Y-m-d H:i:s');
			$SQL=mysql_query("UPDATE adm_user SET ulastlogin='$date' WHERE uid='".$user['uid']."'");
			header("Location: adm.home.php");
		}else{
			$error="<p class=\"error\">User / Pass Anda SALAH!</p>";
		}
	}else{
		echo "b";
	}
}else{
	echo "c";	
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login | Presensi Online Admin</title>
<link href="css/login.css" rel="stylesheet" type="text/css">
</head><body>
<div id="container">
	<img src="images/logo_login.gif" alt="Sleek Admin" width="300" border="0" height="93">
    <div class="login_form">
    <h1>Restricted Area</h1>
    <?php echo $error ;?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <label>Username</label>
        <input class="inputText" name="nama" type="text">
        <label>Password</label>
        <input class="inputText" name="sandi" type="password">
        <br clear="all">
        <button type="submit" class="green" name="submit">Log in</button>
      
    </form></div>
</div>
</body></html>