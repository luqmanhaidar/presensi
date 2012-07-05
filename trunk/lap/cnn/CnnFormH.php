<?php
/**
 * Easy Form Creator and Management Class for PHP, which support:
 * - MySQL Database
 * - EditWorks Online WYSIWYG HTML editor
 * - InteractiveTool Online GPL WYSIWYG HTML editor
 * - TinyMCE Online GPL WYSIWYG HTML editor
 * - Extensive GD+ Image Manipulation by mark@teckis.com
 * - CSS   
 * Copyright (C) 2003 Cristian Ade Candra
 * 
 * Version  0.3.2  2005-07-06
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * 
 * Copy of GNU Lesser General Public License at: http://www.gnu.org/copyleft/lesser.txt
 * 
 * Source code home page: http://www.creezz.com/cnn/cnnformh/
 * Contact author at: mail@creezz.com
 * 
 * ChangeLog for version 0.0.1  2003-02-15
 * 0.0.1 first release
 *
 * ChangeLog for version 0.1.1  2004-06-16
 * Remove CnnFormH::addLayoutTool()
 * Add new function CnnFormH::addInteractiveTool().
 * 		This function use a GPL WYSIWYG HTML editor.
 * Modify code to make output more tidy
 *
 * ChangeLog for version 0.2.1 2004-10-21
 * Add new function CnnFormH::thumbnailer().
 *		This function use Thumbnail class.
 *
 * ChangeLog for version 0.3.1 2005-06-09
 * Add new function CnnFormH::mceTool()
 * 		This function use a GPL WYSIWYG HTML editor.
 *
 * ChangeLog for version 0.3.2 2005-07-06
 * Add new input paramater 'autoRename' to function CnnFormH::addInputImage() and CnnFormH::addInputImageThumb().
 * 		Set this paramater 'false' if you want to keep the uploaded file name.
 */

// Include Thumbnail class (Extensive GD+ Image Manipulation)
include_once ('Thumbnail.php');
include_once ('fckeditor/fckeditor.php');
class CnnFormH  {
	// Database Property
	var $_table;
	var $_extQuery; 

	// Form Property
	var $_formId;
	var $_formProp;
	var $_tableWidth;
	var $_tableProp;
	var $_tableBgColor;
	var $_titleCss;
	var $_titleBgColor;
	var $_titleAlign;
	var $_contentCss;
	var $_contentBgColor;
	var $_contentAlign;
	var $_submitCss;
	var $_submitBgColor;
	var $_submitAlign;
	var $_inputBlank;

	// Buffer
	var $_arrRow;
	var $_arrHidden;
	var $_arrSubmit;
	var $_loadedInteractiveTool;
	var $_loadedMceTool;
	var $_thumbnailer;
	var $_thumbBaseImage;
	

	/**
	 * CnnFormH::CnnFormH()
	 * Constructor of the class.
	 * 
	 * @param string $table database table name.
	 * @param string $extQuery extra MySQL query after basic select query
	 * 								such as WHERE, ORDER BY, and GROUP clause.
	 * @access public. 
	 **/
	function CnnFormH ($table, $extQuery = "")
	{
		$this->_table = $table;
		$this->_extQuery = $extQuery;
		$this->_fieldSelect = array();
		$this->_formId = md5($table.$extQuery);
		
		//Load Configuration from configuration file.
		require ("CnnFormH.conf.php");
		
		//Set form property based on loaded form configuration.
		$this->_formProp = $defFormProp;
		$this->_tableWidth = $defTableWidth;
		$this->_tableProp = $defTableProp;
		$this->_tableBgColor = $defTableBgColor;
		$this->_titleCss = $defTitleCss;
		$this->_titleBgColor = $defTitleBgColor;
		$this->_titleAlign = $defTitleAlign;
		$this->_contentCss = $defContentCss;
		$this->_contentBgColor = $defContentBgColor;
		$this->_contentAlign = $defContentAlign;
		$this->_submitCss = $defSubmitCss;
		$this->_submitBgColor = $defSubmitBgColor;
		$this->_submitAlign = $defSubmitAlign;
		//$this->_editorImagePath = $defEditorImagePath;
		//$this->_mceImagePath = $defDirImageMCE;
		//$this->_mceImageURL = $defURLImageMCE;
		//$this->_editorCSSPath = $defEditorCSSPath;
		$this->_inputBlank = $inputBlank;
		$this->_arrRow = array();
		$this->_arrHidden = array();
		$this->_arrSubmit = array();
		$this->_loadedInteractiveTool = false;
		$this->_thumbnailer = false;
		$this->_thumbBaseImage = '';
	} 

	/**
	 * CnnFormH::setFormId()
	 * Set form unique identity as the name of the form.
	 * 
	 * @param string $formId form unique identity.
	 * @access public.
	 * @see CnnFormH::CnnFormH to see how the constructor create the form id automaticly. 
	 **/
	function setFormId ($formId)
	{
		$this->_formId = $formId;
	} 

	/**
	 * CnnFormH::setTableWidth()
	 * Set width of the table which contain forms component. Table would have 2 columns, one for
	 * 								title column and one for input field column.
	 * 
	 * @param string $tableWidth table width in decimal length or percentage.
	 * @param string $titleWidth title column width in decimal length or percentage.
	 * @param string $contentWidth content column width in decimal length or percentage.
	 * @access public. 
	 **/
	function setTableWidth ($tableWidth, $titleWidth, $contentWidth)
	{
		for($i = 0; $i < func_num_args(); $i++) {
			$this->_tableWidth[$i] = func_get_arg($i);
		} 
	} 

