<?php
  define("ACCESS","indexs");
  require_once("adm.db.php");
  require("adm.init.php");
  include ("adm.header.php");
?>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
  <div id="lipsum">
    <h1>Sistem Presensi Universitas Negeri Yogyakarta</h1>
	<!--<blockquote><p>Selamat Datang [ <?php echo $_SESSION['userdata']['ufname']." ".$_SESSION['userdata']['ulname'];?>]</p></blockquote>	-->	
    <!--
    <p class="info"><span>X</span>
      <marquee behavior="scroll" direction="up" scrollamount="1" height="75">
        <b>Menu:</b><br />
        <b>Menu Daftar Pegawai :</b> Untuk managemen (tambah, edit, dan hapus) daftar Pegawai <br />
        <b>Menu Daftar presensi Dosen : </b>Untuk menampilkan presensi dosen (tampil memurut hari, bulan, tanggal, dan jurusan)<br />
        <b>Menu Daftar presensi Karyawan : </b>Untuk menampilkan presensi Karyawan (tampil memurut hari, bulan, tanggal, dan jurusan)<br />
        <b>Menu Rekap presensi Dosen : </b>Untuk menampilkan Rekap presensi dosen  Perbulan (menampilkan Jam Masuk, Foto Masuk dan Jumlah kehadiran dlm Satu Bulan)<br />
        <b>Menu Rekap presensi Karyawan : </b>Untuk menampilkan Rekap presensi Karyawan  Perbulan (menampilkan Jam Masuk, Jam Keluar, Foto Masuk, Foto keluar dan Jumlah kehadiran dlm Satu Bulan)<br />
      </marquee>
    </p>
	-->
      <h2>Kritik Saran Keluhan</h2>
      <p class="notice"><span>X</span>
	<marquee behavior="scroll" direction="up" scrollamount="1" height="125">
	  <?php
	  $row=fetchRow("testimoni","order by tanggal DESC limit 50","tanggal,nama,pesan");
	  foreach($row as $ch){
	    echo "<i>".$ch['nama']."</i><br />";
	    echo "<i>".$ch['tanggal']."</i><br />";
	    echo $ch['pesan']."<br />";
	  }
	  ?>
	</marquee>
      </p>
      <p><b>Silahkan kirimkan melalui form dibawah ini</b></p>
      <?php
	if(isset($_POST['submitAd'])){
	  $nama	= $_SESSION['userdata']['ufname']." ".$_SESSION['userdata']['ulname'];
	  $msg	= $_POST['pesan'];
	  $tgl	= date('Y-m-d');
	  $sql	= "INSERT INTO testimoni (tanggal,nama,pesan) VALUE ('$tgl','$nama','$msg')";
	  if($res = mysql_query($sql)){
	    echo "<script type=\"text/javascript\">alert('Insert Testimoni Sukses'); window.location =\"adm.home.php\";</script>"; 
	  }else{
	    echo "<script type=\"text/javascript\">alert('Insert Testimoni Gagal'); window.location =\"adm.home.php\";</script>";
	  }
	}else{
      ?>
      <form class="nice" method="post">
	<p class="left">
	  <label><b>Nama</b></label>
	  <input name="nama" class="inputText" value="<?php echo $_SESSION['userdata']['uname'];?>" disabled>
	  <label><b>Pesan</b></label>
	  <textarea name="pesan" cols="" rows="10" class="inputText_wide_"></textarea>
	  <br clear="all">
	    <button type="submit" class="green" name="submitAd">Submit</button>
	</p>
	<div class="clear"></div>
      </form>
      <?php } ?>
    <p class="notice">
      <span>X</span>
      <b>Change Log</b><br />
      <marquee behavior="scroll" direction="up" scrollamount="1" height="200">
      <?php
      $row=fetchRow("chengelog","order by tanggal DESC limit 50","tanggal,ket");
      foreach($row as $ch){
	echo "<i>".$ch['tanggal']."</i><br />";
	echo $ch['ket']."<br />";
      }
      ?>
      </marquee>
    </p>
  </div>             
  </div>
  
<!-- END LEFT CONTENT-->  

<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>