<?php

function FormDosen(){
    $fakk=$_SESSION['userdata']['Fak'];
    echo "<br /><br />";
    echo "<h1>Jumlah Kehadiran Dosen Universitas Negeri Yogyakarta</h1>";
    echo "<br />";
    echo "<form method=\"post\" class=\"nice\">";
    echo "<table>";
    echo "<tr align=\"center\"><td><b>Dari Tanggal</b></td><td><b>Sampai Tanggal</b></td><td><b>Nama </b></td><td></td></tr>";
    echo "<tr><td>";
    echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
    echo "</td><td>";
    echo "<input class=\"dateinput\" name=\"end\" type=\"text\" id=\"end\">";
    echo "</td><td>";
    $UseJur=$_SESSION['userdata']['uname'];
    switch($UseJur){
	case 'elektro' :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Elektro' ORDER BY NamaLengkap ASC");
	break;
	case 'elka' :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Elektronika' ORDER BY NamaLengkap ASC");
	break;
	case 'mesin' :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Mesin' ORDER BY NamaLengkap ASC");
	break;
	case 'otomotif' :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='Otomotif' ORDER BY NamaLengkap ASC");
	break;
	case 'PTBB' :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='BogaBusana' ORDER BY NamaLengkap ASC");
	break;
	case 'TSP' :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' AND Jurusan='SipilPerencanaan' ORDER BY NamaLengkap ASC");
	break;
	default :
	$User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Dosen' ORDER BY NamaLengkap ASC");
	break;
    }
    
    echo "<select name=\"User\">";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
    echo "</select>\n";
    echo "</td><td>";
    echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
    echo "</td></tr>";
    echo "</table>";
    echo "</form>\n";
    TampilDosen();
}

/**
function FormBAUK(){
    $fakk=$_SESSION['userdata']['Fak'];
    echo "<br /><br />";
    echo "<h1>Jumlah Kehadiran Karyawan Universitas Negeri Yogyakarta</h1>";
    echo "<br />";
    echo "<form method=\"post\" class=\"nice\">";
    echo "<table>";
    echo "<tr align=\"center\"><td><b>Dari Tanggal</b></td><td><b>Sampai Tanggal</b></td></tr>";
    echo "<tr><td>";
    echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
    echo "</td><td>";
    echo "<input class=\"dateinput\" name=\"end\" type=\"text\" id=\"end\">";
    echo "</tr>";
    echo "<tr><td>";
    $User = fetchRow ("profile","where Fak='BAUK' AND bag='".$fakk."' AND Jabatan='Karyawan' ORDER BY Gol DESC");
    echo "<select class=\"inputNM\" name=\"User\">";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
    echo "</select>\n";
    echo "</td>";
    echo "<td><button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n</td></tr>";
    echo "</table>";
    echo "</form>\n";
    TampilKaryawan();
}

function FormBAAKPSI(){
    $fakk=$_SESSION['userdata']['Fak'];
    echo "<br /><br />";
    echo "<h1>Jumlah Kehadiran Karyawan Universitas Negeri Yogyakarta</h1>";
    echo "<br />";
    echo "<form method=\"post\" class=\"nice\">";
    echo "<table>";
    echo "<tr align=\"center\"><td><b>Dari Tanggal</b></td><td><b>Sampai Tanggal</b></td></tr>";
    echo "<tr><td>";
    echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
    echo "</td><td>";
    echo "<input class=\"dateinput\" name=\"end\" type=\"text\" id=\"end\">";
    echo "</tr>";
    echo "<tr><td>";
    $User = fetchRow ("profile","where Fak='BAAKPSI' AND bag='".$fakk."' AND Jabatan='Karyawan' ORDER BY Gol DESC");
    echo "<select class=\"inputNM\" name=\"User\">";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
    echo "</select>\n";
    echo "</td>";
    echo "<td><button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n</td></tr>";
    echo "</table>";
    echo "</form>\n";
    TampilKaryawan();
}

**/
function FromKaryawan($x_fakk){
    $fakk=$_SESSION['userdata']['Fak'];
    echo "<br /><br />";
    echo "<h1>Jumlah Kehadiran Karyawan Universitas Negeri Yogyakarta</h1>";
    echo "<br />";
    echo "<form method=\"post\" class=\"nice\">";
    echo "<p class=\"left\">";
    echo "<label><b>Dari Tanggal</b></label>";
    echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
    echo "<label><b>Sampai Tanggal</b></label>";
    echo "<input class=\"dateinput\" name=\"end\" type=\"text\" id=\"end\">";
    echo "</p>";
    echo "<p class=\"right\">";
    echo "<label><b>Nama</b></label>";
    switch($x_fakk){
	case	"BUPK"	:
	    $User = fetchRow ("profile","where Fak='BUPK' AND bag='".$fakk."' AND Jabatan='Karyawan' ORDER BY Gol DESC");
	    break;
	case	"BAKI":
	    $User = fetchRow ("profile","where Fak='BAKI' AND bag='".$fakk."' AND Jabatan='Karyawan' ORDER BY Gol DESC");
	    break;
	case	"WATES":
	    $User = fetchRow ("profile","where bag='WATES' AND Jabatan='Karyawan' ORDER BY Gol DESC");
	    break;
	default		:
	    $User = fetchRow ("profile","where Fak='".$fakk."' AND Jabatan='Karyawan' ORDER BY Gol DESC");
	    break;
    }
    echo "<select class=\"inputText\" name=\"User\">";
		echo "<option value=\"0\">-- Nama Lengkap --</option>\n";
	foreach ($User as $t) {
		echo "<option value=\"$t[Nama]\">$t[NamaLengkap]</option>\n";
	}
    echo "</select>\n";
    echo "<br clear=\"all\" />";
    echo "<br />";
    echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
    echo "</p>";
    echo "<div class=\"clear\"></div>";
    echo "</form>\n";
    TampilKaryawan ();
}

