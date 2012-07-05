<?php
define("ACCESS","daftar_pegawai");
require("adm.db.php");
require("adm.init.php");
include("cnn/CnnFormH.php");
include("cnn/CnnFormV.php");
$tittle="Adm Profile";
if(isset($_GET['mode'])){
	if($_GET['mode']=="new"){
		if(isset($_POST['submit_add'])){
				$z=$_POST['Nip'];
                                $q=$_POST['NamaLengkap'];
                                $x=str_replace(" ","",$q);
				//$sql=mysql_query("INSERT INTO presensi (Nip,login,Tanggal,JamMasuk,JamKeluar,abs) VALUES ('".$_POST['Nip']."','".$_POST['Nama']."','0000-00-00','00:00:00','00:00:00','1')");
				if($_POST['NIP']=="codot"){
					echo "error";
				}
			}
                $profile= new CnnFormH("profile");
                $fakk=$_SESSION['userdata']['Fak'];
                $y=$fakk.$x;
		$profile->addInputText  ("Nama Lengkap","NamaLengkap");
                $profile->addInputText  ("Nip","Nip");
                $profile->addHiddenValue ("Nama",$y);
                $fx=$_SESSION['userdata']['Fak'];
                $profile->addHiddenValue ("Fak",$fx);
                $profile->addHiddenValue("pass",$z);
                $arr=array ("Dosen","Dosen","Karyawan","Karyawan");
                $profile->addInputSelect  ("Jabatan","Jabatan",$arr);
                $arr=array("","-- Pilih --");
			$cat=fetchRow("adm_jurusan","where Fakultas='".$_SESSION['userdata']['Fak']."'");
			foreach($cat as $t){
				array_push($arr,$t['JurId']);
				array_push($arr,$t['JurDet']);
			}
                $profile->addInputSelect  ("Jurusan / Sub.Bag","Jurusan",$arr);
		$arr=array("","-- Pilih --");
			$cat=fetchRow("adm_gol");
			foreach($cat as $t){
				array_push($arr,$t['Gol']);
				array_push($arr,$t['Pangkat']);
			}
                $profile->addInputSelect  ("Pangkat / Golongan","Gol",$arr);
		$profile->addSubmitAdd("Simpan","Simpan");
		if(isset($_POST['submit_add'])){
			header("Location: ".$_SERVER['PHP_SELF']);
			}
		
	}else{
		if(isset($_GET['id']) && $_GET['id']!="" && is_numeric($_GET['id'])){
		$profile= new CnnFormH("profile","where id='".$_GET['id']."'");
		$profile->addInputText  ("Nama Lengkap","NamaLengkap");
                $profile->addInputText  ("Nip","Nip");
                $profile->addInputText  ("User","Nama");
                //$profile->addInputText  ("Password","pass");
                $fx=$_SESSION['userdata']['Fak'];
                $profile->addHiddenValue ("Fak",$fx);
                $arr=array ("Dosen","Dosen","Karyawan","Karyawan");
                $profile->addInputSelect  ("Jabatan","Jabatan",$arr);
                $arr=array("","-- Pilih --");
			$cat=fetchRow("adm_jurusan","where Fakultas='".$_SESSION['userdata']['Fak']."'");
			foreach($cat as $t){
				array_push($arr,$t['JurId']);
				array_push($arr,$t['JurDet']);
			}
                $profile->addInputSelect  ("Jurusan / Sub.Bag","Jurusan",$arr);
		$arr=array("","-- Pilih --");
			$cat=fetchRow("adm_gol");
			foreach($cat as $t){
				array_push($arr,$t['Gol']);
				array_push($arr,$t['Pangkat']);
			}
                $profile->addInputSelect  ("Pangkat / Golongan","Gol",$arr);
		$profile->addSubmitUpdate();
		if(isset($_POST['submit_update'])){
			header("Location: ".$_SERVER['PHP_SELF']);
			}
		}else{
			header("Location: ".$_SERVER['PHP_SELF']);
			}
	}
}else{
	$max=300;
	$listnav=new CnnNav($max,"profile","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
	$start=$_GET['offset']?$_GET['offset']*$max:0;
	$list= new CnnFormV("profile","id","where Fak='".$_SESSION['userdata']['Fak']."' order by id asc limit ".$start.",".$max);
	$list->addLink("Nama Lengkap","NamaLengkap",$_SERVER['PHP_SELF'],"","mode=edit");
	$list->addLink("Nip","Nip",$_SERVER['PHP_SELF'],"","mode=edit");
        $list->addLink("Jabatan","Jabatan",$_SERVER['PHP_SELF'],"","mode=edit");
	$list->addSubmitDelete("Hapus","Hapus");
}
?>

<?php include("adm.header.php"); ?>
<div class="grid_9 cnt" id="left">
<div id="lipsum">
<?php
if(isset($_GET['mode'])){
	if($_GET['mode']=="new"){
		?>
		<div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
		<h1>Tambah Pegawai Baru</h1>
		<div><?php $profile->printform();?></div>
		<?php
		}
	else{
		if(isset($_GET['id']) && $_GET['id']!="" && is_numeric($_GET['id'])){
		?>
                <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
		<h1>Edit Pegawai</h1>
		<div><?php $profile->printform();?></div>
		<?php
			}else{
				header("Location: ".$_SERVER['PHP_SELF']);
			}
		
	}
}else{
?>
			
	<div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>?mode=new"><img align="absmiddle" style="border:0" src="images/new.png" alt="Tambah Pegawai Baru" border="0" />&nbsp;Tambah pegawai Baru</a></div>
	<h1>Daftar Pegawai</h1>
	<div align="center"><div class="pagination"> <p class= "info"><b><?php $listnav->printnav();?></b></p></div></div>
	<div id='kotak'><?php $list->printform();?></div>
<?php
}	
?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>