<?php
  define("ACCESS","cetak_rekap_hk_all");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.rekap.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	AdmFormHk();
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>