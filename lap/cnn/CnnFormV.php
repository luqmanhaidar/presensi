<?php
/**
 * Easy Form Creator and Management Class for PHP, which support:
 * - MySQL Database
 * - CSS
 * - Site Pagination (Using CnnNav)
 * Copyright (C) 2003 Cristian Ade Candra
 * 
 * Version  0.1.1  2003-10-16
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
 * Source code home page: http://www.creezz.com/cnn/cnnformv/
 * Contact author at: mail@creezz.com
 * 
 * ChangeLog for version 0.0.1  2003-02-15
 * 0.0.1 first release
 *
 * ChangeLog for version 0.1.1  2003-10-15
 * Support page pagination using CnnNav
 */
?>
<?php 

require_once("CnnNav.php");

class CnnFormV extends CnnNav {
	// Database Property
	var $__table;
	var $__extQuery;
	var $__tableId;
	var $__useTransaction;

	// Form Property
	var $__formId;
	var $__formProp;
	var $__tableWidth;
	var $__tableProp;
	var $__tableBgColor;
	var $__titleCss;
	var $__titleBgColor;
	var $__titleAlign;
	var $__contentCss;
	var $__contentBgColor;
	var $__contentAlign;
	var $__submitCss;
	var $__submitBgColor;
	var $__submitAlign;
	var $__navCss;
	var $__navBgColor;
	var $__navAlign;
	var $__navRow;
 
	// Buffer
	var $__arrColumn;
	var $__arrSubmit;
	var $__arrWidth;
	var $__arrNav;
	var $__thumbnailer;
	var $__thumbBaseImage;
	
	function CnnFormV ($table, $tableId, $extQuery = "")
	{
		$this->__table = $table;
		$this->__extQuery = $extQuery;
		$this->__useTransaction = $useTransaction;
		$this->__tableId = $tableId;
		$this->__formId = md5($table);
				
		//Load Configuration
		require("CnnFormV.conf.php");
		
		//Set Form Property Based On General Form Configuration		
		$this->__formProp = $defFormProp;
		$this->__tableWidth = $defTableWidth;
		$this->__tableProp = "id=\"".$this->__formId."_0\"";//$defTableProp;
		$this->__tableBgColor = $defTableBgColor;
		$this->__titleCss = $defTitleCss;
		$this->__titleBgColor = $defTitleBgColor;
		$this->__titleAlign = $defTitleAlign;
		$this->__contentCss = $defContentCss;
		$this->__contentBgColor = $defContentBgColor;
		$this->__contentAlign = $defContentAlign;
		$this->__submitCss = $defSubmitCss;
		$this->__submitBgColor = $defSubmitBgColor;
		$this->__submitAlign = $defSubmitAlign;
		$this->__navCss = $defNavCss;
		$this->__navBgColor = $defNavBgColor;
		$this->__navAlign = $defNavAlign;
		$this->__navRow = $defNavRow;
		$this->__arrColumn = array();
		$this->__arrSubmit = array();
		$this->__arrWidth = array();
		$this->__arrNav = array();
		$this->__thumbnailer = false;
		$this->__thumbBaseImage = '';
	} 

	function setFormId ($formId)
	{
		$this->_formId = $formId;
	} 

	function setTableWidth ($tableWidth)
	{
		$this->__tableWidth = $tableWidth; 
	} 

	function setTableProp ($tableProp)
	{
		$this->_tableProp = $tableProp;
	} 

	function setTableBgColor ($tableBgColor)
	{
		$this->_tableBgColor = $tableBgColor;
	} 

	function setFormProp ($formProp)
	{
		$this->_formProp = $formProp;
	} 

	function setTitleProp ($titleCss = "", $titleBgColor = "", $titleAlign = "")
	{
		if (!empty($titleCss)) {
		    $this->__titleCss = $titleCss;
		}
		if (!empty($titleBgColor)) {
		    $this->__titleBgColor = $titleBgColor;
		}
		if (!empty($titleAlign)) {
		    $this ->__titleAlign = $titleAlign;
		}
	} 

	function setContentProp ($contentCss = "", $contentBgColor = "", $contentAlign = "")
	{
		if (!empty($contentCss)) {
		    $this->__contentCss = $contentCss;
		}
		if (!empty($contentBgColor)) {
		    $this->__contentBgColor = $contentBgColor;
		}
		if (!empty($contentAlign)) {
		    $this->__contentAlign = $contentAlign;
		}
	} 

