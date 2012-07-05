<?php
  define("ACCESS","hadir_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.hadir.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	FormDosen ();
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
