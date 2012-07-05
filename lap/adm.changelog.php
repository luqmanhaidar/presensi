<?php
  define("ACCESS","changelog");
  require("adm.db.php");
  require("adm.init.php");
  include("func.matrix.php");
  include("adm.header.php");
  include ("cnn/CnnNav.php");
?>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
	<div id="ipsum">
            <h1>Sistem Presensi Universitas Negeri Yogyakarta</h1>
	<?php
	 $cat=$_GET['cat'];
         switch($cat){
            case    "new"   :
                $form  = "<form method=\"post\" class=\"nice\">";
                $form .= "<p class=\"left\">";
                $form .= "<label><b>Tanggal</b></label>";
                $form .= "<input name=\"hari\" class=\"dateinput\" type=\"text\" />";
                $form .= "<label><b>Changelog</b></label>";
                $form .= "<textarea name=\"changelog\" cols=\"\" rows=\"10\" class=\"inputText_wide_\"></textarea>";
                $form .= "<br clear=\"all\" />";
                $form .= "<button type=\"submit\" class=\"green\" name=\"submitAd\">Submit</button>\n";
                $form .= "</p>";
                $form .= "<div class=\"clear\"></div>";
                $form .= "</form>";
                if(isset($_POST['submitAd'])){
                    $tgl=$_POST['hari'];
                    $ket=$_POST['changelog'];
                    $sql="INSERT into chengelog (tanggal,ket) VALUES ('$tgl','$ket')";
                    if($res=mysql_query($sql)){
                        echo "<script type=\"text/javascript\">alert('Insert Changelog Sukses'); window.location =\"adm.changelog.php\";</script>"; 
                    }else{
                            echo "<script type=\"text/javascript\">alert('Insert Changelog Gagal'); window.location =\"adm.changelog.php\";</script>";
                         }
                }else{
                    echo $form;
                }
                break;
            case    "edit"  :
                $_id   = $_GET['id'];
                $data  = fetch("chengelog","where id='".$_id."'","id,tanggal,ket");
                $form  = "<form method=\"post\" class=\"nice\">";
                $form .= "<p class=\"left\">";
                $form .= "<label><b>Tanggal</b></label>";
                $form .= "<input name=\"tgl\" class=\"dateinput\" type=\"text\" value=\"".$data['tanggal']."\" />";
                $form .= "<input name=\"hid\" type=\"hidden\" value=\"".$data['id']."\" />";
                $form .= "<label><b>Changelog</b></label>";
                $form .= "<textarea name=\"changelog\" cols=\"\" rows=\"10\" class=\"inputText_wide_\">".$data['ket']."</textarea>";
                $form .= "<br clear=\"all\" />";
                $form .= "<button type=\"submit\" class=\"green\" name=\"submitEd\">Submit</button>\n";
                $form .= "</p>";
                $form .= "<div class=\"clear\"></div>";
                $form .= "</form>";
                if(isset($_POST['submitEd'])){
                    //print_r($_POST);
                    $h_id= $_POST['hid'];
                    $tgl = $_POST['tgl'];
                    $ket = $_POST['changelog'];
                    $sql = "UPDATE chengelog SET tanggal='".$tgl."',ket='".$ket."' WHERE id='".$h_id."'";
                    if($res=mysql_query($sql)){
                        echo "<script type=\"text/javascript\">alert('UPDATE Changelog Sukses'); window.location =\"adm.changelog.php\";</script>"; 
                    }else{
                            echo "<script type=\"text/javascript\">alert('UPDATE Changelog Gagal'); window.location =\"adm.changelog.php\";</script>";
                         }
                }else{
                    echo $form;
                }
                break;
            case    "del"   :
                if($_GET['id']){
                    $g_id = abs((int)$_GET['id']);
                    $sql  = "DELETE FROM chengelog WHERE id='".$g_id."'";
                    if($res=mysql_query($sql)){
                        echo "<script type=\"text/javascript\">alert('DELETE Changelog Sukses'); window.location =\"adm.changelog.php\";</script>"; 
                    }else{
                            echo "<script type=\"text/javascript\">alert('DELETE Changelog Gagal'); window.location =\"adm.changelog.php\";</script>";
                         }
                }
                break;
            default         :
                echo "<h2>Change Log version</h2>";
                //echo $fakk;
                echo "<div align=\"right\"><a href=\"".$_SERVER['PHP_SELF']."?cat=new\"><img align=\"absmiddle\" style=\"border:0\" src=\"images/new.png\" alt=\"Back\" border=\"0\" />&nbsp;Tambah Baru</a></div>";
                $max=30;
                $i=1;
                $listnav=new CnnNav($max,"chengelog","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
                $start=$_GET['offset']?$_GET['offset']*$max:0;
                $log=fetchRow("chengelog","order by tanggal desc limit ".$start.",".$max."");
                echo "<div>";
                echo "<table width=\"100%\" id=\"data\">";
                echo "<tr><th>Tanggal</th><th>Log</th><th>edit</th><th>Delete</th></tr>";
                foreach($log as $l){
                    echo "<tr><td>".$l['tanggal']."</td><td>".$l['ket']."</td><td><a href='adm.changelog.php?cat=edit&id=$l[id]'><img src='images/icon_calendar.gif'></a></td><td><a href=\"adm.changelog.php?cat=del&id=$l[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "<div>";
                echo "<p class= \"info\"><b>";
                $listnav->printnav();
                echo "</b></p></div>";
                break;
         }
	?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>