	/**
	 * CnnFormH::setTableProp()
	 * Set table property.
	 * 
	 * @param string $tableProp extra property of the table except width and bgcolor.
	 * 									For example, "cellpadding=\"2\" cellspacing=\"1\". 
	 * @access public.
	 **/
	function setTableProp ($tableProp)
	{
		$this->_tableProp = $tableProp;
	} 

	/**
	 * CnnFormH::setTableBgColor()
	 * Set table background color.
	 * 
	 * @param string $tableBgColor table background color.  
	 * @access public. 
	 **/
	function setTableBgColor ($tableBgColor)
	{
		$this->_tableBgColor = $tableBgColor;
	} 

	/**
	 * CnnFormH::setFormProp()
	 * Set form property.
	 * 
	 * @param string $formProp form property except name.
	 * 									For example, "action=\"\" method=\"post\" enctype=\"multipart/form-data\"".
	 * 									Method property must be "post".
 	 * @access public.
	 **/
	function setFormProp ($formProp)
	{
		$this->_formProp = $formProp;
	} 

	/**
	 * CnnFormH::setColumnCss()
	 * Set column CSS class.
	 * 
	 * @param string $titleCss CSS class name for title column.
	 * @param string $contentCss CSS class name for content column.
	 * @access public.
	 **/
	function setColumnCss ($titleCss = "", $contentCss = "")
	{
		if (!empty($titleCss)) {
			$this->_titleCss = $titleCss;
		} 
		if (!empty($contentCss)) {
			$this->_contentCss = $contentCss;
		} 
	} 

	/**
	 * CnnFormH::setColumnBgColor()
	 * Set column background color.
	 * 
	 * @param string $titleBgColor background color for title column.
	 * @param string $contentBgColor background color for content column.
	 * @access public.
	 **/
	function setColumnBgColor ($titleBgColor = "", $contentBgColor = "")
	{
		if (!empty($titleBgColor)) {
			$this->_titleBgColor = $titleBgColor;
		} 
		if (!empty($contentBgColor)) {
			$this->_contentBgColor = $contentBgColor;
		} 
	} 

	/**
	 * CnnFormH::setColumAlign()
	 * Set column text alignment.
	 * 
	 * @param string $titleAlign set text alignment for title column.
	 * @param string $contentAlign set text alignment for content column.
	 * @access public.
	 **/
	function setColumAlign ($titleAlign = "", $contentAlign = "")
	{
		if (!empty($titleAlign)) {
			$this->_titleAlign = $titleAlign;
		} 
		if (!empty($contentAlign)) {
			$this->_contentAlign = $contentAlign;
		} 
	} 

	/**
	 * CnnFormH::setSubmitProp()
	 * Set row property where submit button located.
	 * 
	 * @param string $submitAlign text alignment for submit row.
	 * @param string $submitCss CSS class  for submit row.
	 * @param string $submitBgColor bacground color for submit row.
	 * @access public.
	 **/
	function setSubmitProp ($submitAlign = "", $submitCss = "", $submitBgColor = "")
	{
		if (!empty($submitAlign)) {
			$this->_submitAlign = $submitAlign;
		} 
		if (!empty($submitCss)) {
			$this->_submitCss = $submitCss;
		} 
		if (!empty($submitBgColor)) {
			$this->_submitBgColor = $submitBgColor;
		} 
	} 

	/**
	 * CnnFormH::setImagePath()
	 * Set image upload directory path.
	 * 
	 * @param string $imagePath image upload directory path.
	 * @access public.
	 **/
	function setImagePath ($imagePath)
	{
		$this->_imagePath = $imagePath;
	}

	/**
	 * CnnFormH::retCellTag()
	 * 
	 * 
	 * @param $align
	 * @param $bgColor
	 * @param $prop
	 * @param $css
	 * @access private
	 **/
	function retCellTag($align, $bgColor, $prop, $css)
	{
		$cellTag = "";
		if (!empty($this->_tableWidth[2]) ) {
			$cellTag .= " width=\"". $this->_tableWidth[2] ."\"";
		}
		if (!empty($align)) {
			$cellTag .= " align=\"" . $align . "\"";
		} elseif (!empty($this->_contentAlign)) {
			$cellTag .= " align=\"" . $this->_contentAlign . "\"";
		} 
		if (!empty($bgColor)) {
			$cellTag .= " bgcolor=\"" . $bgColor . "\"";
		} elseif (!empty($this->_contentBgColor)) {
			$cellTag .= " bgcolor=\"" . $this->_contentBgColor . "\"";
		} 
		if (!empty($prop)) {
			$cellTag .= " " . $prop;
		} 
		if (!empty($css)) {
			$cellTag .= " id=\"" . $css . "\"";
		} elseif (!empty($this->_contentCss)) {
			$cellTag .= " id=\"" . $this->_contentCss . "\"";
		} 
		return $cellTag;
	} 

	function retInputTag($inputProp, $inputCss)
	{
		$inputTag = "";
		if (!empty($inputProp)) {
			$inputTag .= " " . $inputProp;
		} 
		if (!empty($inputCss)) {
			$inputTag .= " id=\"" . $inputCss . "\"";
		} 
		if(!empty($inputCss)) {
		
		}
		return $inputTag;
	} 

	function getTitleTag()
	{
		$titleTag = "";
		if (!empty($this->_tableWidth[1]) ) {
			$titleTag .= " width=\"". $this->_tableWidth[1] ."\"";
		}
		if (!empty($this->_titleAlign)) {
			$titleTag .= " align=\"" . $this->_titleAlign . "\"";
		} 
		if (!empty($this->_titleBgColor)) {
			$titleTag .= " bgcolor=\"" . $this->_titleBgColor . "\"";
		} 
		if (!empty($this->_titleCss)) {
			$titleTag .= " id=\"" . $this->_titleCss . "\"";
		} 
		return $titleTag;
	} 

