<?php
  define("ACCESS","cetak_rekap_hk");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.rekap.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
        $bag= $_SESSION['userdata']['ulname'];
	switch ($bag){
            case "BUPK" :
                FormHKBAUK();
                break;
            case "BAKI"  :
                FormHKBPSI();
                break;
            default :
                FormHk();
                break;
        }
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>