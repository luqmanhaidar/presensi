<?php
  define("ACCESS","view_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include("func.matrix.php");
  include("adm.header.php");
?>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
	<?php
	cariMarixDosen ();
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>