	function getSubmitTag()
	{
		$submitTag = "";
		if (!empty($this->_submitAlign)) {
			$submitTag .= " align=\"" . $this->_submitAlign . "\"";
		} 
		if (!empty($this->_submitBgColor)) {
			$submitTag .= " bgcolor=\"" . $this->_submitBgColor . "\"";
		} 
		if (!empty($this->_submitCss)) {
			$submitTag .= " id=\"" . $this->_submitCss . "\"";
		} 
		return $submitTag;
	} 

	function addSpanText ($text, $css = "", $align = "", $bgColor = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "spanText", "cellTag" => $cellTag, "text" => $text);
		array_push($this->_arrRow, $arrBuff);
	} 

	function addText ($title, $fieldName, $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "text", "title" => $title, "fieldName" => $fieldName, "cellTag" => $cellTag);
		array_push($this->_arrRow, $arrBuff);
		$this->_inputBlank = false;
	} 

	function addLink ($title, $fieldName, $link, $fieldId, $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "link", "title" => $title, "fieldName" => $fieldName, "link" => $link, "fieldId" => $fieldId, "cellTag" => $cellTag);
		array_push($this->_arrRow, $arrBuff);
		$this->_inputBlank = false;
	} 
	// function for Add Input;
	function addInputText ($title, $fieldName, $validation="", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputText", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	} 

	function addInputTextarea ($title, $fieldName,$validation="", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputTextarea", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	} 

	function addInputEditor ($title, $fieldName,$validation="", $width = "624", $height = "300", $imagePath = "")
	{
		if (empty($imagePath)) {
			$imagePath = $this->_editorImagePath;
		}
		$arrBuff = array("type" => "inputEditor", "title" => $title, "fieldName" => $fieldName, "width" => $width, "height" => $height, "imagePath" => $imagePath,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	}
	

	function addMceTool ($title, $fieldName, $width = "100%", $height = "150", $dirStock="", $dirStockURL="")
	{
		if (empty($dirStock)) {
			$dirStock = $this->_mceImagePath;
		}
		if (empty($dirStockURL)) {
			$dirStockURL = $this->_mceImageURL;
		}
		$arrBuff = array("type" => "inputMceTool", "dirStock"=>$dirStock, "dirStockURL"=>$dirStockURL, "title" => $title, "fieldName" => $fieldName, "width" => $width, "height" => $height);
		array_push($this->_arrRow, $arrBuff);
	} 
	
	function addMceToolAgain ($title, $fieldName, $width = "100%", $height = "150" , $dirStock="", $dirStockURL="")
	{
		if (empty($dirStock)) {
			$dirStock = $this->_mceImagePath;
		}
		if (empty($dirStockURL)) {
			$dirStockURL = $this->_mceImageURL;
		}
		$arrBuff = array("type" => "inputMceToolAgain", "dirStock"=>$dirStock, "dirStockURL"=>$dirStockURL, "title" => $title, "fieldName" => $fieldName, "width" => $width, "height" => $height);
		array_push($this->_arrRow, $arrBuff);
	} 	

	function addInputSelect ($title, $fieldName, $arrValue,$validation="", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputSelect", "title" => $title, "fieldName" => $fieldName, "arrValue" => $arrValue, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	} 

	function addInputImage ($title, $fieldName, $imagePath, $autoRename =  true, $comp = false, $thumb = false,$validation="", $ukuran = "", $kecil = "", $zoom = "", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{

		
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputImage", "title" => $title, "fieldName" => $fieldName, "imagePath" => $imagePath, "autoRename" => $autoRename, "comp" => $comp, "thumb" => $thumb, "ukuran" => $ukuran, "kecil" => $kecil, "zoom" => $zoom, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	} 

	function addInputImageThumb ($title, $fieldName, $imagePath,$validation="", $imageProp = "", $autoRename =  true, $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputImageThumb", "title" => $title, "fieldName" => $fieldName, "imagePath" => $imagePath, "imageProp" => $imageProp, "autoRename" => $autoRename, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	} 
	
	function actThumbnailer ($baseImage = "")
	{
		$this->_thumbBaseImage = $baseImage;
		$this->_thumbnailer = true;
	}

	function addInputDate ($title, $fieldName,$validation="", $inputTag = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "inputDate", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	} 
	
	function addInputDateTime ($title, $fieldName,$validation="", $inputTag = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "inputDateTime", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	}

	function addHiddenValue ($fieldName, $value)
	{
		$arrBuff = array("fieldName" => $fieldName, "value"=>$value);
		array_push($this->_arrHidden, $arrBuff);
	}

	function addInputFile ($title, $fieldName, $filePath, $autoRename =  true,$validation="", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{

		
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputFile", "title" => $title, "fieldName" => $fieldName, "filePath" => $filePath, "autoRename" => $autoRename, "inputTag" => $inputTag, "cellTag" => $cellTag,"validation" => $validation);
		array_push($this->_arrRow, $arrBuff);
	}

	function addSubmit ($type, $title, $submitCss = "", $submitName, $submitProp = "")
	{
		$submitTag = "";
		if (!empty($submitProp)) {
			$submitTag .= " " . $submitProp;
		} 
		if (!empty($submitCss)) {
			$submitTag .= " id=\"" . $submitCss . "\"";
		} 
		$arrBuff = array("type" => $type, "title" => $title, "submitName" => $submitName, "submitTag" => $submitTag);
		array_push($this->_arrSubmit, $arrBuff);
	} 

	function addSubmitAdd ($title = "", $submitCss = "", $submitName = "", $submitProp = "")
	{
		if (empty($title)) {
			$title = "Add";
		} 
		if (empty($submitName)) {
			$submitName = "submit_add";
		} 
		$this->addSubmit("add", $title, $submitCss, $submitName, $submitProp);
		$this->_inputBlank = true; 
		
		// Execute Add Action
		if (($_POST['form_id'] == $this->_formId) && ($_POST['form_action'] == "add")) {
			$strInsert = "";
			$strValue = "";
			$c = 0;
			//print_r($this->_arrRow);
			foreach ($this->_arrRow as $row) {
				if (preg_match("/^input(\w+)$/", $row['type'], $rowMatch)) {
					if (($rowMatch[1] == "Image") || ($rowMatch[1] == "ImageThumb")) {
						if (!empty($_FILES[$row['fieldName']]['name'])) {
							if (is_uploaded_file($_FILES[$row['fieldName']]['tmp_name'])) {
								if ($row['autoRename']) {
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
									$fileName = $ext[1] . "_".substr(uniqid(""), -6) . $ext[2];
								} else {
									$fileName = $_FILES[$row['fieldName']]['name'];
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
								}
								if (move_uploaded_file($_FILES[$row['fieldName']]['tmp_name'], $row['imagePath'] . $fileName)) {
									$strInsert .= "`" . $row['fieldName'] . "`, ";
									$strValue .= "'" . $fileName . "', ";
									if ($this->_thumbnailer) {
										$a = new Thumbnail($row['imagePath'] . $fileName, $this->_thumbBaseImage, $row['imagePath'] . 'thumbnail/'. $fileName, 85, '');
										$a->create();
									}
									
									if ($row['comp']) {
										if(strtolower($ext[2])=='.jpg' || strtolower($ext[2])=='.png' || strtolower($ext[2])=='.jpeg' || strtolower($ext[2])=='.gif') {
											createthumb($row['imagePath'] . $fileName,$row['imagePath']. $fileName,$row['ukuran'],$row['ukuran']);
										} 
									}
									
									if ($row['thumb']) {
										if(strtolower($ext[2])=='.jpg' || strtolower($ext[2])=='.png' || strtolower($ext[2])=='.jpeg' || strtolower($ext[2])=='.gif') {
											createthumb($row['imagePath'] . $fileName,$row['imagePath']."zoom_".$fileName,$row['zoom'],$row['zoom']);
											createthumb($row['imagePath'] . $fileName,$row['imagePath']. $fileName,$row['kecil'],$row['kecil']);
										} 
									}
									
								} else {
									die("Failed to Upload Image. Query wasn't executed yet.");
								} 
							} else {
								die("Failed to Upload Image. Query wasn't executed yet.");
							} 
						} 
					} elseif ($rowMatch[1] == "Date") {
						$date = $_POST['yyyy'.$c] . "-" . $_POST['mm'.$c] . "-" . $_POST['dd'.$c];
						$strInsert .= "`" . $row['fieldName'] . "`, ";
						$strValue .= "'" . $date . "', ";
					} elseif ($rowMatch[1] == "DateTime") {
						$dateTime = $_POST['yyyy'.$c] ."-". $_POST['mm'.$c] ."-". $_POST['dd'.$c] ." ". $_POST['hh'.$c] .":". $_POST['ii'.$c] .":". $_POST['ss'.$c];
						$strInsert .= "`" . $row['fieldName'] . "`, ";
						$strValue .= "'" . $dateTime . "', ";
					} elseif ($rowMatch[1] == "Editor") {
						$strInsert .= "`" . $row['fieldName'] . "`, ";
						$editField = "editor_".$row['fieldName'];
						$strValue .= "'" . $_POST[$editField] . "', ";
					} elseif ($rowMatch[1] == "InteractiveTool") {
						$strInsert .= "`" . $row['fieldName'] . "`, ";
						$editField = "inter_".$row['fieldName'];
						$strValue .= "'" . $_POST[$editField] . "', ";
					} elseif($rowMatch[1]=="UploadFile"){
						if (!empty($_FILES[$row['fieldName']]['name'])){
							if (is_uploaded_file($_FILES[$row['fieldName']]['tmp_name'])){
								if ($row['autoRename']) {
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
									$fileName = $ext[1] . "_".substr(uniqid(""), -6) . $ext[2];
								} else {
									$fileName = $_FILES[$row['fieldName']]['name'];
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
								}
								chmod($row['filePath'],766);
								if (move_uploaded_file($_FILES[$row['fieldName']]['tmp_name'], $row['filePath'] . $fileName)) {
									$strInsert .= "`" . $row['fieldName'] . "`, ";
									$strValue .= "'" . $fileName . "', ";
								} else {
									die("Failed to Upload File. Query wasn't executed yet.");
								} 
							} else {
								die("Failed to Upload File. Query wasn't executed yet.");
							}
						}
					} else {
						$strInsert .= "`" . $row['fieldName'] . "`, ";
						$strValue .= "'" . $_POST[$row['fieldName']] . "', ";
					} 
				}
				$c++; 
			}
			
			foreach ($this->_arrHidden as $rowHidden) {
				$strInsert .= "`" . $rowHidden['fieldName'] . "`, ";
				$strValue .= "'" . $rowHidden['value'] . "', ";
			} 
			//print_r($this->_arrHidden);
			$insert = substr($strInsert, 0, -2);
			$value = substr($strValue, 0, -2);
			$query = "INSERT INTO `" . $this->_table . "` (" . $insert . ") VALUES (" . $value . ")";
			mysql_query($query) or die("Query Failed : failed to perform add action." . mysql_error());
		} 
	} 

	function addSubmitUpdate ($title = "", $submitCss = "", $submitName = "", $submitProp = "")
	{
		if (empty($title)) {
			$title = "Save";
		} 
		if (empty($submitName)) {
			$submitName = "submit_update";
		} 
		$this->addSubmit("update", $title, $submitCss, $submitName, $submitProp);
		$this->_inputBlank = false; 
		// Execute Update Action
		if (($_POST['form_id'] == $this->_formId) && ($_POST['form_action'] == "update") ) {
//		if (isset($_POST[$submitName]) ) {
			$strUpdate = "";
			$c = 0;
			foreach ($this->_arrRow as $row) {
				if (preg_match("/^input(\w+)$/", $row['type'], $rowMatch)) {
					//echo $rowMatch[1];
					if (($rowMatch[1] == "Image") || ($rowMatch[1] == "ImageThumb")) {
						if ($_FILES[$row['fieldName']]['name'] == "\\\"") {
							$delResult = mysql_query("SELECT `" . $row['fieldName'] . "` FROM `" . $this->_table . "` " . $this->_extQuery) or die("Query Failed: Failed to fetch filename");
							$delFile = mysql_fetch_row($delResult);
							@unlink($row['imagePath'] . $delFile[0]);
							if ($this->_thumbnailer) {
								@unlink($row['imagePath'] . 'thumbnail/' . $delFile[0]);
							}
							if ($row['thumb']) {
								@unlink($row['imagePath'] . 'zoom_' . $delFile[0]);
							}
							$strUpdate .= "`" . $row['fieldName'] . "` = '', ";
						} elseif (!empty($_FILES[$row['fieldName']]['name'])) {
							if (is_uploaded_file($_FILES[$row['fieldName']]['tmp_name'])) {
								if ($row['autoRename']) {
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
									$fileName = $ext[1] . "_".substr(uniqid(""), -6) . $ext[2];
								} else {
									$fileName = $_FILES[$row['fieldName']]['name'];
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
								}
								echo $_FILES[$row['fieldName']]['tmp_name'];
								if (move_uploaded_file($_FILES[$row['fieldName']]['tmp_name'], $row['imagePath'] . $fileName)) {
									$strUpdate .= "`" . $row['fieldName'] . "` = '" . $fileName . "', ";
									if ($this->_thumbnailer) {
										$a = new Thumbnail($row['imagePath'] . $fileName, $this->_thumbBaseImage, $row['imagePath'] . 'thumbnail/'. $fileName, 85, '');
										$a->create();
									}
									
									if ($row['comp']) {
										if(strtolower($ext[2])=='.jpg' || strtolower($ext[2])=='.png' || strtolower($ext[2])=='.jpeg' || strtolower($ext[2])=='.gif') {
											createthumb($row['imagePath'] . $fileName,$row['imagePath']. $fileName,$row['ukuran'],$row['ukuran']);
										} 
									}
									
									if ($row['thumb']) {
										if(strtolower($ext[2])=='.jpg' || strtolower($ext[2])=='.png' || strtolower($ext[2])=='.jpeg' || strtolower($ext[2])=='.gif') {
											createthumb($row['imagePath'] . $fileName,$row['imagePath']."zoom_".$fileName,$row['zoom'],$row['zoom']);
											createthumb($row['imagePath'] . $fileName,$row['imagePath']. $fileName,$row['kecil'],$row['kecil']);
										} 
									}							
									$delResult = mysql_query("SELECT `" . $row['fieldName'] . "` FROM `" . $this->_table . "` " . $this->_extQuery) or die("Query Failed: Failed to fetch filename");
									$delFile = mysql_fetch_row($delResult);
									@unlink($row['imagePath'] . $delFile[0]);
									if ($this->_thumbnailer) {
										@unlink($row['imagePath'] . 'thumbnail/' . $delFile[0]);
									}
									if ($row['thumb']) {
										@unlink($row['imagePath'] . 'zoom_' . $delFile[0]);
									}
									
								} else {
									die("Failed to Upload Image. Query wasn't executed yet.");
								} 
							} else {
								die("Failed to Upload Image. Query wasn't executed yet.");
							} 
						} 
					} elseif ($rowMatch[1] == "Date") {
						$date = $_POST['yyyy'.$c] . "-" . $_POST['mm'.$c] . "-" . $_POST['dd'.$c];
						$strUpdate .= "`" . $row['fieldName'] . "` = '" . $date . "', ";
					} elseif ($rowMatch[1] == "DateTime") {
						$dateTime = $_POST['yyyy'.$c] ."-". $_POST['mm'.$c] ."-". $_POST['dd'.$c] ." ". $_POST['hh'.$c] .":". $_POST['ii'.$c] .":". $_POST['ss'.$c];
						$strUpdate .= "`" . $row['fieldName'] . "` = '" . $dateTime . "', ";
					} elseif ($rowMatch[1] == "Editor") {
						$editField = "editor_".$row['fieldName'];
						$strUpdate .= "`" . $row['fieldName'] . "` = '" . $_POST[$editField] . "', "; 
					} elseif ($rowMatch[1] == "InteractiveTool") {
						$interField = "inter_".$row['fieldName'];
						$strUpdate .= "`" . $row['fieldName'] . "` = '" . $_POST[$interField] . "', "; 
					} elseif($rowMatch[1]=="File"){
						if ($_FILES[$row['fieldName']]['name'] == "\\\"") {
							$delResult = mysql_query("SELECT `" . $row['fieldName'] . "` FROM `" . $this->_table . "` " . $this->_extQuery) or die("Query Failed: Failed to fetch filename");
							$delFile = mysql_fetch_row($delResult);
							@unlink($row['filePath'] . $delFile[0]);
							$strUpdate .= "`" . $row['fieldName'] . "` = '', ";
						} elseif (!empty($_FILES[$row['fieldName']]['name'])) {
							if (is_uploaded_file($_FILES[$row['fieldName']]['tmp_name'])) {
								if ($row['autoRename']) {
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
									$fileName = $ext[1] . "_".substr(uniqid(""), -6) . $ext[2];
								} else {
									$fileName = $_FILES[$row['fieldName']]['name'];
									preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'], $ext);
								}
								//echo $_FILES[$row['fieldName']]['tmp_name'];
								if (move_uploaded_file($_FILES[$row['fieldName']]['tmp_name'], $row['filePath'] . $fileName)) {
									$strUpdate .= "`" . $row['fieldName'] . "` = '" . $fileName . "', ";
									$delResult = mysql_query("SELECT `" . $row['fieldName'] . "` FROM `" . $this->_table . "` " . $this->_extQuery) or die("Query Failed: Failed to fetch filename");
									$delFile = mysql_fetch_row($delResult);
									@unlink($row['filePath'] . $delFile[0]);
									
								} else {
									die("Failed to Upload file. Query wasn't executed yet.");
								} 
							} else {
								die("Failed to Upload File. Query wasn't executed yet.");
							} 
						}
					}else {
						$strUpdate .= "`" . $row['fieldName'] . "` = '" . $_POST[$row['fieldName']] . "', ";
					} 
				} 
				$c++; 				
			}
			foreach ($this->_arrHidden as $rowHidden) {
				$strUpdate .= "`" . $rowHidden['fieldName'] . "` = '" . $rowHidden['value'] . "', ";
			}
			$set = substr($strUpdate, 0, -2);
			$query = "UPDATE `" . $this->_table . "` SET " . $set . " " . $this->_extQuery;
			mysql_query($query) or die("Query Failed : failed to perform update action." . mysql_error());
		} 
	} 

	function addSubmitReset ($title = "", $submitCss = "", $submitName = "", $submitProp = "")
	{
		if (empty($title)) {
			$title = "Reset";
		} 
		if (empty($submitName)) {
			$submitName = "submit_reset";
		} 
		$this->addSubmit("reset", $title, $submitCss, $submitName, $submitProp);
	} 

	function addSubmitNone ($title = "", $submitCss = "", $submitName = "", $submitProp = "")
	{
		if (empty($title)) {
			$title = "None";
		} 
		if (empty($submitName)) {
			$submitName = "submit_none";
		} 
		$this->addSubmit("none", $title, $submitCss, $submitName, $submitProp);
	} 

	function getForm()
	{
		$buffer = "\n<!-- Start of CnnFormH -->";
		$buffer .= "\n\t<form class=\"nice\" id=\"".$this->_formId."\"  name=\"".$this->_formId."\"" . $this->_formProp . ">";
		//$buffer .= "\n\t\t<table width=\"" . $this->_tableWidth[0] . "\" bgcolor=\"" . $this->_tableBgColor . "\"";
		$buffer .= "<ul>";
		if (!empty($this->_tableProp)) {
			//$buffer .= " " . $this->_tableProp;
		} 
		//$buffer .= ">";
		if (!$this->_inputBlank) {
			$arrFieldSelect = array();
			foreach ($this->_arrRow as $row) {
				if (array_key_exists("fieldName", $row)) {
					if (!in_array($row['fieldName'], $arrFieldSelect)) {
						array_push($arrFieldSelect, $row['fieldName']);
					} 
				} 
				if (array_key_exists("fieldId", $row)) {
					if (!in_array($row['fieldId'], $arrFieldSelect)) {
						array_push($arrFieldSelect, $row['fieldId']);
					} 
				} 
			} 
			$strFieldSelect = implode(", ", $arrFieldSelect);
			$querySQL = "SELECT " . $strFieldSelect . " FROM `" . $this->_table . "` " . $this->_extQuery;
			$resultSQL = mysql_query($querySQL) or die ("Error : MySQL Query Failed on fetching data from table. Please Check Your Script. \n" . mysql_error());
			$valueSQL = mysql_fetch_assoc($resultSQL);
			if (is_array($valueSQL)) {
				extract($valueSQL);
			} 
		} 
		
		$c = 0;
		foreach ($this->_arrRow as $row) {
			switch ($row['type']) {
				case 'spanText':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >&nbsp;" . $row['text'] . "</li>";
					break;
				case 'text':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\">".$row['title']."</label>";
					$buffer .= "\n\t\t\t\t<div><input id=\"element_".$c."\" name=\"".$row['fieldName']."\" class=\"element text medium ".$row['validation']."\" type=\"text\"  value=\"".$$row['fieldName']."\"/></div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'link':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\">".$row['title']."</label>";
					$buffer .= "\n\t\t\t\t<a href=\"" . $row['link'] . "?" . $row['fieldId'] . "=" . $$row['fieldId'] . "\">" . $$row['fieldName'] . "</a>>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputText':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div><input  name=\"".$row['fieldName']."\" ".$row['inputTag']." class=\"element text medium ".$row['validation']."\" type=\"text\" id=\"element_".$c."\"";
					if (!$this->_inputBlank) {
						$buffer .= " value=\"" . htmlentities($$row['fieldName']) . "\"";
					} 
					$buffer .= "/>\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;             
                
				case 'inputTextarea':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div><textarea name=\"" . $row['fieldName'] . "\" id=\"element_".$c."\"" . $row['inputTag'] . " class=\"element textarea medium ".$row['validation']."\">";
					if (!$this->_inputBlank) {
						$buffer .= $$row['fieldName'];
					} 
					$buffer .= "</textarea>\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputMceToolAgain':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					?>
					<script language="javascript" type="text/javascript" src="fckeditor/fckeditor.js"></script>
					<?php
					$buffer .= "\n" ;
					$sBasePath=dirname($_SERVER['PHP_SELF']);
					$oFCKeditor = new FCKeditor($row['fieldName']) ;
					$oFCKeditor->BasePath	= $sBasePath."/fckeditor/";
					$oFCKeditor->BasePath	= $sBasePath ;
					$oFCKeditor->Value		= '' ;
					$oFCKeditor->ToolbarSet = "Basic_Plus";
					if (!$this->_inputBlank) {
						$oFCKeditor->Value	= $$row['fieldName'];
					}
					$buffer .= $oFCKeditor->CreateHtml();
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputMceTool':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					?>
					<script language="javascript" type="text/javascript" src="fckeditor/fckeditor.js"></script>
					<?php
					$buffer .= "\n"; //. ob_get_contents();
					$sBasePath=dirname($_SERVER['PHP_SELF']);
					
					//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
					
					$oFCKeditor = new FCKeditor($row['fieldName']) ;
					$oFCKeditor->BasePath	= $sBasePath."/fckeditor/";
					$oFCKeditor->ToolbarSet = "Basic_Plus";
					$oFCKeditor->Value		= '' ;
					//$oFCKeditor->Width		= $row["width"];
					//$oFCKeditor->Width		= $row["height"];
					if (!$this->_inputBlank) {
						$oFCKeditor->Value	= $$row['fieldName'];
					}
					$buffer .= $oFCKeditor->CreateHtml();
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputSelect':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					$buffer .= "\n\t\t\t\t\t<select class=\"element select medium ".$row['validation']."\" name=\"" . $row['fieldName'] . "\" id=\"element_".$c."\"" . $row['inputTag'] . ">";
					for ($i = 0; $i < count($row['arrValue']); $i = $i + 2) {
						$buffer .= "\n\t\t\t\t\t\t<option value=\"" . htmlentities($row['arrValue'][$i]) . "\"";
						if (!$this->_inputBlank && ($row['arrValue'][$i] == $$row['fieldName'])) {
							$buffer .= " selected";
						} 
						$buffer .= ">" . $row['arrValue'][$i + 1] . "</option>";
					} 
					$buffer .= "\n\t\t\t\t\t</select>";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputImage':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					if (!$this->_inputBlank && !empty($$row['fieldName']) && file_exists($row['imagePath'] . $$row['fieldName'])) {
						$buffer .= "\n\t\t\t\t\t&nbsp;" . $$row['fieldName'] . "</br>";
					} 
					$buffer .= "\n\t\t\t\t\t<input name=\"" . $row['fieldName'] . "\" type=\"file\" id=\"element_".$c."\"" . $row['inputTag'] . " class=\"element file ".$row['validation']."\">";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputImageThumb':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					if (!$this->_inputBlank && !empty($$row['fieldName']) && file_exists($row['imagePath'] . $$row['fieldName'])) {
						$buffer .= "\n\t\t\t\t\t\t\t<img src=\"" . $row['imagePath'] . $$row['fieldName'] . "\"" . $row['imageProp'] . ">";
					} 
					$buffer .= "\n\t\t\t\t\t\t\t<input class=\"element file ".$row['validation']."\" id=\"element_".$c."\" name=\"" . $row['fieldName'] . "\" type=\"file\" id=\"" . $row['fieldName'] . "\"" . $row['inputTag'] . ">";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputDate':
					if ($this->_inputBlank) {
						$dd = date('d');
						$mm = date('m');
						$yyyy = date('Y');
					} else {
						$yyyy = substr($$row['fieldName'], 0, 4);
						$mm = substr($$row['fieldName'], 5, 2);
						$dd = substr($$row['fieldName'], 8, 2);
					} 
					
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					$buffer .= "\n\t\t\t\t<span>";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_1\" name=\"dd".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$dd."\" type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_1\">DD</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_2\" name=\"mm".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$mm."\" type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_2\">MM</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
	 				$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_3\" name=\"yyyy".$c."\" class=\"element text ".$row['validation']."\" size=\"4\" maxlength=\"4\" value=\"".$yyyy."\" type=\"text\"> ";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_3\">YYYY</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
	
					$buffer .= "\n\t\t\t\t<span id=\"calendar_".$c."\"> ";
					$buffer .= "\n\t\t\t\t<img id=\"cal_img_".$c."\" class=\"datepicker\" src=\"images/calendar.gif\" alt=\"Pick a date.\">";	
					$buffer .= "\n\t\t\t\t</span>";
					$buffer .= "\n\t\t\t\t<script type=\"text/javascript\"> ";
					$buffer .= "\n\t\t\t\tCalendar.setup({";
					$buffer .= "\n\t\t\t\tinputField	 : \"element_".$c."_3\",";
					$buffer .= "\n\t\t\t\tbaseField    : \"element_".$c."\",";
					$buffer .= "\n\t\t\t\tdisplayArea  : \"calendar_".$c."\",";
					$buffer .= "\n\t\t\t\tbutton		 : \"cal_img_".$c."\",";
					$buffer .= "\n\t\t\t\tifFormat	 :\"%Y-%m-%d\",";
					$buffer .= "\n\t\t\t\tonSelect	 : selectEuropeDate,";
					$buffer .= "\n\t\t\t\tdate: '".$dd."/".$mm."/".$yyyy."'});";
					$buffer .= "\n\t\t\t\t</script> ";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputDateTime':
					if ($this->_inputBlank) {
						$dd = date('d');
						$mm = date('m');
						$yyyy = date('Y');
						$hh = date('H');
						$ii = date('i');
						$ss = date('s');
					} else {
						$yyyy = substr($$row['fieldName'], 0, 4);
						$mm = substr($$row['fieldName'], 5, 2);
						$dd = substr($$row['fieldName'], 8, 2);
						$hh = substr($$row['fieldName'], 11, 2);
						$ii = substr($$row['fieldName'], 14, 2);
						$ss = substr($$row['fieldName'], 17, 2);
					} 
					
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					$buffer .= "\n\t\t\t\t<span>";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_1\" name=\"dd".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$dd."\" type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_1\">DD</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_2\" name=\"mm".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$mm."\"  type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_2\">MM</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
	 				$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_3\" name=\"yyyy".$c."\" class=\"element text ".$row['validation']."\" size=\"4\" maxlength=\"4\" value=\"".$yyyy."\" type=\"text\"> ";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_3\">YYYY</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					
					$buffer .= "\n\t\t\t\t		<span> ";
					$buffer .= "\n\t\t\t\t			<input id=\"element_".$c."_4\" name=\"hh".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" type=\"text\" value=\"".$hh."\" maxlength=\"2\" value=\"\"/> : ";
					$buffer .= "\n\t\t\t\t			<label>HH</label> ";
					$buffer .= "\n\t\t\t\t		</span> ";
					$buffer .= "\n\t\t\t\t		<span> ";
					$buffer .= "\n\t\t\t\t			<input id=\"element_".$c."_5\" name=\"ii".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" type=\"text\" value=\"".$ii."\" maxlength=\"2\" value=\"\"/> : ";
					$buffer .= "\n\t\t\t\t			<label>MM</label> ";
					$buffer .= "\n\t\t\t\t		</span> ";
					$buffer .= "\n\t\t\t\t		<span> ";
					$buffer .= "\n\t\t\t\t			<input id=\"element_".$c."_6\" name=\"ss".$c."\" class=\"element text ".$row['validation']."\" size=\"2\" type=\"text\" value=\"".$ss."\" maxlength=\"2\" value=\"\"/> ";
					$buffer .= "\n\t\t\t\t			<label>SS</label> ";
					$buffer .= "\n\t\t\t\t		</span> ";
					
					$buffer .= "\n\t\t\t\t<span id=\"calendar_".$c."\"> ";
					$buffer .= "\n\t\t\t\t<img id=\"cal_img_".$c."\" class=\"datepicker\" src=\"images/calendar.gif\" alt=\"Pick a date.\">";	
					$buffer .= "\n\t\t\t\t</span>";
					$buffer .= "\n\t\t\t\t<script type=\"text/javascript\"> var d = new Date(1208758100000);";
					$buffer .= "\n\t\t\t\tCalendar.setup({";
					$buffer .= "\n\t\t\t\tinputField	 : \"element_".$c."_3\",";
					$buffer .= "\n\t\t\t\tbaseField    : \"element_".$c."\",";
					$buffer .= "\n\t\t\t\tdisplayArea  : \"calendar_".$c."\",";
					$buffer .= "\n\t\t\t\tbutton		 : \"cal_img_".$c."\",";
					$buffer .= "\n\t\t\t\tshowsTime		 : true,";
					$buffer .= "\n\t\t\t\tifFormat	 : \"%Y-%m-%d %H:%M:%S\",";
					$buffer .= "\n\t\t\t\tonSelect	 : selectEuropeDateTime,";
					$buffer .= "\n\t\t\t\tdate: d});";
					$buffer .= "\n\t\t\t\t</script> ";

					
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputFile':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					if (!$this->_inputBlank && !empty($$row['fieldName']) && file_exists($row['filePath'] . $$row['fieldName'])) {
						$buffer .= "\n\t\t\t\t\t&nbsp;" . $$row['fieldName'] . "</br>";
					} 
					$buffer .= "\n\t\t\t\t\t\t\t<input class=\"element file ".$row['validation']."\" id=\"element_".$c."\" name=\"" . $row['fieldName'] . "\" type=\"file\" id=\"" . $row['fieldName'] . "\"" . $row['inputTag'] . ">";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
			} // switch
			$c++;
		} 
		// Show Submit Button
		if (count($this->_arrSubmit) > 0) {
			$buffer .= "\n\t\t\t<li class=\"buttons\"> ";
			foreach ($this->_arrSubmit as $row) {
				if (($row['type'] == "update") || ($row['type'] == "add")) {
					$buttonType = "submit";
					$actionType = $row['type'];
				} elseif ($row['type'] == "reset") {
					$buttonType = "reset";
				} else {
					$buttonType = "none";
				} 
				$buffer .= "\n\t\t\t\t\t<input name=\"" . $row['submitName'] . "\" type=\"" . $buttonType . "\"" . $row['submitTag'] . " id=\"" . $row['submitName'] . "\" value=\"" . $row['title'] . "\">";
			} 
			$buffer .= "\n\t\t\t\t\t<input name=\"form_id\" type=\"hidden\" value=\"" . $this->_formId . "\">";
			if (!empty($actionType)) {
				$buffer .= "\n\t\t\t\t\t<input class=\"button_text\" name=\"form_action\" type=\"hidden\" value=\"" . $actionType . "\">";
			}
			
			$buffer .= "\n\t\t\t</li>";
		} 
		$buffer .= "\n\t\t</ul>";
		$buffer .="<script type=\"text/javascript\">";
		$buffer .= "\n				var valid3 = new Validation('".$this->_formId."',{useTitles:true});";
		$buffer .= "\n			</script>";
		$buffer .= "\n\t</form>";
		$buffer .= "\n<!-- End of CnnFormH -->\n";
		return $buffer;
	} 

	function printForm()
	{
		echo $this->getForm();
	} 

	function getArrRow()
	{
		echo "<br>ArrRow :<br><pre>";
		echo print_r($this->_arrRow);
		echo "</pre>";
	} 

	function getArrSubmit()
	{
		echo "<br>ArrSubmit<br><pre>";
		echo print_r($this->_arrSubmit);
		echo "</pre>";
	} 

	function getArrPost()
	{
		echo "<br>ArrPost<br><pre>";
		echo print_r($_POST);
		echo "</pre>";
	}

	function getArrFiles()
	{
		echo "<br>ArrPost<br><pre>";
		echo print_r($_FILES);
		echo "</pre>";
	}

} 

?>