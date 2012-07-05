<?php
  session_start();
 
  if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Fakultas Teknik UNY | Admin</title>
<link href="css/reset.css"  rel="stylesheet" type="text/css" media="all" />
<link href="css/text.css"  rel="stylesheet" type="text/css" media="all" />
<link href="css/960.css"  rel="stylesheet" type="text/css" media="all" />
<link href="css/green.css"  rel="stylesheet" type="text/css" media="all" />
<link href="ui/css/sleek/style.css" rel="stylesheet" type="text/css" />
<script src="ui/jquery-1.3.2.min.js"  type="text/javascript"></script>
<script src="ui/jquery-ui-1.7.1.custom.js"  type="text/javascript"></script>
<script src="js/components.js"  type="text/javascript"></script>
<script src="js/effects.js"  type="text/javascript"></script>
<!--[if IE 6]>
<style type="text/css" >
p.error span, p.info span, p.notice span, p.success span { 
	postion:static;
    margin-right:15px;
}
p.todoitem a.close {
	margin-right:10px;
}
button.green, button.brown {
	padding:0px !important;
}
</style>
<![endif]-->

</head>
<body>
<!-- start .grid_12 - the container -->
<div class="container_12">
	<!-- end .grid_7 - HEADER -->
	<div class="clear"></div>
   <!-- end .grid_12 - MENU -->
  <div class="grid_12" id="submenu">
	<ul>
		<li>Sistem Presensi Online Fakultas Teknik Universitas Negeri Yogyakarta</li>
	</ul>	
  </div>
  <!-- end .grid_12 - SUBMENU -->
  <div class="clear"></div>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
  <div id="lipsum">
  <?php
  include ("func.profile.php");
	$jab=stripslashes($_GET['jab']);
	switch ($jab) {
		case 'Dosen': 
			profileDosen ();
			break;
		case 'Karyawan': 						
			profileKaryawan ();
			break;
		default : 
			profileDosen ();
			break;
			}
?>

    </div>             
  </div>
  
<!-- END LEFT CONTENT-->  

<!-- START RIGHT CONTENT - Widget menu -->    
  <div class="grid_3">
  <!-- TODO WIDGET -->
  	<div class="widget" id="todo">
   	  <h3 class="todo">Navigasi</h3>
   	  <p class="todoitem"><a class="view_all" href="laporan.php?jab=Dosen">Laporan Presensi Dosen</a><a class="close" href="laporan.php?jab=Dosen">X</a></p>
   	  <p class="todoitem"><a class="view_all" href="laporan.php?jab=Karyawan">Laporan Presensi Karyawan</a><a class="close" href="laporan.php?jab=Karyawan">X</a></p>
	  <p class="todoitem"><a class="view_all" href="lap.view.php?jab=Dosen">Lap view Dosen</a><a class="close" href="lap.view.php?jab=Dosen">X</a></p>
	  <p class="todoitem"><a class="view_all" href="lap.view.php?jab=Karyawan">Lap view Karyawan</a><a class="close" href="lap.view.php?jab=Karyawan">X</a></p>
     	  <p class="todoitem"><a class="view_all" href="daftar.php?jab=Dosen" >DAFTAR Hadir Dosen</a><a class="close" href="#">X</a></p>
	  <p class="todoitem"><a class="view_all" href="daftar.php?jab=Karyawan" >DAFTAR Hadir Karyawan</a><a class="close" href="#">X</a></p>
	  <p class="todoitem"><a class="view_all" href="datamatrik.php?jab=Dosen" >Matrix Dosen</a><a class="close" href="#">X</a></p>
	  <p class="todoitem"><a class="view_all" href="datamatrik.php?jab=Karyawan" >Matrix Karyawan</a><a class="close" href="#">X</a></p>
	  <p class="todoitem"><a class="view_all" href="profile.php?jab=Dosen" >Data Dosen</a><a class="close" href="#">X</a></p>
          <p class="todoitem"><a class="view_all" href="profile.php?jab=Karyawan" >Data Karyawan</a><a class="close" href="#">X</a></p>
	  <p class="todoitem"><a class="view_all" href="logout.php" >logOut</a></p></div>
	<br />
           
  </div>
  <!-- end .grid_13 - RIGHT CONTENT - Widget menu  -->
  <div class="clear"></div>
  <!--FOOTER START-->
  <div class="grid_12 cnt" id="footer">Attendance System - Copyright. 2009 | Fakultas Teknik Universitas Negeri Yogyakarta</div>
  <!--FOOTER END-->
  <div class="clear"></div>
</div>
</body>
</html>
