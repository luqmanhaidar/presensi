<?php
  define("ACCESS","hadir_karyawan");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.hadir.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	$bag  = $_SESSION['userdata']['ulname'];
	switch($bag){
	  case	"BUPK"	:
	    //FormBAUK();
	    FromKaryawan("BUPK");
	    break;
	  case	"BAKI" :
	    //FormBAAKPSI();
	    FromKaryawan("BAKI");
	    break;
	  case	"WATES" :
	    //FormBAAKPSI();
	    FromKaryawan("WATES");
	    break;
	  default	:
	    FromKaryawan();
	    break;
	}
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
