<?php
  define("ACCESS","dafall_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.dafall.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	$jab=stripslashes($_GET['jab']);
	switch ($jab) {
		case 'Dosen': 
			DaftarDosen ();
			break;
		case 'Karyawan': 						
			DaftarKaryawan ();
			break;
		default : 
			DaftarDosen ();
			break;
			}
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>