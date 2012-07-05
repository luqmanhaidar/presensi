<?php
  define("ACCESS","hadir_jur");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.rekap.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	FormRekapDosen();
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
