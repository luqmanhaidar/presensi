<?php
$_sql="select * from ".$_table_prefix."user where uname='".$_SESSION['uname']."' and upass='".$_SESSION['upass']."'";
//echo $_sql;
$auth=mysql_query($_sql) or die($_lang['err_auth_error']);
if(mysql_num_rows($auth)>0){
	$userdata=mysql_fetch_assoc($auth) or die($_lang['err_db__res']);
	//echo $_sql;
	$isvalid=0;
	if($userdata['ugroup']==1){
		$_SESSION['isAdmin']=1;
		$isvalid=1;
	}
	if($isvalid==0){
		$_sql="select * from ".$_table_prefix."group where group_id='".$userdata['ugroup']."'";
		$page=mysql_query($_sql) or die($_lang['err_query']);
		$pages=mysql_fetch_assoc($page) or die($_lang['err_db__res']);
		$arrpages=array();
		for($i=3;$i<mysql_num_fields($page);$i++){
			$arrpages[mysql_field_name($page,$i)]=$pages[mysql_field_name($page,$i)];
			///array_push($arrpages,);
			//array_push($arrpages,);
		}
		//print_r($arrpages);
		//die();
		$_SESSION['pages']=$arrpages;
		//$isvalid=1;
		if($arrpages[ACCESS]==1){
			$isvalid=1;
		}
	}
	if($isvalid==0){
		header("Location: ".$_config['redirect_page']);
	}else{
		
	}	
}else{
	header("Location: ".$_config['redirect_page']);
}
?>