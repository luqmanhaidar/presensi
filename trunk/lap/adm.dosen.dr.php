<?php
  define("ACCESS","dosen_dr");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.form.php");
  include("func.rekap.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	DosDr();
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