	function setSubmitProp ($submitCss, $submitBgColor, $submitAlign)
	{
		if (!empty($submitCss)) {
			$this->__submitCss = $submitCss;
		}
		if (!empty($submitBgColor)) {
			$this->__submitBgColor = $submitBgColor;
		}
		if (!empty($submitAlign)) {
			$this->__submitAlign = $submitAlign;
		}
	}
	
	function setNavRow($navRow)
	{
		$this->__navRow = $navRow;
	}
	
	function setNavProp ($navCss, $navBgColor, $navAlign)
	{
		if (!empty($navCss)) {
		    $this->__navCss = $navCss;
		}
		if (!empty($navBgColor)) {
		    $this->__navBgColor = $navBgColor;
		}
		if (!empty($navAlign)) {
		    $this->__navAlign = $navAlign;
		}
	}

	function retCellTag($align, $bgColor, $prop, $css)
	{
		$cellTag = "";
		if (!empty($align)) {
			$cellTag .= " align=\"" . $align . "\"";
		} elseif (!empty($this->__contentAlign)) {
			$cellTag .= " align=\"" . $this->__contentAlign . "\"";
		} 
		if (!empty($bgColor)) {
			$cellTag .= " bgcolor=\"" . $bgColor . "\"";
		} elseif (!empty($this->__contentBgColor)) {
			$cellTag .= " bgcolor=\"" . $this->__contentBgColor . "\"";
		} 
		if (!empty($prop)) {
			$cellTag .= " " . $prop;
		} else {
			$cellTag .= " valign=\"top\"";
		}
		if (!empty($css)) {
			$cellTag .= " id=\"" . $css . "\"";
		} elseif (!empty($this->__contentCss)) {
			$cellTag .= " id=\"" . $this->__contentCss . "\"";
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
		return $inputTag;
	} 

	function getTitleTag()
	{
		$titleTag = "";
		if (!empty($this->__titleAlign)) {
			$titleTag .= " align=\"" . $this->__titleAlign . "\"";
		} 
		if (!empty($this->__titleBgColor)) {
			$titleTag .= " bgcolor=\"" . $this->__titleBgColor . "\"";
		} 
		if (!empty($this->__titleCss)) {
			$titleTag .= " id=\"" . $this->__titleCss . "\"";
		} 
		return $titleTag;
	} 

	function getSubmitTag()
	{
		$submitTag = "";
		if (!empty($this->__submitAlign)) {
			$submitTag .= " align=\"" . $this->__submitAlign . "\"";
		} 
		if (!empty($this->__submitBgColor)) {
			$submitTag .= " bgcolor=\"" . $this->__submitBgColor . "\"";
		} 
		if (!empty($this->_submitCss)) {
			$submitTag .= " id=\"" . $this->__submitCss . "\"";
		} 
		return $submitTag;
	}
	
	function getNavTag()
	{
		$navTag = "";
		if (!empty($this->__navAlign)) {
		    $navTag .= " align=\"".$this->__navAlign."\"";
		}
		if (!empty($this->__navBgColor)) {
		    $navTag .= " bgcolor=\"".$this->__navBgColor."\"";
		}
		if (!empty($this->__navCss)) {
		    $navTag .= " id=\"".$this->__navCss."\"";
		}
		return $navTag;
	}

	function addText ($title, $fieldName, $width = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "text", "title" => $title, "fieldName" => $fieldName, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}
	
	function addDate ($title, $fieldName, $width = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "date", "title" => $title, "fieldName" => $fieldName, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}

	function addDateTime ($title, $fieldName, $width = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "dateTime", "title" => $title, "fieldName" => $fieldName, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}
	
	function addLink ($title, $fieldName, $link, $width = "", $extLink = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "link", "title" => $title, "fieldName" => $fieldName, "link" => $link, "extLink" => $extLink, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	} 

	function addStaticLink ($title, $staticText, $link, $width = "", $extLink = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "staticLink", "title" => $title, "staticText" => $staticText, "link" => $link, "extLink" => $extLink, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}

	function addPopupLink ($title, $fieldName, $link, $popupTitle, $popupProp, $width = "", $extLink = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "popupLink", "title" => $title, "fieldName" => $fieldName, "link" => $link, "extLink" => $extLink, "popupTitle" => $popupTitle, "popupProp" => $popupProp, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	} 

	function addImage ($title, $fieldName, $imagePath, $width = "", $imageProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "image", "title" => $title, "fieldName" => $fieldName, "imagePath" => $imagePath, "imageProp" => $imageProp, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}

	// function for Add Input;
	function addInputText ($title, $fieldName, $width = "", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputText", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	} 

	function addInputTextarea ($title, $fieldName, $width = "", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputTextarea", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	} 

	function addInputSelect ($title, $fieldName, $width = "", $arrValue, $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputSelect", "title" => $title, "fieldName" => $fieldName, "arrValue" => $arrValue, "inputTag" => $inputTag, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}

	function addInputImage ($title, $fieldName, $imagePath, $width = "", $autoRename = true, $comp = false, $thumb = false, $ukuran = "", $kecil = "", $zoom = "", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{

		
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp, $inputCss);
		$arrBuff = array("type" => "inputImage", "title" => $title, "fieldName" => $fieldName, "imagePath" => $imagePath, "autoRename" => $autoRename, "comp" => $comp, "thumb" => $thumb, "ukuran" => $ukuran, "kecil" => $kecil, "zoom" => $zoom, "inputTag" => $inputTag, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	} 

	function actThumbnailer ($baseImage = "")
	{
		$this->__thumbBaseImage = $baseImage;
		$this->__thumbnailer = true;
	}
	
	
	
	function addInputCheck ($title, $fieldName, $width = "", $inputCss = "", $inputProp = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$inputTag = $this->retInputTag($inputProp ." style=\"border: none\"", $inputCss);
		$arrBuff = array("type" => "inputCheck", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	}
	// function addInputRadio;
	// function addInputFile;
	function addInputDate ($title, $fieldName, $width = "", $inputTag = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("type" => "inputDate", "title" => $title, "fieldName" => $fieldName, "inputTag" => $inputTag, "cellTag" => $cellTag);
		array_push($this->__arrColumn, $arrBuff);
		array_push($this->__arrWidth, $width);
	} 

	function addNav ($navRow = "", $css = "", $bgColor = "", $align = "", $prop = "")
	{
		if (!empty($navRow)) {
		    $this->__navRow = $navRow;
		}
		$cellTag = $this->retCellTag($align, $bgColor, $prop, $css);
		$arrBuff = array("cellTag" => $cellTag);
		array_push($this->__arrNav, $arrBuff);
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
		array_push($this->__arrSubmit, $arrBuff);
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
 
		// Execute Update Action
		if (($_POST['form_id'] == $this->__formId) && isset($_POST[$submitName])) {
			for ($i = 0; $i<count($_POST[$this->__tableId]); $i++){
				$strUpdate = "";
				foreach ($this->__arrColumn as $row) {
					if (preg_match("/^input(\w+)$/", $row['type'], $rowMatch)) {
						if (($rowMatch[1] == "Image")) {
							if ($_FILES[$row['fieldName']]['name'][$i] == "\\\"") {
								$delResult = mysql_query("SELECT `" . $row['fieldName'] . "` FROM `" . $this->__table . "` WHERE `".$this->__tableId."` = '".$_POST[$this->__tableId][$i]."'") or die("Query Failed: Failed to fetch image to delete");
								$delFile = mysql_fetch_row($delResult);
								@unlink($row['imagePath'] . $delFile[0]);
								if ($this->__thumbnailer) {
									@unlink($row['imagePath'] . 'thumbnail/' . $delFile[0]);
								}
								if ($row['thumb']) {
									@unlink($row['imagePath'] . 'zoom_' . $delFile[0]);
								}
								$strUpdate .= "`" . $row['fieldName'] . "` = '', ";
							} elseif (!empty($_FILES[$row['fieldName']]['name'][$i])) {
								if (is_uploaded_file($_FILES[$row['fieldName']]['tmp_name'][$i])) {
									if ($row['autoRename']) {
										preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'][$i], $ext);
										$fileName = $ext[1] . "_".substr(uniqid(""), -6) . $ext[2];
									} else {
										$fileName = $_FILES[$row['fieldName']]['name'][$i];
										preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES[$row['fieldName']]['name'][$i], $ext);
									}
									if (move_uploaded_file($_FILES[$row['fieldName']]['tmp_name'][$i], $row['imagePath'] . $fileName)) {
										$strUpdate .= "`" . $row['fieldName'] . "` = '" . $fileName . "', ";
										if ($this->__thumbnailer) {
											$a = new Thumbnail($row['imagePath'] . $fileName, $this->__thumbBaseImage, $row['imagePath'] . 'thumbnail/'. $fileName, 85, '');
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
										
										$delResult = mysql_query("SELECT `" . $row['fieldName'] . "` FROM `" . $this->__table . "` WHERE `".$this->__tableId."` = '".$_POST[$this->__tableId][$i]."'") or die("Query Failed: Failed to fetch image to delete");
										$delFile = mysql_fetch_row($delResult);
										@unlink($row['imagePath'] . $delFile[0]);
										if ($this->__thumbnailer) {
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
						} elseif ($rowMatch[1] == "Check") {
							if ($row['fieldName'] != "deleteId") {
								if (isset($_POST[$row['fieldName']][$i])) {
									$strUpdate .= "`" . $row['fieldName'] . "` = '1', ";							    
								} else {
									$strUpdate .= "`" . $row['fieldName'] . "` = '0', ";
								}							    
							}
						} elseif ($rowMatch[1] == "Date") {
							$date = $_POST['yyyy'][$i] . "-" . $_POST['mm'][$i] . "-" . $_POST['dd'][$i];
							$strUpdate .= "`" . $row['fieldName'] . "` = '" . $date . "', ";
						} else {
							$strUpdate .= "`" . $row['fieldName'] . "` = '" . $_POST[$row['fieldName']][$i] . "', ";
						} 
					} 
				} 
				$set = substr($strUpdate, 0, -2);
				if (!empty($set)) {
					if ($this->__useTransaction) {
						mysql_query("SET AUTOCOMMIT = 0") or die("Query failed: unset autocommit");
						mysql_query("BEGIN") or die("Query failed: begins transaction");
					}
					$query = "UPDATE `" . $this->__table . "` SET " . $set . " WHERE `".$this->__tableId."` = '".$_POST[$this->__tableId][$i]."'";
					mysql_query($query) or die("Query Failed : failed to perform update action." . mysql_error());
					if ($this->__useTransaction) {
						mysql_query("COMMIT") or die("Query failed: commit transaction");
						mysql_query("SET AUTOCOMMIT = 1") or die("Query failed: set autocommit");
					}
				}
			}
		} 
	} 

	function addSubmitDelete ($columTitle = "", $title = "", $submitCss = "", $submitName = "", $submitProp = "onClick=\"if(!confirm('Do Delete Action?')) return false;\"")
	{
		if (empty($columTitle)) {
			    $columTitle = "Delete";
		}
		if (empty($title)) {
			$title = "Delete";
		} 
		if (empty($submitName)) {
			$submitName = "submit_delete";
		} 
		$this->addSubmit("delete", $title, $submitCss, $submitName, $submitProp);
		$this->addInputCheck($columTitle, "deleteId", "60", "", " class=\"me_action\"", "", "", "center");
 
		// Execute Delete Action
		if (($_POST['form_id'] == $this->__formId) && isset($_POST[$submitName]) && (is_array($_POST['deleteId']))) {
			$strDelete = "";
			for ($i = 0; $i<count($_POST[$this->__tableId]); $i++){
				if (isset($_POST["deleteId"][$i])) {
				    $strDelete .= "'".$_POST[$this->__tableId][$i]."', ";
				}
			}
 			$idDelete = substr($strDelete, 0, -2);
			if ($this->__useTransaction) {
				mysql_query("SET AUTOCOMMIT = 0") or die("Query failed: unset autocommit");
				mysql_query("BEGIN") or die("Query failed: begins transaction");
			}
			$query = "DELETE FROM `" . $this->__table . "` WHERE `".$this->__tableId."` IN (".$idDelete.")";
			mysql_query($query) or die("Query Failed : failed to perform delete action." . mysql_error());
			if ($this->__useTransaction) {
				mysql_query("COMMIT") or die("Query failed: commit transaction");
				mysql_query("SET AUTOCOMMIT = 1") or die("Query failed: set autocommit");
			}
		} 
	}

	function addSubmitDeleteImage ($imagePath, $arrImageField, $columTitle = "", $title = "", $submitCss = "", $submitName = "", $submitProp = "")
	{
		if (empty($columTitle)) {
		    $columTitle = "Delete";
		}
		if (empty($title)) {
			$title = "Delete";
		} 
		if (empty($submitName)) {
			$submitName = "submit_delete";
		} 
		$this->addSubmit("delete", $title, $submitCss, $submitName, $submitProp);
		$this->addInputCheck($columTitle, "deleteId", "60", "", "", "", "", "center");
 
		// Execute Delete Image Action
		if (($_POST['form_id'] == $this->__formId) && isset($_POST[$submitName]) && (is_array($_POST['deleteId']))) {
			$strDelete = "";
			for ($i = 0; $i<count($_POST[$this->__tableId]); $i++){
				if (isset($_POST['deleteId'][$i])) {
				    $strDelete .= "'".$_POST[$this->__tableId][$i]."', ";
					$imgStrSelect = "";
					foreach ($arrImageField as $imageField){
						$imgStrSelect .= "`".$imageField."`, ";
					}
					$imgSelect = substr($imgStrSelect, 0, -2);
					$imgQuery = "SELECT ".$imgSelect." FROM `".$this->__table."` WHERE `".$this->__tableId."` = '".$_POST['deleteId'][$i]."'";
					$imgResult = mysql_query($imgQuery) or die("Query Failed : failed to select image to delete from databases." . mysql_error());
					$imgOld = mysql_fetch_row($imgResult);
					for ($j = 0; $j<count($imgOld); $j++){
						//echo $imagePath . $imgOld[$j];
						@unlink($imagePath . $imgOld[$j]);
						if ($this->__thumbnailer) {
							@unlink($imagePath . 'thumbnail/' . $imgOld[$j]);
						}
						
						//if ($row['thumb']) {
							@unlink($imagePath . 'zoom_' . $imgOld[$j]);
						//}
					}
				}
			}
 			$idDelete = substr($strDelete, 0, -2);
			if ($this->__useTransaction) {
				mysql_query("SET AUTOCOMMIT = 0") or die("Query failed: unset autocommit");
				mysql_query("BEGIN") or die("Query failed: begins transaction");
			}
			$query = "DELETE FROM `" . $this->__table . "` WHERE `".$this->__tableId."` IN (".$idDelete.")";
			mysql_query($query) or die("Query Failed : failed to perform delete action." . mysql_error());
			if ($this->__useTransaction) {
				mysql_query("COMMIT") or die("Query failed: commit transaction");
				mysql_query("SET AUTOCOMMIT = 1") or die("Query failed: set autocommit");
			}
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
		$buffer = "<!-- Start of CnnFormV -->";
		$buffer .= "<script>\n";
		$buffer .= "	$(document).ready(function(){\n";
		$buffer .= "		$('#".$this->__formId."_0').columnHover();\n";
		$buffer .= "	});\n";
		$buffer .= "</script>\n";
		$buffer .= "<script>\n";
		$buffer .= "	$(document).ready(function(){\n";
		$buffer .= "		$('#".$this->__formId."_1').columnHover();\n";
		$buffer .= "	});\n";
		$buffer .= "</script>\n";
		$buffer .= "\n\t<form " . $this->__formProp . ">";
		//$buffer .= "\n\t\t<table width=\"" . $this->__tableWidth . "\" bgcolor=\"" . $this->__tableBgColor . "\"";
		$buffer .= "\n\t\t<table class=\"entries_table\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"";
		if (!empty($this->__tableProp)) {
			$buffer .= " " . $this->__tableProp;
		} 
		$buffer .= ">";
		$buffer .= "<thead>";
		$buffer .= "\n\t\t\t<tr>";
		$w = 0;
		foreach ($this->__arrColumn as $row){
			$buffer .= "\n\t\t\t\t<th  scope=\"col\"";
			if (!empty($this->__arrWidth[$w])) {
			    $buffer .= " width=\"".$this->__arrWidth[$w]."\"";
			}
			$buffer .= $this->getTitleTag() . " height=\"18\">&nbsp;" . $row['title'] . "</td>";
			$w++;		
		}
		$buffer .= "\n\t\t\t</tr>";
		$buffer .= "</thead>";
		//$buffer .= "<tbody>";
		$arrFieldSelect = array();
		foreach ($this->__arrColumn as $row) {
			if (array_key_exists("fieldName", $row)) {
				if (($row['fieldName'] != "") && ($row['fieldName'] != "deleteId") && !in_array($row['fieldName'], $arrFieldSelect)) {
					array_push($arrFieldSelect, $row['fieldName']);
				} 
			} 
		}
		$strFieldSelect = implode("`, `", $arrFieldSelect);
		if (count($this->__arrNav) > 0) {
			$this->CnnNav($this->__navRow, $this->__table." ".$this->__extQuery, "`".$this->__tableId."`, `".$strFieldSelect."`", $this->__tableId);
			$resultSQL = $this->getResult();
		} else {
			$querySQL = "SELECT `".$this->__tableId."`, `" . $strFieldSelect . "` FROM `" . $this->__table . "` " . $this->__extQuery;
			$resultSQL = mysql_query($querySQL) or die ("Error : MySQL Query Failed on fetching data from table. Please Check Your Script. \n" . mysql_error());		
		}
		$hiddenId = "";
		$i = 0;
		while($valueSQL = mysql_fetch_assoc($resultSQL)){
			extract($valueSQL);
			$tableId = $this->__tableId;
			$buffer .= "\n\t\t\t<tr>";
			foreach ($this->__arrColumn as $row){
				switch ($row['type']) {
					case 'text':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;" . $$row['fieldName'] . "</td>";
						break;
					case 'date':
						$date = preg_replace("/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/e", '"\\4/\\3/\\1\\2"', $$row['fieldName']);
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;" . $date . "</td>";
						break;
					case 'dateTime':
						preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $$row['fieldName'], $dM);
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;" . date("d M Y h:i:s", mktime($dM[4], $dM[5], $dM[6], $dM[2], $dM[3], $dM[1])) . "</td>";
						break;
					case 'link':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;<a href=\"" . $row['link'] . "?" . $this->__tableId . "=" . $$tableId ;
						if (!empty($row['extLink'])) {
						    $buffer .= "&".$row['extLink'];
						}
						$buffer .= "\">" . $$row['fieldName'] . "</a></td>";
						break;
					case 'staticLink':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;<a href=\"" . $row['link'] . "?" . $this->__tableId . "=" . $$tableId ;
						if (!empty($row['extLink'])) {
						    $buffer .= "&".$row['extLink'];
						}
						$buffer .= "\">" . $row['staticText'] . "</a></td>";
						break;
					case 'popupLink':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;<a href=\"#\"";
						$buffer .= " onClick=\"MM_openBrWindow('" . $row['link'] . "?" . $this->__tableId . "=" . $$tableId;
						if (!empty($row['extLink'])) {
						    $buffer .= "&".$row['extLink'];
						}
						$buffer .= "','".$row['popupTitle']."','".$row['popupProp']."')";
						$buffer .= "\">" . $$row['fieldName'] . "</a></td>";
						break;
					case 'image':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">";
						if (!empty($$row['fieldName']) && file_exists($row['imagePath'] . $$row['fieldName'])) {
							$buffer .= "\n\t\t\t\t\t<img src=\"".$row['imagePath'].$$row['fieldName']."\" alt=\"".$$row['fieldName']."\"".$row['imageProp'].">";
						}
						$buffer .= "\n\t\t\t\t</td>";
						break;
					case 'inputText':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">";
						$buffer .= "\n\t\t\t\t\t<input name=\"" . $row['fieldName'] . "[".$i."]\" type=\"text\" id=\"" . $row['fieldName'] . "[".$i."]\"" . $row['inputTag'];
						$buffer .= " value=\"" . htmlentities($$row['fieldName']) . "\">";
						$buffer .= "\n\t\t\t\t</td>";
						break;
					case 'inputTextarea':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">";
						$buffer .= "\n\t\t\t\t\t<textarea name=\"" . $row['fieldName'] . "[".$i."]\" id=\"" . $row['fieldName'] . "[".$i."]\"" . $row['inputTag'] . ">";
						$buffer .= $$row['fieldName'];
						$buffer .= "</textarea>\n\t\t\t\t</td>";
						break;
					case 'inputSelect':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;";
						$buffer .= "\n\t\t\t\t\t<select name=\"" . $row['fieldName'] . "[".$i."]\" id=\"" . $row['fieldName'] . "[".$i."]\"" . $row['inputTag'] . ">";
						for ($j = 0; $j < count($row['arrValue']); $j = $j + 2) {
							$buffer .= "\n\t\t\t\t\t\t<option value=\"" . htmlentities($row['arrValue'][$j]) . "\"";
							if ($row['arrValue'][$j] == $$row['fieldName']) {
								$buffer .= " selected";
							} 
							$buffer .= ">" . $row['arrValue'][$j + 1] . "</option>";
						} 
						$buffer .= "\n\t\t\t\t\t</select>";
						$buffer .= "\n\t\t\t\t</td>";
						break;
					case 'inputCheck':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">";
						$buffer .= "\n\t\t\t\t\t<input name=\"" . $row['fieldName'] . "[".$i."]\" type=\"checkbox\" id=\"" . $row['fieldName'] . "[".$i."]\"" . $row['inputTag'];
						$buffer .= " value=\"" . $$tableId . "\"";
						if ($$row['fieldName'] == '1') {
						    $buffer .= " checked";
						}
						$buffer .= ">\n\t\t\t\t</td>";
						break;
					case 'inputImage':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">";
						if (!empty($$row['fieldName']) && file_exists($row['imagePath'] . $$row['fieldName'])) {
							$buffer .= "\n\t\t\t\t\t&nbsp;" . $$row['fieldName'] . "</br>";
						} 
						$buffer .= "\n\t\t\t\t\t&nbsp<input name=\"" . $row['fieldName'] . "[".$i."]\" type=\"file\" id=\"" . $row['fieldName'] . "[".$i."]\"" . $row['inputTag'] . ">";
						$buffer .= "\n\t\t\t\t</td>";
						break;
					case 'inputDate':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;";
						if ($$row['fieldName'] == "0000-00-00") {
								$dd = date('d');
								$mm = date('m');
								$yyyy = date('Y');
							} else {
								$yyyy = substr($$row['fieldName'], 0, 4);
								$mm = substr($$row['fieldName'], 5, 2);
								$dd = substr($$row['fieldName'], 8, 2);
							}
						
						$buffer .= "\n\t\t\t\t<span>";
						//$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_1\">DD</label> ";
						$buffer .= "\n\t\t\t\t<input id=\"element_".$i."_1\" name=\"dd[".$i."]\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"".$dd."\" type=\"text\"> /";
						$buffer .= "\n\t\t\t\t</span> ";
						$buffer .= "\n\t\t\t\t<span> ";
						//$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_2\">MM</label> ";
						$buffer .= "\n\t\t\t\t<input id=\"element_".$i."_2\" name=\"mm[".$i."]\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"".$mm."\" type=\"text\"> /";
						$buffer .= "\n\t\t\t\t</span> ";
						$buffer .= "\n\t\t\t\t<span> ";
						//$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_3\">YYYY</label> ";
						$buffer .= "\n\t\t\t\t<input id=\"element_".$i."_3\" name=\"yyyy[".$i."]\" class=\"element text\" size=\"4\" maxlength=\"4\" value=\"".$yyyy."\" type=\"text\"> ";
						$buffer .= "\n\t\t\t\t</span> ";
		
						$buffer .= "\n\t\t\t\t<!--span id=\"calendar_".$i."\"--> ";
						$buffer .= "\n\t\t\t\t<!--img id=\"cal_img_".$i."\" class=\"datepicker\" src=\"images/calendar.gif\" alt=\"Pick a date.\"-->";	
						$buffer .= "\n\t\t\t\t</span>";
						$buffer .= "\n\t\t\t\t<script type=\"text/javascript\"> ";
						$buffer .= "\n\t\t\t\tCalendar.setup({";
						$buffer .= "\n\t\t\t\tinputField	 : \"element_".$i."_3\",";
						$buffer .= "\n\t\t\t\tbaseField    : \"element_".$i."\",";
						$buffer .= "\n\t\t\t\tdisplayArea  : \"calendar_".$i."\",";
						$buffer .= "\n\t\t\t\tbutton		 : \"cal_img_".$i."\",";
						$buffer .= "\n\t\t\t\tifFormat	 : \"%B %e, %Y\",";
						$buffer .= "\n\t\t\t\tonSelect	 : selectEuropeDate,";
						$buffer .= "\n\t\t\t\t});";
						$buffer .= "\n\t\t\t\t</script> ";
						$buffer .= "\n\t\t\t\t</td>";
						break;
					case 'inputDateS':
						$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">&nbsp;";
	
						$array_month = array("", "January", "February", "March", "April", "May", "Juny", "July", "August", "September", "October", "November", "December");
						if ($$row['fieldName'] == "0000-00-00") {
							$dd = date('d');
							$mm = date('m');
							$yyyy = date('Y');
						} else {
							$yyyy = substr($$row['fieldName'], 0, 4);
							$mm = substr($$row['fieldName'], 5, 2);
							$dd = substr($$row['fieldName'], 8, 2);
						} 
	
						$buffer .= "\n\t\t\t\t\t<select name=\"dd[".$i."]\" id=\"dd[".$i."]\" size=\"1\"" . $row['inputTag'] . ">";
						for($j = 1; $j <= 31; $j++) {
							$buffer .= "\n\t\t\t\t\t\t<option value=\"" . $j . "\"";
							if ($j == $dd) {
								$buffer .= "selected";
							} 
							$buffer .= ">" . $j . "</option>";
						} 
						$buffer .= "\n\t\t\t\t\t</select>";
						$buffer .= "\n\t\t\t\t\t<select name=\"mm[".$i."]\" id=\"mm[".$i."]\" size=\"1\"" . $row['inputTag'] . ">";
						for($j = 1; $j <= 12; $j++) {
							$buffer .= "\n\t\t\t\t\t\t<option value=\"" . $j . "\"";
							if ($j == $mm) {
								$buffer .= "selected";
							} 
							$buffer .= ">" . $array_month[$j] . "</option>";
						} 
						$buffer .= "\n\t\t\t\t\t</select>";
						$buffer .= "\n\t\t\t\t\t<select name=\"yyyy[".$i."]\" id=\"yyyy[".$i."]\" size=\"1\"" . $row['inputTag'] . ">";
						for($j = 1945; $j <= (date("Y") + 10); $j++) {
							$buffer .= "\n\t\t\t\t\t\t<option value=\"" . $j . "\"";
							if ($j == $yyyy) {
								$buffer .= "selected";
							} 
							$buffer .= ">" . $j . "</option>";
						} 
						$buffer .= "\n\t\t\t\t\t</select>";
	
						$buffer .= "\n\t\t\t\t</td>";
						break;
				} // switch
			}
			$buffer .= "\n\t\t\t</tr>";
			$hiddenId .= "\n\t\t\t\t\t<input name=\"" . $this->__tableId . "[".$i."]\" type=\"hidden\" id=\"" . $this->__tableId . "[".$i."]\" value=\"" . $$tableId . "\">";
			$i++;
 		}
		
		$buffer .= "\n\t\t\t<tr>";
		$buffer .= "\n\t\t</table>";
		$buffer .= "\n\t\t<table id=\"".$this->__formId."_1\" class=\"entries_table\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"";
		$buffer .= "\n\t\t\t\t<td height=\"18\" colspan=\"".count($this->__arrColumn)."\"".$this->getNavTag().">";
		
		//Show Navigation		
		if (count($this->__arrNav) > 0) {
			$buffer .= $this -> getNav();		    
		}
		
		$buffer .= "\n\t\t\t\t</td>";
		$buffer .= "\n\t\t\t</tr>";

		// Show Submit Button
		if (count($this->__arrSubmit) > 0) {
			$buffer .= "\n\t\t\t<tr>";
			$buffer .= "\n\t\t\t\t<td colspan=\"".count($this->__arrColumn)."\"" . $this->getSubmitTag() . ">";
			foreach ($this->__arrSubmit as $row) {
				if (($row['type'] == "update") || ($row['type'] == "delete")) {
					$buttonType = "submit";
				} elseif ($row['type'] == "reset") {
					$buttonType = "reset";
				} else {
					$buttonType = "none";
				} 
				$buffer .= "\n\t\t\t\t\t<input name=\"" . $row['submitName'] . "\" type=\"" . $buttonType . "\"" . $row['submitTag'] . " id=\"" . $row['submitName'] . "\" value=\"" . $row['title'] . "\">";
			} 
			$buffer .= "\n\t\t\t\t\t<input name=\"form_id\" type=\"hidden\" value=\"" . $this->__formId . "\">";
			$buffer .= $hiddenId;
			$buffer .= "\n\t\t\t\t</td>";
			$buffer .= "\n\t\t\t</tr>";
		} 
		$buffer .= "\n\t\t</table>";
		$buffer .= "\n\t</form>";
		$buffer .= "\n<!-- End of CnnFormV -->\n";
		return $buffer;
	} 

	function printForm()
	{
		echo $this->getForm();
	} 

	function getArrColumn()
	{
		echo "<br>ArrRow :<br><pre>";
		echo print_r($this->__arrColumn);
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