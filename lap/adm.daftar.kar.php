<?php
  define("ACCESS","rekap_karyawan");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.daftar.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	$bag= $_SESSION['userdata']['ulname'];
	echo $bag;
	switch($bag){
	  case "BUPK"	:
	    DaftarKaryawan ("BUPK");
	    //FormBAUK();
	    break;
	  case "BAKI":
	    //FormBAAKPSI();
	    DaftarKaryawan ("BAKI");
	    break;
	  case "WATES":
	    //FormBAAKPSI();
	    DaftarKaryawan ("WATES");
	    break;
	  default	:
	    DaftarKaryawan ();
	    break;
	}
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
