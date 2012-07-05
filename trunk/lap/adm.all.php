<?php
  define("ACCESS","all_dosen");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
?>

  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
  <div id="lipsum">
  <?php 
    include ("func.all.php");
    GwForm ();
    EditJabatan();
  ?>

  </div>             
  </div>
  

<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>

