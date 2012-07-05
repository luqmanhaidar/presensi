<?php
define("ACCESS","news");
require("adm.db.php");
require("adm.init.php");
include("cnn/CnnFormH.php");
include("cnn/CnnFormV.php");
$tittle="Adm Profile";
if(isset($_GET['mode'])){
	if($_GET['mode']=="new"){
		if(isset($_POST['submit_add'])){        
			}
                $profile= new CnnFormH("info");
		$profile->addInputDate  ("Tanggal","tgl");
                $profile->addInputTextArea  ("Konten","konten");
		$profile->addSubmitAdd("Simpan","Simpan");
		if(isset($_POST['submit_add'])){
			header("Location: ".$_SERVER['PHP_SELF']);
			}
		
	}else{
		if(isset($_GET['id']) && $_GET['id']!="" && is_numeric($_GET['id'])){
		$profile= new CnnFormH("info","where id='".$_GET['id']."'");
		$profile->addInputDate  ("Tanggal","tgl");
                $profile->addInputTextArea  ("Konten","konten");
		$profile->addSubmitUpdate();
		if(isset($_POST['submit_update'])){
			header("Location: ".$_SERVER['PHP_SELF']);
			}
		}else{
			header("Location: ".$_SERVER['PHP_SELF']);
			}
	}
}else{
	$max=10;
	$listnav=new CnnNav($max,"info","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
	$start=$_GET['offset']?$_GET['offset']*$max:0;
	$list= new CnnFormV("info","id","order by id asc limit ".$start.",".$max);
	$list->addLink("Tanggal","tgl",$_SERVER['PHP_SELF'],"","mode=edit");
	$list->addLink("Judul","judul",$_SERVER['PHP_SELF'],"","mode=edit");
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
		<h1>Tambah Berita Baru</h1>
		<div><?php $profile->printform();?></div>
		<?php
		}
	else{
		if(isset($_GET['id']) && $_GET['id']!="" && is_numeric($_GET['id'])){
		?>
                <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
		<h1>Edit Berita</h1>
		<div><?php $profile->printform();?></div>
		<?php
			}else{
				header("Location: ".$_SERVER['PHP_SELF']);
			}
		
	}
}else{
?>
			
	<div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>?mode=new"><img align="absmiddle" style="border:0" src="images/new.png" alt="Tambah Pegawai Baru" border="0" />&nbsp;Tambah Pegawai Baru</a></div>
	<h1>Daftar Berita</h1>
	<div align="center"><div class="pagination"> <p class= "info"><b><?php $listnav->printnav();?>&nbsp;</b></p></div></div>
	<div id='kotak'><?php $list->printform();?></div>
<?php
}	
?>
</div>
</div>
<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>