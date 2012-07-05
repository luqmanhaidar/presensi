<?php
  define("ACCESS","mall_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include("func.mall.php");
  include("adm.header.php");
?>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	$jab=stripslashes($_GET['jab']);
		switch ($jab) {
			case 'Dosen': 
				cariMarixDosen ();
				break;
			case 'Karyawan': 						
				cariMatrixKaryawan ();
				break;
			default : 
				$pageTitle="index"; 
				cariMarixDosen ();
			}
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>
