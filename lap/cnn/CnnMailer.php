<?php
include_once("class.phpmailer.php");

class CnnMailer extends PHPMailer {	
	function CnnMailer ($strFrom, $strFromName) {
		$this->IsSMTP();
		$this->Host = "localhost";
		$this->From = $strFrom;
		$this->FromName = $strFromName;
		$this->AddReplyTo($strFrom, $strFromName);
		$this->WordWrap = 50;
		$this->IsHTML(true);
	}
	
	function setToAddr ($toAddress, $toName = "") {
		$this->to[0][0] = $toAddress;
		if (!empty($toName) ) {
			$this->to[0][1] = $toName;
		}
	}
	
	function setBccAddrFromDb($table, $extQuery, $addrField, $nameField = "") {
		$query = "SELECT ". $addrField;
		if (!empty($nameField) ) {
			$query .= ", ". $nameField;
		}
		$query .= " FROM ". $table . " ". $extQuery;
		$result = mysql_query($query) or die("Error on CnnMailer::setAddrFromDb : Failed to fetch address data from database.");
		while ($row = mysql_fetch_row($result) ) {
			if (empty($nameField)  || empty($row[1]) ) {
				$this->AddBCC($row[0]);
			} else {
				$this->AddBCC($row[0], $row[1]);
			}
		}
	}
	
	function setBccAddr($arrAddr) {
		if (!is_array($arrAddr)  || (count($arrAddr) == 0) ) {
			echo "Error on CnnMailer::setAddr : Parameter $arrAddr must be an array and has at least one address.";
			exit;
		}
		$this->AddAddress($arrAddr[0]);
		for ($i = 1; $i < count($arrAddr); $i++) {
			$this->AddBCC($arrAddr[$i]);
		}
	}
		
	function mailSend($subject, $content, $altContent = "") {
		$this->Subject = $subject;
		$this->Body = $content;
		if (!empty($altContent) ) {
			$this->AltBody = $altContent;
		} else {
			$this->AltBody = strip_tags($content);
		}
		if(!$this->Send())
		{
			echo "Error on CnnMailer::bccSend : Failed to send email.<br>";
			echo "Mailer Error: " . $this->ErrorInfo;
			exit;
		}
	}
}
?>