function TampilDosen (){
	$fakk  = $_SESSION['userdata']['Fak'];
	$start = $_POST['start'];
        $end   = $_POST['end'];
	$User  = $_POST['User'];
	$bt    = $bulan."-".$tahun;
	$noUrut= 1;
	if (isset($_POST['submit'])){
	$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login AND presensi.login = '$User'  ";
	$Data  = mysql_query($Query);
	$num_rows = mysql_num_rows($Data);
	echo "<form method=\"post\" action=\"cetak.hadir.dosen.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"start\" type=\"hidden\" value=\"$start\" />";
        echo "<input name=\"end\" type=\"hidden\" value=\"$end\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th></tr>";
	while ($Hasil=mysql_fetch_array($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".dateConv($Hasil['Tanggal'])."</td><td>".$Hasil['hari']."</td><td>".$Hasil['JamMasuk']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><th colspan=\"5\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$num_rows." Hari</th></tr>";
	echo "</table>";
	
	}
}


function TampilKaryawan (){
	//$bulan = stripslashes ($_POST['bulan']);
	//$tahun = stripslashes ($_POST['tahun']);
        $start = $_POST['start'];
        $end   = $_POST['end'];
	$User  = $_POST['User'];
	//$bt    = $bulan."-".$tahun;
	$noUrut= 1;
	if (isset($_POST['submit'])){
	$Query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
		profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
		presensi.id, presensi.JamMasuk, presensi.JamKeluar,presensi.FotoMasuk,
		presensi.FotoKeluar,presensi.Tanggal,
		date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile
		WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND presensi.Tanggal BETWEEN '$start' AND '$end' AND presensi.login ='$User' ORDER BY id ASC LIMIT 23";
	$Query1 = "SELECT NamaLengkap, Nip FROM profile WHERE Nama='$User' LIMIT 1";
	$Query2 = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$User' AND presensi.Tanggal BETWEEN '$start' AND '$end' LIMIT 23";
	$Query3 = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
	$Query4 = "SELECT id FROM presensi WHERE JamMasuk >=070100 AND login='$User'
		AND presensi.Tanggal BETWEEN '$start' AND '$end' LIMIT 23";
	$Query5 = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND login='$User'
		AND dayname( presensi.Tanggal ) <> 'friday' AND presensi.Tanggal BETWEEN '$start' AND '$end' LIMIT 23";
	$Query6 = "SELECT id FROM presensi WHERE presensi.Tanggal BETWEEN '$start' AND '$end'
		AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 LIMIT 23";
	$Query7 = "SELECT id FROM presensi WHERE presensi.Tanggal BETWEEN '$start' AND '$end'
		AND login = '$User' LIMIT 23";
	$Query8 = "SELECT id FROM presensi WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959
		AND presensi.Tanggal BETWEEN '$start' AND '$end' AND dayname( presensi.Tanggal ) <> 'friday'";
	$Query9 = "SELECT id FROM presensi WHERE login='$User' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959
		AND presensi.Tanggal BETWEEN '$start' AND '$end' AND dayname( presensi.Tanggal ) = 'friday'";
	$Data1  = mysql_query($Query1);
	$Data   = mysql_query($Query);
	$Data2  = mysql_query($Query2);
	$Data3  = mysql_query($Query3);
	$Data4  = mysql_query($Query4);
	$Data5  = mysql_query($Query5);
	$Data6  = mysql_query($Query6);
	$Data7  = mysql_query($Query7);
	$Data8  = mysql_query($Query8);
	$Data9  = mysql_query($Query9); 
	$bolos  = mysql_num_rows($Data5);
	$bolos1 = mysql_num_rows($Data6);
	$bolos2 = mysql_num_rows($Data8);
	$bolos3 = mysql_num_rows($Data9);
	$telat  = mysql_num_rows($Data4);
	$ttlbolos  = $bolos + $bolos1+$bolos2+$bolos3;
	$kehadiran = mysql_num_rows($Data7);
	$Hasil1    = mysql_fetch_assoc($Data2);
	$Hasil2    = mysql_fetch_assoc($Data3);
	$Hasil     = mysql_fetch_assoc($Data1);
	//echo "<table>";
	//echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Hasil['NamaLengkap']."</td></tr>";
	//echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Hasil['Nip']."</td></tr>";
	//echo "</table>";
	echo "<form method=\"post\" action=\"cetak.hadir.kar.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"start\" type=\"hidden\" value=\"$start\" />";
        echo "<input name=\"end\" type=\"hidden\" value=\"$end\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>Tanggal</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Datang</b></th><th><b>Pulang</b></th><th><b>JamKerja</b></th></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td><td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$hasil['FotoKeluar']."\" title=\"Foto Keluar ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoKeluar']."' width='95'></a></td><td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td><td>".$hasil['selisih']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja</b></th><th>".$Hasil1['jumlah']."</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kehadiran</b></th><th>".$kehadiran."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Datang Terlambat</b></th><th>".$telat."&nbsp;Kali</th></tr>";
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Pulang Awal</b></th><th>".$ttlbolos."&nbsp;Kali</th></tr>";
	echo "</table>";
	$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
	
	}
}
?>