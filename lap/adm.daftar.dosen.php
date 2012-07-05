<?php
  define("ACCESS","rekap_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
  include("func.form.php");
  include("func.daftar.php");
?>
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	DaftarDosen ();
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include("adm.footer.php");
?>
