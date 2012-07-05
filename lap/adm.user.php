<?php
define("ACCESS","user");
require("adm.db.php");
require("adm.init.php");
include("cnn/CnnFormH.php");
include("cnn/CnnFormV.php");

if(isset($_GET['mode'])){
	if($_GET['mode']=="new"){
		if($_GET['type']=="cat"){
			$usergroup= new CnnFormH($_table_prefix."group");
			$usergroup->addInputText("group_name","group_name","required");
			$arr=array("2","No","1","Yes");
			foreach($_config['menu'] as $menu){
				$usergroup->addInputSelect($menu[1],$menu[0],$arr);
			}
			$usergroup->addSubmitAdd();
			if(isset($_POST['submit_add'])){
				header("Location: ".$_SERVER['PHP_SELF']);
			}
		}else{
			if(isset($_POST['submit_add'])){
					$t=$_POST['upass'];
					$_POST['upass']=md5($_POST['upass']);
			}
			$user= new CnnFormH($_table_prefix."user");
			$user->addHiddenValue("upassn",$t);
			$user->addInputText("First name","ufname","required");
			$user->addInputText("Last name","ulname","required");			
			$user->addInputText("Username","uname","required");
			$user->addInputText("Password","upass","required");
			$user->addInputText("Email","uemail","required");
                        $user->addInputText("Fak / Bagian","Fak","required");
			$arr=array("","-- choose one --");
			$cat=fetchRow($_table_prefix."group");
			foreach($cat as $t){
				array_push($arr,$t['group_id']);
				array_push($arr,$t['group_name']);
			}
			$user->addInputSelect("User group","ugroup",$arr,"validate-selection");
			$user->addSubmitAdd();
			if(isset($_POST['submit_add'])){
					header("Location: ".$_SERVER['PHP_SELF']);
			}
		}
	}else{
		if($_GET['type']=="cat"){
			if(isset($_GET['group_id']) && $_GET['group_id']!="" && is_numeric($_GET['group_id'])){
				$usergroup= new CnnFormH($_table_prefix."group","where group_id='".$_GET['group_id']."'");
				$usergroup->addInputText("group_name","group_name","required");
				$arr=array("2","No","1","Yes");
				foreach($_config['menu'] as $menu){
					$usergroup->addInputSelect($menu[1],$menu[0],$arr);
				}
				$usergroup->addSubmitUpdate();
				if(isset($_POST['submit_update'])){
					header("Location: ".$_SERVER['PHP_SELF']);
				}
			}else{
				header("Location: ".$_SERVER['PHP_SELF']);
			}			
		}else{
			if(isset($_GET['uid']) && $_GET['uid']!="" && is_numeric($_GET['uid'])){
				if(isset($_POST['submit_update'])){
					$t=md5($_POST['upassn']);
				}
				
				$user= new CnnFormH($_table_prefix."user","where uid='".$_GET['uid']."'");
				$user->addHiddenValue("upass",$t);
				$user->addInputText("First name","ufname","required");
				$user->addInputText("Last name","ufname");
				$user->addInputText("Username","uname","required");
				$user->addInputText("Password","upassn","required");
				$user->addInputText("Email","uemail","validate-email");
                                $user->addInputText("Fak / Bagian","Fak","required");
				$arr=array("","-- choose one --");
				$cat=fetchRow($_table_prefix."group");
				foreach($cat as $t){
					array_push($arr,$t['group_id']);
					array_push($arr,$t['group_name']);
				}
				$user->addInputSelect("User group","ugroup",$arr,"validate-selection");
				$user->addSubmitUpdate();
				if(isset($_POST['submit_update'])){
					header("Location: ".$_SERVER['PHP_SELF']);
				}
			}else{
				header("Location: ".$_SERVER['PHP_SELF']);
			}
		}
	}
}else{
	$listc= new CnnFormV($_table_prefix."group","group_id","where group_id <> 1");
	$listc->addLink("Group name","group_name",$_SERVER['PHP_SELF'],"","mode=edit&type=cat");
	$listc->addStaticLink ("Edit","<img align=\"absmiddle\" style=\"border:0\" src=\"images/edit.png\" title=\"Edit\" alt=\"edit\" border=\"0\" />",$_SERVER['PHP_SELF'],"","mode=edit&type=cat");
	$listc->addSubmitDelete();
	
	$max=10;
	$listnav=new CnnNav($max, $_table_prefix."user","","*","uid","9","5","3","&laquo;","&raquo;"," ", "");
	$start=$_GET['offset']?$_GET['offset']*$max:0;
	
	$list= new CnnFormV($_table_prefix."user","uid","where uid <> '".$_SESSION['userdata']['uid']."' order by uid asc limit ".$start.",".$max);
	$list->addLink("Nama Depan","ufname",$_SERVER['PHP_SELF'],"","mode=edit");
	$list->addLink("Nama Belakang","uname",$_SERVER['PHP_SELF'],"","mode=edit");
	$arr=array("","-- Pilih --");
	$cat=fetchRow($_table_prefix."group");
	foreach($cat as $t){
		array_push($arr,$t['group_id']);
		array_push($arr,$t['group_name']);
	}
	$list->addInputSelect("User group","ugroup","",$arr);
	$list->addSubmitDelete();
}
?>
<?php include ("adm.header.php");?>
  <!-- START .grid_9 - LEFT CONTENT -->  
  <div class="grid_9 cnt" id="left">
  <div id="lipsum">
