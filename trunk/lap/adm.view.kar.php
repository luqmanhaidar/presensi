<?php
  define("ACCESS","view_karyawan");
  require("adm.db.php");
  require("adm.init.php");
  include("adm.header.php");
?>

  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
  <div id="lipsum">
  <?php
    //
    include ("func.lap.php");
    $bag= $_SESSION['userdata']['ulname'];
    echo $bag;
    switch($bag){
      case "BUPK" :
        //FormBAUK();
        FormKaryawan ("BUPK");
        break;
      case "BAKI"  :
        //FormBAAKPSI();
        FormKaryawan ("BAKI");
        break;
      case "WATES"  :
        //FormBAAKPSI();
        FormKaryawan ("WATES");
        break;
      default :
        FormKaryawan ();
        EditJabatan();
        break;
    }
  ?>

  </div>             
  </div>
  

<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>

