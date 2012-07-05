<?php
//General Database Configuration
	$useTransaction = false;

//General Form Configuration
	$defFormProp = " action=\"\" method=\"post\" enctype=\"multipart/form-data\"";
	$defTableWidth = array('96%', '', '400');
	$defTableProp = "id=\"formtable\"";
	$defTableBgColor = "";
	$defTitleCss = "titlesectionbox";
	$defTitleBgColor = "";
	$defTitleAlign = "left";
	$defContentCss = "";
	$defContentCss = "formsectiontitle";
	$defContentAlign = "left";
	$defSubmitCss = "";
	$defSubmitBgColor = "";
	$defSubmitAlign = "left";
	$defEditorImagePath = "/img_content";
	$defEditorCSSPath = "/cnn_style.css";
	//JsAlert(dirname(addslashes(realpath($_SERVER['PHP_SELF']))));
	$thisfol=dirname(dirname($_SERVER['PHP_SELF']));
	$t=basename($thisfol);
	$site="localhost";
	$folder="docs";
	$defDirImageMCE = "../../../../".$folder."/";
	$defURLImageMCE = $site."/".$folder."/";
	if($t!=""){
		$defURLImageMCE = $site."/".$t."/".$folder."/";
	}
	//JsAlert($defURLImageMCE);
	//$defURLImageMCE = "preview.bsg.nl/omniplan/images_stock/";
	$inputBlank = true;
?>