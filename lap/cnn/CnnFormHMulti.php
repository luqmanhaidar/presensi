<?php
/**
 * Easy Form Creator and Management Class for PHP, which support:
 * - MySQL Database
 * - InteractiveTool Online GPL WYSIWYG HTML editor
 * - CSS   
 * Copyright (C) 2003 Cristian Ade Candra
 * 
 * Version  0.0.1 Beta  2004-06-16
 * Note: This Class is still beta version and has only some functions extended from cnnFormH run properly :).
 */
include_once("CnnFormH.php");

class CnnFormHMulti extends cnnFormH {
	var $_contentField;
	var $_idField;
	
	function CnnFormHMulti ($table, $idField, $contentField, $extQuery = "") {
		$this->CnnFormH($table, $extQuery);
		$this->_idField = $idField;
		$this->_contentField = $contentField;
		$this->_inputBlank = false;
		//$this->_mceImagePath = $defDirImageMCE;
		//$this->_mceImageURL = $defURLImageMCE;
	}
	
	function getForm () {
		$buffer = "\n<!-- Start of CnnFormH -->";
		$buffer .= "\n\t<form class=\"appnitro\" id=\"".$this->_formId."\"  name=\"".$this->_formId."\"" . $this->_formProp . ">";
		//$buffer .= "\n\t\t<table width=\"" . $this->_tableWidth[0] . "\" bgcolor=\"" . $this->_tableBgColor . "\"";
		$buffer .= "<ul>";
		
		//$buffer = "<!-- Start of CnnFormHMulti -->";
		//$buffer .= "\n\t<form name=\" ".$this->_formId."\"" . $this->_formProp . ">";
		//$buffer .= "\n\t\t<table width=\"" . $this->_tableWidth[0] . "\" bgcolor=\"" . $this->_tableBgColor . "\"";
		if (!empty($this->_tableProp)) {
			//$buffer .= " " . $this->_tableProp;
		} 
		//$buffer .= ">";
		//$buffer .= "\n\t\t\t<tr>";
		//$buffer .= "\n\t\t\t\t<td width=\"" . $this->_tableWidth[1] . "\"></td>";
		//$buffer .= "\n\t\t\t\t<td width=\"" . $this->_tableWidth[2] . "\"></td>";
		//$buffer .= "\n\t\t\t</tr>";
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
			$strFieldSelect = "'". implode("', '", $arrFieldSelect) ."'";
			$querySQL = "SELECT `". $this->_idField ."`, `". $this->_contentField ."` FROM `" . $this->_table . "` WHERE " . $this->_idField ." IN (". $strFieldSelect . ")" . $this->_extQuery;
			$resultSQL = mysql_query($querySQL) or die ("Error : MySQL Query Failed on fetching data from table. Please Check Your Script. \n" . mysql_error());
			$arrMultiRow = array();
			while ($valueSQL = mysql_fetch_row($resultSQL) ) {
				 $arrMultiRow[$valueSQL[0]] = $valueSQL[1];
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
					$buffer .= "\n\t\t\t\t<div><input id=\"element_".$c."\" name=\"".$row['fieldName']."\" class=\"element text medium\" type=\"text\"  value=\"".$arrMultiRow[$row['fieldName']]."\"/></div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'link':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\">".$row['title']."</label>";
					$buffer .= "\n\t\t\t\t<a href=\"" . $row['link'] . "?" . $arrMultiRow[$row['fieldId']] . "=" . $row['fieldId'] . "\">" . $arrMultiRow[$row['fieldId']] . "</a>>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputText':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div><input  name=\"input[".$row['fieldName']."]\" ".$row['inputTag']." class=\"element text medium ".$row['validation']."\" type=\"text\" id=\"element_".$c."\"";
					if (!$this->_inputBlank) {
						$buffer .= " value=\"" . htmlentities($arrMultiRow[$row['fieldName']]) . "\"";
					} 
					$buffer .= "/>\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputTextarea':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div><textarea name=\"input[" . $row['fieldName'] . "]\" id=\"element_".$c."\"" . $row['inputTag'] . " class=\"element textarea medium ".$row['validation']."\">";
					if (!$this->_inputBlank) {
						$buffer .= $arrMultiRow[$row['fieldName']];
					} 
					$buffer .= "</textarea>\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;					
					case 'inputMceTool':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"input[".$row['fieldName']."]\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					?>
					<script language="javascript" type="text/javascript" src="fckeditor/fckeditor.js"></script>
					<?php
					$buffer .= "\n"; //. ob_get_contents();
					$sBasePath=dirname($_SERVER['PHP_SELF']);
					
					//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
					
					$oFCKeditor = new FCKeditor("input[".$row['fieldName']."]") ;
					$oFCKeditor->BasePath	= $sBasePath."/fckeditor/";
					$oFCKeditor->ToolbarSet = "Basic_Plus";
					$oFCKeditor->Value		= '' ;
					//$oFCKeditor->Width		= $row["width"];
					//$oFCKeditor->Width		= $row["height"];
					if (!$this->_inputBlank) {
						$oFCKeditor->Value	= $arrMultiRow[$row['fieldName']];
					}
					$buffer .= $oFCKeditor->CreateHtml();
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
					
				case 'inputMceToolAgain':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"input[".$row['fieldName']."]\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					?>
					<script language="javascript" type="text/javascript" src="fckeditor/fckeditor.js"></script>
					<?php
					$buffer .= "\n"; //. ob_get_contents();
					$sBasePath=dirname($_SERVER['PHP_SELF']);
					
					//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
					
					$oFCKeditor = new FCKeditor("input[".$row['fieldName']."]") ;
					$oFCKeditor->BasePath	= $sBasePath."/fckeditor/";
					$oFCKeditor->ToolbarSet = "Basic_Plus";
					$oFCKeditor->Value		= '' ;
					//$oFCKeditor->Width		= $row["width"];
					//$oFCKeditor->Width		= $row["height"];
					if (!$this->_inputBlank) {
						$oFCKeditor->Value	= $arrMultiRow[$row['fieldName']];
					}
					$buffer .= $oFCKeditor->CreateHtml();
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;					
					
				case 'inputSelect':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					$buffer .= "\n\t\t\t\t\t<select class=\"element select medium ".$row['validation']."\" name=\"input[" . $row['fieldName'] . "]\" id=\"element_".$c."\"" . $row['inputTag'] . ">";
					for ($i = 0; $i < count($row['arrValue']); $i = $i + 2) {
						$buffer .= "\n\t\t\t\t\t\t<option value=\"" . htmlentities($row['arrValue'][$i]) . "\"";
						if (!$this->_inputBlank && ($row['arrValue'][$i] == $arrMultiRow[$row['fieldName']])) {
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
					if (!$this->_inputBlank && !empty($arrMultiRow[$row['fieldName']]) && file_exists($row['imagePath'] . $arrMultiRow[$row['fieldName']])) {
						$buffer .= "\n\t\t\t\t\t&nbsp;" . $arrMultiRow[$row['fieldName']] . "</br>";
					} 
					$buffer .= "\n\t\t\t\t\t<input name=\"input[" . $row['fieldName'] . "]\" type=\"file\" id=\"element_".$c."\"" . $row['inputTag'] . " class=\"element file ".$row['validation']."\">";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputImageThumb':
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					if (!$this->_inputBlank && !empty($arrMultiRow[$row['fieldName']]) && file_exists($row['imagePath'] . $arrMultiRow[$row['fieldName']])) {
						$buffer .= "\n\t\t\t\t\t\t\t<img src=\"" . $row['imagePath'] . $arrMultiRow[$row['fieldName']] . "\"" . $row['imageProp'] . ">";
					} 
					$buffer .= "\n\t\t\t\t\t\t\t<input class=\"element file ".$row['validation']."\" id=\"element_".$c."\" name=\"input[" . $row['fieldName'] . "]\" type=\"file\" id=\"" . $row['fieldName'] . "\"" . $row['inputTag'] . ">";
					$buffer .= "\n\t\t\t\t</div>";
					$buffer .= "\n\t\t\t</li>";
					break;
				case 'inputDate':
					if ($this->_inputBlank) {
						$dd = date('d');
						$mm = date('m');
						$yyyy = date('Y');
					} else {
						$yyyy = substr($arrMultiRow[$row['fieldName']], 0, 4);
						$mm = substr($arrMultiRow[$row['fieldName']], 5, 2);
						$dd = substr($arrMultiRow[$row['fieldName']], 8, 2);
					} 
					
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."]\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					$buffer .= "\n\t\t\t\t<span>";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_1\" name=\"input[dd".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$dd."\" type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_1\">DD</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_2\" name=\"input[mm".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$mm."\" type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_2\">MM</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
	 				$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_3\" name=\"input[yyyy".$c."]\" class=\"element text ".$row['validation']."\" size=\"4\" maxlength=\"4\" value=\"".$yyyy."\" type=\"text\"> ";
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
					
					
					$buffer .= "\n\t\t\t<tr>";
					$buffer .= "\n\t\t\t\t<td" . $this->getTitleTag() . ">&nbsp;" . $row['title'] . "</td>";
					$buffer .= "\n\t\t\t\t<td" . $row['cellTag'] . ">";
					break;
				//still facing bugs with the inputDateTime
				case 'inputDateTime':
					if ($this->_inputBlank) {
						$dd = date('d');
						$mm = date('m');
						$yyyy = date('Y');
						$hh = date('H');
						$ii = date('i');
						$ss = date('s');
					} else {
						$yyyy = substr($arrMultiRow[$row['fieldName']], 0, 4);
						$mm = substr($arrMultiRow[$row['fieldName']], 5, 2);
						$dd = substr($arrMultiRow[$row['fieldName']], 8, 2);
						$hh = substr($arrMultiRow[$row['fieldName']], 11, 2);
						$ii = substr($arrMultiRow[$row['fieldName']], 14, 2);
						$ss = substr($arrMultiRow[$row['fieldName']], 17, 2);
					} 
					
					$buffer .= "\n\t\t\t<li id=\"li_".$c."\" >";
					$buffer .= "\n\t\t\t\t<label class=\"description\" for=\"element_".$c."\">" . $row['title'] . "</label>";
					$buffer .= "\n\t\t\t\t\t<div>";
					$buffer .= "\n\t\t\t\t<span>";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_1\" name=\"input[dd".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$dd."\" type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_1\">DD</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
					$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_2\" name=\"input[mm".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" maxlength=\"2\" value=\"".$mm."\"  type=\"text\"> /";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_2\">MM</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					$buffer .= "\n\t\t\t\t<span> ";
	 				$buffer .= "\n\t\t\t\t<input id=\"element_".$c."_3\" name=\"input[yyyy".$c."]\" class=\"element text ".$row['validation']."\" size=\"4\" maxlength=\"4\" value=\"".$yyyy."\" type=\"text\"> ";
					$buffer .= "\n\t\t\t\t<label for=\"element_".$c."_3\">YYYY</label> ";
					$buffer .= "\n\t\t\t\t</span> ";
					
					$buffer .= "\n\t\t\t\t		<span> ";
					$buffer .= "\n\t\t\t\t			<input id=\"element_".$c."_4\" name=\"input[hh".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" type=\"text\" value=\"".$hh."\" maxlength=\"2\" value=\"\"/> : ";
					$buffer .= "\n\t\t\t\t			<label>HH</label> ";
					$buffer .= "\n\t\t\t\t		</span> ";
					$buffer .= "\n\t\t\t\t		<span> ";
					$buffer .= "\n\t\t\t\t			<input id=\"element_".$c."_5\" name=\"input[ii".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" type=\"text\" value=\"".$ii."\" maxlength=\"2\" value=\"\"/> : ";
					$buffer .= "\n\t\t\t\t			<label>MM</label> ";
					$buffer .= "\n\t\t\t\t		</span> ";
					$buffer .= "\n\t\t\t\t		<span> ";
					$buffer .= "\n\t\t\t\t			<input id=\"element_".$c."_6\" name=\"input[ss".$c."]\" class=\"element text ".$row['validation']."\" size=\"2\" type=\"text\" value=\"".$ss."\" maxlength=\"2\" value=\"\"/> ";
					$buffer .= "\n\t\t\t\t			<label>SS</label> ";
					$buffer .= "\n\t\t\t\t		</span> ";
					
					$buffer .= "\n\t\t\t\t<span id=\"calendar_".$c."\"> ";
					$buffer .= "\n\t\t\t\t<img id=\"cal_img_".$c."\" class=\"datepicker\" src=\"images/calendar.gif\" alt=\"Pick a date.\">";	
					$buffer .= "\n\t\t\t\t</span>";
					$buffer .= "\n\t\t\t\t<script type=\"text/javascript\"> ";
					$buffer .= "\n\t\t\t\tCalendar.setup({";
					$buffer .= "\n\t\t\t\tinputField	 : \"element_".$c."_3\",";
					$buffer .= "\n\t\t\t\tbaseField    : \"element_".$c."\",";
					$buffer .= "\n\t\t\t\tdisplayArea  : \"calendar_".$c."\",";
					$buffer .= "\n\t\t\t\tbutton		 : \"cal_img_".$c."\",";
					$buffer .= "\n\t\t\t\tshowsTime		 : true,";
					$buffer .= "\n\t\t\t\tifFormat	 : \"%Y-%m-%d %H:%M:%S\",";
					$buffer .= "\n\t\t\t\tonSelect	 : selectEuropeDateTime,";
					$buffer .= "\n\t\t\t\t});";
					$buffer .= "\n\t\t\t\t</script> ";

					
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
				$buffer .= "\n\t\t\t\t\t<input name=\"form_action\" type=\"hidden\" value=\"" . $actionType . "\">";
			} 
			$buffer .= "\n\t\t\t</li>";
		} 
		$buffer .= "\n\t\t</ul>";
		$buffer .="<script type=\"text/javascript\">";
		$buffer .= "\n				var valid3 = new Validation('".$this->_formId."',{useTitles:true});";
		$buffer .= "\n			</script>";
		$buffer .= "\n\t</form>";
		$buffer .= "\n<!-- End of CnnFormHMulti -->\n";
		return $buffer;
	} 
	
	function updateSQL ($id, $value) {
		mysql_query("UPDATE `". $this->_table ."` SET `". $this->_contentField ."` = '". $value ."' WHERE `". $this->_idField ."` = '". $id ."'") or die("Query Failed : failed to perform update action." . mysql_error());
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
		if (($_POST['form_id'] == $this->_formId) && ($_POST['form_action'] == "update") ) {
			$c = 0;
			foreach ($this->_arrRow as $row) {
				if (preg_match("/^input(\w+)$/", $row['type'], $rowMatch)) {
					if (($rowMatch[1] == "Image") || ($rowMatch[1] == "ImageThumb")) {
						if ($_FILES["input"]['name'][$row['fieldName']] == "-") {
							$delResult = mysql_query("SELECT `" . $this->_contentField . "` FROM `" . $this->_table . "` WHERE `" . $this->_idField . "` = '" . $row["fieldName"] . "'" . $this->_extQuery) or die("Query Failed: Failed to fetch filename");
							$delFile = mysql_fetch_row($delResult);
							@unlink($row['imagePath'] . $delFile[0]);
							$this->updateSQL($row["fieldName"], "");
						} elseif (!empty($_FILES["input"]['name'][$row['fieldName']])) {
							if (is_uploaded_file($_FILES["input"]['tmp_name'][$row['fieldName']])) {
								preg_match("/(\w+)(\.\w{1,5})$/i", $_FILES["input"]['name'][$row['fieldName']], $ext);
								$fileName = $ext[1] . "_".substr(uniqid(""), -6) . $ext[2];
								if (move_uploaded_file($_FILES["input"]['tmp_name'][$row['fieldName']], $row['imagePath'] . $fileName)) {
									$delResult = mysql_query("SELECT `" . $this->_contentField . "` FROM `" . $this->_table . "` WHERE `" . $this->_idField . "` = '" . $row["fieldName"] . "'" . $this->_extQuery) or die("Query Failed: Failed to fetch filename");
									$delFile = mysql_fetch_row($delResult);
									@unlink($row['imagePath'] . $delFile[0]);
									$this->updateSQL($row["fieldName"], $fileName);
								} else {
									die("Failed to Upload Image. Query wasn't executed yet.");
								} 
							} else {
								die("Failed to Upload Image. Query wasn't executed yet.");
							} 
						} 
					} elseif ($rowMatch[1] == "Date") {
						$date = $_POST["input"]['yyyy'.$c] . "-" . $_POST["input"]['mm'.$c] . "-" . $_POST["input"]['dd'.$c];
						$this->updateSQL($row["fieldName"], $date);
					} elseif ($rowMatch[1] == "DateTime") {
						$dateTime = $_POST["input"]['yyyy'.$c] . "-" . $_POST["input"]['mm'.$c] . "-" . $_POST["input"]['dd'.$c] . " " . $_POST["input"]['hh'.$c] . "-" . $_POST["input"]['ii'.$c] . "-" . $_POST["input"]['ss'.$c];
						$this->updateSQL($row["fieldName"], $dateTime);
					} elseif ($rowMatch[1] == "Editor") {
						$editField = "input[". $row['fieldName'] ."]";
						$this->updateSQL($row["fieldName"], $_POST["input"][$editField]);
					} elseif ($rowMatch[1] == "InteractiveTool") {
						$editField = "inter_". $row['fieldName'];
						$this->updateSQL($row["fieldName"], $_POST["input"][$editField]);
					} else {
						$this->updateSQL($row["fieldName"], $_POST["input"][$row["fieldName"]]);
					} 
				} 
				$c++; 				
			}
		} 
	} 
}
?>