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

function GwForm () {
	$jab=stripslashes($_GET['jab']);
	switch ($jab) {
		case 'Dosen': 
			FormDosen ();
			break;
		case 'Karyawan': 						
			FormKaryawan ();
			break;
		default : 
			FormDosen ();
			}
}

function FormDosen () {
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<div></div>";
	//echo "<div id='lipsum'>";
	echo "<h1>Presensi Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan Jurusan</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "<option value =\"2012\">2012</option>\n";
	echo "<option value =\"2013\">2013</option>\n";
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
	$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."'");
	echo "<select name=\"jur\">";
	echo "<option>Pilih Jurusan</option>\n";
	foreach($jur as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
	echo "<div><br /><br /></div>";
	$tahun=stripslashes($_POST['tahun']); 
	$bulan=stripslashes($_POST['bulan']);
	$jur=stripslashes($_POST['jur']);
	$bt=$bulan.'-'.$tahun;
	$noUrut=1;
	if (isset($_POST['submit'])) //jk tombol submit ditekan
	{
		$query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, presensi.id FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Dosen' AND profile.Jurusan = '$jur' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' ORDER BY presensi.JamMasuk DESC";
		$data = mysql_query($query);
		//echo "<div><br /></div>";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama</b> </th><th><b>Jurusan</b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Detail</b></th></tr>";	
		while ($hasil = mysql_fetch_array($data))
			{		
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Jurusan']."</td><td>".dateConv($hasil['Tanggal'])."</td><td>".$hasil['JamMasuk']."</td><td><a href='adm.lap.php?type=Dosen&mode=detail&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
		}
		echo "</table>";
	}
}

function FormKaryawan () {
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<div></div>";
	//echo "<div id='lipsum'>";
	echo "<h1>Presensi Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "<option value =\"2012\">2012</option>\n";
	echo "<option value =\"2013\">2013</option>\n";
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
	echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
	$tahun=stripslashes($_POST['tahun']); 
	$bulan=stripslashes($_POST['bulan']);
	$jur=stripslashes($_POST['jur']);
	$bt=$bulan.'-'.$tahun;
	$noUrut=1;
	if (isset($_POST['submit1'])) //jk tombol submit1 ditekan
		{
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, harikerja.Bulan, harikerja.JmlHari FROM presensi, profile, harikerja WHERE profile.Nama = presensi.login AND profile.Fak ='$fakk' AND profile.Jabatan = 'Karyawan' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND harikerja.Bulan='$bt' ORDER BY presensi.JamMasuk DESC";
		$data = mysql_query($query);
		//echo "<div><br /></div>";
		echo "<form name=\"form1\" method=\"post\" action=\"print.php\">";
		echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
		echo "<input type=\"submit\" name=\"Submit\" value=\"Cetak\" />";
		echo "</form><br />";
		//echo $bt;
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama </b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th><b>Jam Kerja</b></th><th><b>Hari Kerja</b></th><th><b>Detail</b></th></tr>";
		while ($hasil = mysql_fetch_array($data))
			{
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td><td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td><td>".$hasil['selisih']."</td><td>".$hasil['JmlHari']."</td><td><a href='adm.lap.php?type=Karyawan&mode=detail&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
			}
		echo "</table>";
		}
	
}

function TypeJabatan () {
	if ($_GET['type']== Dosen) { //jk type = Dosen tampilkan detail
			$id = abs ((int)$_GET['id']);
			$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan='Dosen' AND presensi.id = '$id'";
			$data = mysql_query($Query);
			echo "<p class=\"info\"><b>Detail Presensi Universitas Negeri Yogyakarta</b><span>X</span></p>";
			echo "<div id=\"kotak\">";
			while ($hasil = mysql_fetch_array($data)) {
				echo "<table>";
				echo "<tr><td><b>Nama</b></td><td>&nbsp; : ".$hasil['NamaLengkap']."&nbsp;".$hasil['NamaBelakang']."</td></tr>";
				echo "<tr><td><b>NIP</b></td><td>&nbsp; : ".$hasil['Nip']."</td></tr>";
				echo "<tr><td><b>Jabatan</b></td><td>&nbsp; : ".$hasil['Jabatan']."</td></tr>";
				echo "<tr><td><b>Jurusan</b></td><td>&nbsp; : ".$hasil['Jurusan']."</td></tr>";
				echo "<tr><td><b>Jam Masuk</b></td><td>&nbsp; : ".$hasil['JamMasuk']."</td></tr>";
				echo "</table>";
				echo "<table>";
				echo "<tr><td align =\"center\"> &nbsp;<img src='../".$hasil['FotoMasuk']."' width='200'></td></tr>";
				echo "<tr><td align =\"center\"><b>Foto Masuk</b></td></tr>";
				echo "</table>";
			}
			echo "</div>";
			echo "<br />";
			echo "<p class=\"success\"><b><a class=\"view_all\" href=\"$_SERVER[PHP_SELF]\">Kembali </a></b><span>X</span></p>";
		}
	elseif ($_GET['type']== Karyawan){ // jk type = Karyawan tampilkan detail
			$id = abs((int)$_GET['id']);
			$Query = "SELECT TIMEDIFF(JamKeluar,JamMasuk) AS selisih, profile.Nip, profile.NamaLengkap,profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk,presensi.FotoKeluar FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan='Karyawan' AND presensi.id = '$id'";
			//$Query1 = "SELECT TIMEDIFF(JamKeluar,JamMasuk) AS selisih FROM presensi WHERE id = '$id'";
			//$data1 = mysql_query($Query1);
			$data = mysql_query($Query);
			echo "<p class=\"info\"><b>Detail Presensi Teknik Universitas Negeri Yogyakarta</b><span>X</span></p>";
			echo "<div id=\"kotak\">";
			//$hasil1 = mysql_fetch_array($data1);
			while ($hasil = mysql_fetch_array($data)) {
				echo "<table>";
				echo "<tr><td><b>Nama</b></td><td>&nbsp; : ".$hasil['NamaLengkap']."</td></tr>";
				echo "<tr><td><b>NIP</b></td><td>&nbsp; : ".$hasil['Nip']."</td></tr>";
				echo "<tr><td><b>Jabatan</b></td><td>&nbsp; : ".$hasil['Jabatan']."</td></tr>";
				echo "<tr><td><b>Jam Masuk</b></td><td>&nbsp; : ".$hasil['JamMasuk']."</td></tr>";
				echo "<tr><td><b>Jam Keluar</b></td><td>&nbsp; : ".$hasil['JamKeluar']."</td></tr>";
				echo "<tr><td><b>Jumlah Jam Kerja</b></td><td>&nbsp; : ".$hasil['selisih']."</td></tr>";
				echo "</table>";
				echo "<table>";
				echo "<tr><td align =\"center\"> &nbsp;<img src='../".$hasil['FotoMasuk']."' width='200'></td><td>&nbsp;</td><td>&nbsp;</td><td align =\"center\"> &nbsp;<img src='../".$hasil['FotoKeluar']."' width='200'></td></tr>";
				echo "<tr><td align =\"center\"><b>Foto Masuk</b></td><td>&nbsp;</td><td>&nbsp;</td><td align =\"center\"><b>Foto Keluar</b></td></tr>";
				echo "</table>";
			}
			echo "</div>";
			echo "<br />";
			echo "<p class=\"success\"><b><a class=\"view_all\" href=\"$_SERVER[PHP_SELF]\">Kembali </a></b><span>X</span></p>";
		}
}
?>