<?php
if(isset($_GET['mode'])){
	if($_GET['mode']=="new"){
		if($_GET['type']=="cat"){
			?>
            <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
			<h1>Buat Group baru</h1>
                        <div id="kotakbiru">
			<div><?php $usergroup->printform();?></div>
                        </div>
			<?php
		}else{
			?>
            <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
			<h1>Buat Entry baru</h1>
                        <div id="kotakbiru">
			<div><?php $user->printform();?></div>
                        </div>
			<?php
		}
	}else{
		if($_GET['type']=="cat"){
			if(isset($_GET['group_id']) && $_GET['group_id']!="" && is_numeric($_GET['group_id'])){
				?>
                <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
				<h1>Edit Group</h1>
                                <div id="kotakbiru">
				<div><?php $usergroup->printform();?></div>
                                </div>
				<?php
			}else{
				header("Location: ".$_SERVER['PHP_SELF']);
			}
		}else{
			if(isset($_GET['uid']) && $_GET['uid']!="" && is_numeric($_GET['uid'])){
				?>
                
                <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img align="absmiddle" style="border:0" src="images/backs.png" alt="Back" border="0" />&nbsp;Back</a></div>
				<h1>Edit User</h1>
                                <div id="kotakbiru">
				<div><?php $user->printform();?></div>
                </div>
				<?php
			}else{
				header("Location: ".$_SERVER['PHP_SELF']);
			}
		}
	}
}else{
?>
			
                        <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>?mode=new&type=cat"><img align="absmiddle" style="border:0" src="images/new.png" alt="Create New group" border="0" />&nbsp;Buat Group baru</a></div>
			<h1>Daftar group</h1>
                        <div id="kotak">
			<div><?php $listc->printform();?></div>
                        </div>
            <br />
			
                        <div align="right"><a href="<?php echo $_SERVER['PHP_SELF'];?>?mode=new"><img align="absmiddle" style="border:0" src="images/new.png" alt="Create New Entry" border="0" />&nbsp;Buat Entry baru</a></div>
			<h1>Daftar User</h1>
                        <div id="kotakbiru">
			<div align="center"><div class="pagination"><?php $listnav->printnav();?></div></div>
			<div><?php $list->printform();?></div>
                        </div>
<?php
}
?>
  </div>             
  </div>
  
<!-- END LEFT CONTENT-->  

<?php include ("adm.menu.php");?>
<?php include("adm.footer.php"); ?>