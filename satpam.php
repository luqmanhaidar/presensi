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
</head>
<body>
    <div id="container">
	<p align="center"><img src="images/uny.png" />&nbsp;&nbsp;<a href="index.php"><img src="images/logo.png" /></a></p>
    <div id="foto">
    <table><tr><td valign=top>
    <div id="fframe">
    <p align="center">
	<script type="text/javascript" src="webcam.js"></script>
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'security.php' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(460, 345) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form id="form" name="form">
		<p class="submit"><input type='password' class="security" size='22' name='identitas' id='identitas' value='' autocomplete="off" runat="server">
                &nbsp;<select id="Shift" class="sbox"><option value="shift1">Shift 1</option><option value="shift2">Shift 2</option><option value="shift3">Shift 3</option></select>
                &nbsp;<select id="type" class="sbox"><option value="datang">Datang</option><option value="pulang">Pulang</option></select>
		<input type=button class="button" value="Klik" onClick="take_snapshot();"></p>
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {
			document.getElementById('response').innerHTML = '<h3>Sedang Proses Silahkan tunggu ...</h3>';
			var identitas = document.getElementById('identitas').value;
                        var Shift = document.getElementById('Shift').value;
                        var types = document.getElementById('type').value;
			webcam.snap('security.php?i='+identitas+'&Shift='+Shift+'&types='+types);
		}
		function my_completion_handler(msg) {
			document.getElementById('response').innerHTML ='<b>Info:</b> '+msg; 
			webcam.reset();
			document.form.reset();
                        setTimeout("location.href = 'http://presensi.uny.ac.id/index.php';",30000);

		}
	</script>
    </p>
    </div>
    </td><td valign=top>
        <p class="info" align="center"><b><a href="petunjuk.html?height=500&width=800" title="Petunjuk Penggunaan" class="thickbox">PETUNJUK PENGGUNAAN</a></b></p>
	<p class="info" align="center"><b><a href="login.php?height=250&width=300" title="Login Riwayat Presensi" class="thickbox">RIWAYAT PRESENSI</a></b></p>
		<div id="response"><p align="center"><b class="blinking">Silahkan Masukkan Nip / ID Anda..!<br />Dan Pilih Datang atau Pulang..</b></p></div>
	</td></tr></table>
    </div>
    </div>
</body>
</html>
