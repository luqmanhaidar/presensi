<?php
//include("koneksi.php"); //ambil koneksi dB

function selectBT()
	{
		$form  = "<label><b>Tahun</b></label>";
		$form .= "<select name=\"tahun\" class=\"inputText\">";
		$form .= "<option>Tahun</option>\n";
		for ($i=2009; $i<=2020; $i++) {
			$form .= "<option value=\"$i\">".$i."</option>\n";
		    }
		$form .= "</select>";
		$form .= "<label><b>Bulan</b></label>";
		$form .= "<select name=\"bulan\" class=\"inputText\">";
		$form .= "<option>Bulan</option>\n";
		$form .= "<option value=\"01\">Januari</option>\n";
		$form .= "<option value=\"02\">Februari</option>\n";
		$form .= "<option value=\"03\">Maret</option>\n";
		$form .= "<option value=\"04\">April</option>\n";
		$form .= "<option value=\"05\">Mei</option>\n";
		$form .= "<option value=\"06\">Juni</option>\n";
		$form .= "<option value=\"07\">Juli</option>\n";
		$form .= "<option value=\"08\">Agustus</option>\n";
		$form .= "<option value=\"09\">September</option>\n";
		$form .= "<option value=\"10\">Oktober</option>\n";
		$form .= "<option value=\"11\">November</option>\n";
		$form .= "<option value=\"12\">Desember</option>\n";
		$form .= "</select>\n";
		return $form;
	}
	
function selectQR($label,$name,$tabel,$where="",$field="",$f1,$f2)
	{
		$form  = "<label><b>$label</b></label>";
		$form .= "<select name=\"".$name."\" class=\"inputText\">";
		$query = fetchRow($tabel,$where,$field);
		foreach ($query as $row){
			$form .= "<option value=\"$row[$f1]\">".$row[$f2]."</option>\n";
		}
		$form .= "</select>";
		return $form;
	}

function DosDr()
	{
	echo "<div></div>";
	echo "<h1>Rekap Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.dosen.dr.php\">";
	echo "<p class=\"left\">";
	echo "<label><b>Tahun</b></label>";
	echo "<select name=\"tahun\" class=\"inputText\">";
	echo "<option>Tahun</option>\n";
		for ($i=2009; $i<=2020; $i++) {
			echo "<option value=\"$i\">".$i."</option>\n";
		    }
	echo "</select>";
	echo "</p>";
	echo "<p class=\"right\">";
	echo "<label><b>Bulan</b></label>";
		echo "<select name=\"bulan\" class=\"inputText\">";
		echo "<option>Bulan</option>\n";
		echo "<option value=\"01\">Januari</option>\n";
		echo "<option value=\"02\">Februari</option>\n";
		echo "<option value=\"03\">Maret</option>\n";
		echo "<option value=\"04\">April</option>\n";
		echo "<option value=\"05\">Mei</option>\n";
		echo "<option value=\"06\">Juni</option>\n";
		echo "<option value=\"07\">Juli</option>\n";
		echo "<option value=\"08\">Agustus</option>\n";
		echo "<option value=\"09\">September</option>\n";
		echo "<option value=\"10\">Oktober</option>\n";
		echo "<option value=\"11\">November</option>\n";
		echo "<option value=\"12\">Desember</option>\n";
		echo "</select>\n";
	echo "<br clear=\"all\" />";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	 echo "<div class=\"clear\"></div>";
	echo "</p>";
	echo "</form>\n";
	}
?>