<?php
  define("ACCESS","testimoni");
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
                //$cat=$_GET['cat'];
                if($_GET['cat'] == 'del'){
                    $did = abs((int)$_GET['id']);
                    $sql = "DELETE FROM testimoni WHERE id='".$did."'";
                    if($res=mysql_query($sql)){
                        echo "<script type=\"text/javascript\">alert('DELETE Testimoni Sukses'); window.location =\"adm.testimoni.php\";</script>"; 
                    }else{
                            echo "<script type=\"text/javascript\">alert('DELETE testimoni Gagal'); window.location =\"adm.testimoni.php\";</script>";
                         }
                }else{
                    $row = fetchRow("testimoni" ,"order by tanggal DESC","id,tanggal,nama,pesan");
                    $iz  = 1;
                    echo "<table width=\"100%\" id=\"data\">";
                    echo "<tr><th>No</th><th>Nama Pengirim</th><th>Tanggal</th><th>Pesan</th><th>hapus</th></tr>";
                    foreach($row as $r){
                         echo "<tr><td>$iz</td><td>".$r['nama']."</td><td>".$r['tanggal']."</td><td>".$r['pesan']."</td><td><a href=\"adm.testimoni.php?cat=del&id=$r[id]\"><img src='images/icon_delete.gif'></a></td></tr>";
                         $iz++;
                    }
                    echo "</table>";
                }
            ?>
    </div>             
  </div>
<?php
include ("adm.menu.php");
include ("adm.footer.php");
?>