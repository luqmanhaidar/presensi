<?php
function FormRekap(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"cetak.rekap.bag.php\">";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<select name=\"bulan\">";
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
	//$fakk=$_SESSION['userdata']['Fak'];
	echo "<select name=\"jab\">";
	echo "<option value=\"Dosen\">Dosen</option>\n";
	echo "<option value=\"Karyawan\">Karyawan</option>\n";
	echo "</select>\n";
        $subag=fetchDistinct("adm_jurusan","where Jab='Karyawan'","(Fakultas)");
	echo "<select name=\"bag\">";
	echo "<option value=\"\"> -Biro / Fakultas- </option>\n";
	//echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[Fakultas]\">$s[Fakultas]</option>\n";
	}
	echo "<option value=\"PUSKOM\">PUSKOM</option>\n";
	echo "<option value=\"PERPUS\">PERPUS</option>\n";
	echo "<option value=\"P3AI\">P3AI</option>\n";
	echo "<option value=\"PASKA\">PASKA</option>\n";
	echo "</select>\n";
	//echo "<select name=\"hal\">";
        //echo "<option value=\"\"> -Pilih Halaman- </option>\n";
	//echo "<option value=\"all\">-Tampil Semua-</option>\n";
        //echo "<option value=\"0,20\">Hal 1</option>\n";
        //echo "<option value=\"20,20\">Hal 2</option>\n";
        //echo "<option value=\"40,20\">Hal 3</option>\n";
        //echo "<option value=\"60,20\">Hal 4</option>\n";
        //echo "<option value=\"80,20\">Hal 5</option>\n";
        //echo "<option value=\"100,20\">Hal 6</option>\n";
        //echo "<option value=\"120,20\">Hal 7</option>\n";
        //echo "</select>\n";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function AdmFormHk(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta </h1>";
	echo "<br />";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.hk.all.php\">";
	echo "<select name=\"Fak\" class=\"inputText\">";
	$fak =fetchRow("profile","","DISTINCT (Fak)");
	echo "<option value=\"0\">-Pilih Unit Kerja-</option>";
	foreach($fak as $f){
		echo "<option value=\"".$f['Fak']."\">".$f['Fak']."</option>";
	}
	echo "</select>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function AdmForm(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta </h1>";
	echo "<br />";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.all.php\">";
	echo "<select name=\"tahun\" class=\"inputTS\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<select name=\"bulan\" class=\"inputTS\">";
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
	echo "<select name=\"Fak\" class=\"inputTS\">";
	$fak =fetchRow("profile","","DISTINCT (Fak)");
	echo "<option value=\"0\">-Pilih Unit Kerja-</option>";
	foreach($fak as $f){
		echo "<option value=\"".$f['Fak']."\">".$f['Fak']."</option>";
	}
	echo "</select>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function FormHk(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.kar.hk.php\">";
	$fakk=$_SESSION['userdata']['Fak'];
        $subag=fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Karyawan'");
	echo "<select name=\"subbag\" class=\"inputText\">\n";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function FormHKBAUK(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.kar.hk.php\">";
	$fakk=$_SESSION['userdata']['Fak'];
        $subag=fetchRow("adm_jurusan","where Fakultas='BUPK' AND Bag='$fakk' AND Jab='Karyawan'");
	echo "<select name=\"subbag\" class=\"inputText\">\n";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function FormHKBPSI(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.kar.hk.php\">";
	$fakk=$_SESSION['userdata']['Fak'];
        $subag=fetchRow("adm_jurusan","where Fakultas='BAKI' AND Bag='$fakk' AND Jab='Karyawan'");
	echo "<select name=\"subbag\" class=\"inputText\">\n";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function FormRK (){
        echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.kar.ft.php\">";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<select name=\"bulan\">";
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
	$fakk=$_SESSION['userdata']['Fak'];
        $subag=fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Karyawan'");
	echo "<select name=\"subbag\">";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<select name=\"hal\">";
        echo "<option value=\"\"> -Pilih Halaman- </option>\n";
	echo "<option value=\"all\">-Tampil Semua-</option>\n";
        echo "<option value=\"0,20\">Hal 1</option>\n";
        echo "<option value=\"20,20\">Hal 2</option>\n";
        echo "<option value=\"40,20\">Hal 3</option>\n";
        echo "<option value=\"60,20\">Hal 4</option>\n";
        echo "<option value=\"80,20\">Hal 5</option>\n";
        echo "<option value=\"100,20\">Hal 6</option>\n";
        echo "<option value=\"120,20\">Hal 7</option>\n";
        echo "</select>\n";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function FormKaryawan ($_fakk){
        echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.karyawan.php\">";
	echo "<p class=\"right\">";
	echo "<label><b>Tahun</b></label>";
	echo "<select class=\"inputText\" name=\"tahun\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<label><b>Bulan</b></label>";
	echo "<select class=\"inputText\" name=\"bulan\">";
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
	echo "</p>";
	$fakk =$_SESSION['userdata']['Fak'];
	$bag  =$_SESSION['userdata']['ulname'];
	//echo $bag;
	switch($_fakk){
		case	"BUPK"	  :
			$subag=fetchRow("adm_jurusan","where bag='$fakk' AND Fakultas='BUPK' AND Jab='Karyawan'");
			break;
		case	"BAKI" :
			$subag=fetchRow("adm_jurusan","where bag='$fakk' AND Fakultas='BAKI' AND Jab='Karyawan'");
			break;
		default		  :
			$subag=fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Karyawan'");
			break;
	}
	echo "<label><b>Bagian / Jurusan</b></label>";
	echo "<select class=\"inputText\" name=\"subbag\">";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>\n";
	
	echo "<p class=\"left\">";
	echo "<label><b>Halaman</b></label>";
	echo "<select class=\"inputText\" name=\"hal\">";
        echo "<option value=\"\"> -Pilih Halaman- </option>\n";
	echo "<option value=\"all\">-Tampil Semua-</option>\n";
        echo "<option value=\"0,20\">Hal 1</option>\n";
        echo "<option value=\"20,20\">Hal 2</option>\n";
        echo "<option value=\"40,20\">Hal 3</option>\n";
        echo "<option value=\"60,20\">Hal 4</option>\n";
        echo "<option value=\"80,20\">Hal 5</option>\n";
        echo "<option value=\"100,20\">Hal 6</option>\n";
        echo "<option value=\"120,20\">Hal 7</option>\n";
        echo "</select>\n";
	echo "<br class=\"clear\">";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</p>";
	echo "<div class=\"clear\"></div>";
	echo "</form>\n";
}

/**
function FormBAUK(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.karyawan.php\">";
	echo "<select class=\"inputNM\" name=\"tahun\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<select class=\"inputNM\" name=\"bulan\">";
	echo "<option  >Bulan</option>\n";
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
	$fakk=$_SESSION['userdata']['Fak'];
        $subag=fetchRow("adm_jurusan","where Fakultas='BAUK' AND Bag='$fakk' AND Jab='Karyawan'");
	echo "<select class=\"inputNM\" name=\"subbag\">";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<select name=\"hal\">";
        echo "<option value=\"\"> -Pilih Halaman- </option>\n";
	echo "<option value=\"all\">-Tampil Semua-</option>\n";
        echo "<option value=\"0,20\">Hal 1</option>\n";
        echo "<option value=\"20,20\">Hal 2</option>\n";
        echo "<option value=\"40,20\">Hal 3</option>\n";
        echo "<option value=\"60,20\">Hal 4</option>\n";
        echo "<option value=\"80,20\">Hal 5</option>\n";
        echo "<option value=\"100,20\">Hal 6</option>\n";
        echo "<option value=\"120,20\">Hal 7</option>\n";
        echo "</select>\n";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}

function FormBAAKPSI(){
	echo "<div></div>";
	echo "<h1>Rekap Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.karyawan.php\">";
	echo "<select  class=\"inputNM\" name=\"tahun\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<select class=\"inputNM\" name=\"bulan\">";
	echo "<option >Bulan</option>\n";
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
	$fakk=$_SESSION['userdata']['Fak'];
        $subag=fetchRow("adm_jurusan","where Fakultas='BAAKPSI' AND Bag='$fakk' AND Jab='Karyawan'");
	echo "<select class=\"inputNM\" name=\"subbag\">";
	echo "<option value=\"\"> -Bagian / Jurusan- </option>\n";
	echo "<option value=\"all\"> -Tampil Semua- </option>\n";
	foreach ($subag as $s){
		echo "<option value=\"$s[JurId]\">$s[JurDet]</option>\n";
	}
	echo "</select>\n";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
}
**/

function FormDosen (){
        echo "<div></div>";
	echo "<h1>Rekap Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.dosen.php\">";
	echo "<p class=\"left\">";
	echo selectBT();
	echo "</p>";
	$fakk=$_SESSION['userdata']['Fak'];
	$userJur=$_SESSION['userdata']['uname'];
	switch ($userJur){
		case 'elka' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Elektronika'");
		case 'elktro' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Elektro'");
		break;
		case 'mesin' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Mesin'");
		break;
		case 'otomotif' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Otomotif'");
		break;
		case 'PTBB' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='BogaBusana'");
		break;
		case 'TSP' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='SipilPerencanaan'");
		break;
		default:
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen'");
		break;
	
	}
	//$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen'");
	echo "<p class=\"right\">";
	echo "<label><b>Jurusan</b></label>";
	echo "<select name=\"jurusan\" class=\"inputText\">";
	foreach ($row as $r) {
	echo "<option value=\"$r[JurId]\">$r[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<br clear=\"all\" />";
        echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	 echo "<div class=\"clear\"></div>";
	echo "</p>";
	echo "</form>\n";
}

function FormRekapDosen (){
        echo "<div></div>";
	echo "<h1>Rekap Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan dari tanggal ? sampai dengan Tanggal ?</p>";
	echo "<form method=\"post\" class=\"nice\" action=\"rekap.dos.php\">";
	echo "<table>";
	echo "<tr><td>Dari Tanggal</td><td>Sampai tanggal</td><td>Jurusan</td><td></td></tr>";
	echo "<tr><td><input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\"></td>";
	echo "<td><input class=\"dateinput\" name=\"end\" type=\"text\" id=\"end\"></td>";
	$fakk=$_SESSION['userdata']['Fak'];
	$userJur=$_SESSION['userdata']['uname'];
	switch ($userJur){
		case 'elka' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Elektronika'");
		case 'elktro' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Elektro'");
		break;
		case 'mesin' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Mesin'");
		break;
		case 'otomotif' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='Otomotif'");
		break;
		case 'PTBB' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='BogaBusana'");
		break;
		case 'TSP' :
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen' AND Jurid='SipilPerencanaan'");
		break;
		default:
		$row = fetchRow("adm_jurusan","where Fakultas='$fakk' AND Jab='Dosen'");
		break;
	
	}
	echo "<td><select name=\"jurusan\" class=\"dateinput\">";
	foreach ($row as $r) {
	echo "<option value=\"$r[JurId]\">$r[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "</td>";       
	echo "</tr>";
	echo "<tr><td> </td><td align=\"center\"><button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button></td><td> </td></tr>";
	echo "</table>";
	echo "</form>\n";
}
?>