<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="300" >
	<title>Sistem Presensi Universitas Negeri Yogyakarta</title>
	<meta name="author" content="Dwi Agus">
    <link rel="stylesheet" type="text/css" href="style.css">
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
		webcam.set_api_url( 'presensi.php' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(460, 345) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form id="form">
		<p class="submit"><input type='password' class="search" size='22' name='identitas' id='identitas' value='' onchange="take_snapshot();" autocomplete="off" runat="server">
		<input type=button class="button" value="Klik" onClick="take_snapshot();"></p>
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {
			// take snapshot and upload to server
			document.getElementById('response').innerHTML = '<h3>Sedang Proses Silahkan tunggu ...</h3>';
			if(document.getElementById('identitas').value){
			webcam.snap('presensi.php?i='+document.getElementById('identitas').value);
		         }
		}
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				document.getElementById('response').innerHTML = 
					'<h1>Upload Successful!</h1>' + 
					'<h3>JPEG URL: ' + image_url + '</h3>' + 
					'<img src="' + image_url + '">';
				// reset camera for another shot
				//webcam.reset();
                document.getElementById('response').innerHTML ='<b>Info</b> '+msg;
			}
			else document.getElementById('response').innerHTML ='<b>Info:</b> '+msg;
			webcam.reset();
		}
	</script>
    </p>
    </div>
    </td><td valign=top>
        <p class="info" align="center"><b><a href="petunjuk.html">PETUNJUK PENGGUNAAN</a></b><br /><br /><b><a href="index.php"> Silahkan Klik disini sebelum Presensi</a></b></p>
		<div id="response"><p align="center"><b class="blinking">Silahkan Masukkan Nip / ID Anda..!</b></p></div>
        
	</td></tr></table>
    </div>
    </div>
    
</body>
</html>
