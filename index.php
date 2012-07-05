<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sistem Presensi Wajah Universitas Negeri Yogyakarta</title>
	<meta name="author" content="Dwi Agus">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="lap/css/thickbox.css" type="text/css" media="screen" />
	<script language="javascript" type="text/javascript" src="lap/js/jquery.js"></script>
	<script type="text/javascript" src="lap/js/thickbox.js"></script>
	<script type="text/javascript">
		var serverTime = new Date(<?php date_default_timezone_set('Asia/Jakarta'); print date('Y, m, d, H, i, s, 0'); ?>);
		var clientTime = new Date();
		var D = serverTime.getTime() - clientTime.getTime();
		
		function loadTime(){
			var clientTime = new Date();
			var time = new Date(clientTime.getTime() + D);
			var sh = time.getHours() + "";
			var sm = time.getMinutes() + "";
			var ss = time.getSeconds() + "";
			document.getElementById("clock").innerHTML = "<h1><a href=\"#\">"+(sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss)+"</a></h1>";
		}
		
		function recalibrate(){
			$.get('time2.php', function(data){
				eval(data);
				console.log(st);
				clientTime = new Date();
				D = st.getTime() - clientTime.getTime();
			});
		}
	</script>
	<body onload="setInterval('loadTime()', 1000); setInterval('recalibrate()', 3600000);">
    <div id="container">
	<p align="center"><img src="images/uny.png" />&nbsp;&nbsp;<a href="index.php"><img src="images/logo.png" /></a></p>
    <div id="foto">
    <table><tr><td valign=top>
    <div id="fframe">
    <p align="center">
	<script type="text/javascript" src="webcam.js"></script>
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'presensi.php' );
		webcam.set_quality( 50 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(460, 345, 95, 71) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form id="form" name="form">
		<p class="submit"><input type='password' class="search" size='22' name='identitas' id='identitas' value='' autocomplete="off" runat="server">&nbsp;<select id="type" class="sbox"><option value="datang">Datang</option><option value="pulang">Pulang</option></select>
		<input type=button class="button" value="Klik" onClick="take_snapshot();"></p>
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {
			document.getElementById('response').innerHTML = '<h3>Sedang Proses Silahkan tunggu ...</h3>';
			var identitas = document.getElementById('identitas').value;
			var types = document.getElementById('type').value;
			webcam.snap('presensi.php?i='+identitas+'&type='+types);
		}
		function my_completion_handler(msg) {
			document.getElementById('response').innerHTML ='<b>Info:</b> '+msg; 
			webcam.reset();
			document.form.reset();
		}
	</script>
    </p>
    </div>
    </td><td valign=top>
	<p class="info" align="center"><span id="clock"></span></p>
       <p class="info" align="center"><b><a href="petunjuk.html?height=500&width=800" title="Petunjuk Penggunaan" class="thickbox">PETUNJUK PENGGUNAAN</a></b></p>
	<p class="info" align="center"><b><a href="login.php" title="Login Riwayat Presensi">RIWAYAT PRESENSI</a></b></p>
	<p class="info" align="center"><b><a href="change.html" title="Ganti Password">GANTI PASSWORD</a></b></p>
	<p class="info" align="center"><b><a href="satpam.php" title="Presensi Satpam">PRESENSI SATPAM /JAGA MALAM</a></b></p>
		<div id="response"><p align="center"><b class="blinking">Info:<br />SILAHKAN UBAH SETTING WEB BROWSER ANDA SESUAI <a href="http://puskom.uny.ac.id/2010/01/28/perubahan-setting-proxy-uny">PETUNJUK INI.</a><br /></b></p></div>
	</td></tr></table>
    </div>
    </div>
</body>
</html>
