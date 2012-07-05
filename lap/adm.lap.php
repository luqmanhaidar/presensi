<?php
  define("ACCESS","lap_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include ("adm.header.php");
?>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
  <div id="lipsum">
<?php 
    include ("func.php");
    GwForm ();
    TypeJabatan();
?>

  </div>             
  </div>
  
<!-- END LEFT CONTENT-->  

<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>