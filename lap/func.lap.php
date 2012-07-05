<?php
$fakk=$_SESSION['userdata']['Fak'];
function GwForm () {
	$jab=stripslashes($_GET['jab']);
	switch ($jab) {
		case 'Dosen':
                        //define("ACCESS","view_dosen");
			FormDosen ();
                        
			break;
		case 'Karyawan':
                        //define("ACCESS","view_karyawan");
			FormKaryawan ();
			break;
		default : 
			FormKaryawan ();
			}
}

function FormDosen () {
	$fakk=$_SESSION['userdata']['Fak'];
	echo "<div></div>";
	//echo "<div id='lipsum'>";
	echo "<h1>Presensi Dosen Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan Jurusan</p>";
	
	echo "<form method=\"post\" class=\"nice\">";
	/*
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
        echo "</select>\n";
        echo "<select name=\"tanggal\">";
        echo "<option>Tgl</option>\n";
            for ($i=1; $i<=31 ; $i++) {
            echo "<option value=\"$i\">".$i."</option>\n";
        }
	echo "</select>\n";
	*/
	echo "Tanggal: <input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
	$userjur=$_SESSION['userdata']['uname'];
	switch ($userjur){
		case 'elka' :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='Elektronika'");
		break;
		case 'elektro' :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='Elektro'");
		break;
		case 'mesin' :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='Mesin'");
		break;
		case 'otomotif' :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='Otomotif'");
		break;
		case 'TSP' :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='SipilPerencanaan'");
		break;
		case 'PTBB' :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='BogaBusana'");
		break;
		default :
		$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND Jab <> 'Karyawan'");
		break;
	}
	//$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND Jab <> 'Karyawan'");
	echo "<select name=\"jur\">";
	echo "<option>Pilih Jurusan</option>\n";
	foreach($jur as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</form>\n";
	echo "<div><br /><br /></div>";
       $jur=stripslashes($_POST['jur']);
	$start=$_POST['start'];
       $pecahTanggal = explode("-", $start);
       $tanggal = $pecahTanggal[2];
       $bulan   = $pecahTanggal[1];
       $tahun   = $pecahTanggal[0];
	$bt=$bulan.'-'.$tahun;
	$noUrut=1;
	if (isset($_POST['submit'])) //jk tombol submit ditekan
	{
		$query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.FotoMasuk, presensi.JamMasuk, presensi.Tanggal, presensi.id FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Dosen' AND profile.Jurusan = '$jur' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC";
		$data = mysql_query($query);
		//echo "<div><br /></div>";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama</b> </th><th><b>Jurusan</b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Foto Masuk</b></th></tr>";	
		while ($hasil = mysql_fetch_array($data))
			{		
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Jurusan']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		if($hasil['JamMasuk'] == '00:00:00'){
			echo "<td><b>Izin / Tugas</b></td>";
		}else{
			echo "<td>".$hasil['JamMasuk']."</td>";	
		}
		
		echo "<td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='100'></a></td></tr>";
		$noUrut++;
		}
		echo "</table>";
	}
}

function FormKaryawan ($x_fakk) {
	$fakk =$_SESSION['userdata']['Fak'];
	$bag  =$_SESSION['userdata']['ulname'];
	//include ("func_date.php");
	echo "<div></div>";
	echo "<h1>Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<p class=\"left\">";
	echo "<label><b>Tanggal</b></label>";
	echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
	echo "</p>";
	echo "<p class=\"right\">";
	echo "<label><b>Sub Bag</b></label>";
	switch($x_fakk){
		case	"BUPK"	:
			$subag=fetchRow("adm_jurusan","where bag='".$fakk."' and Jab='Karyawan'");
			break;
		case	"BAKI" :
			$subag=fetchRow("adm_jurusan","where bag='".$fakk."' and Jab='Karyawan'");
			break;
		default		:
			$subag=fetchRow("adm_jurusan","where Fakultas='".$fakk."' and Jab='Karyawan'");
			break;
	}
	echo "<select class=\"inputText\" name=\"subbag\">";
	//echo "<option value=\"\">Sub.Bag</option>\n";
	echo "<option value=\"all\">-Tampil Semua-</option>\n";
	foreach($subag as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "<option value=\"Umper/Cleaning\">Cleaning</option>\n";
	echo "</select>\n";
	echo "<br clear=\"all\" />";
	echo "<br />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</p>";
	
	echo "<div class=\"clear\"></div>";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
	$start=$_POST['start'];
	$subbag=$_POST['subbag'];
       $pecahTanggal = explode("-", $start);
       $tanggal = $pecahTanggal[2];
       $bulan   = $pecahTanggal[1];
       $tahun   = $pecahTanggal[0];
	$jur	 = stripslashes($_POST['jur']);
      	$bt      = $bulan.'-'.$tahun;
	$noUrut  = 1;
	if (isset($_POST['submit1'])) //jk tombol submit1 ditekan
		{
			//print_r($_POST);
		if($_POST['subbag']=="all"){
			switch($bag){
				case	"BUPK"	:
					$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='BUPK' AND profile.bag='$fakk' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
					break;
				case	"BAKI" :
					$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='BAKI' AND profile.bag='$fakk' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
					break;
				case	"WATES" :
					$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.bag='$bag' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
					break;
				default		:
					$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='$fakk' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
					break;
			}
		
	}else{
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='$fakk' AND profile.Jurusan='$subbag' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
		}
		
		$data = mysql_query($query);
		//echo $fakk;
		//echo "<form name=\"form1\" method=\"post\" action=\"print.php\">";
		//echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
		//echo "<button type=\"submit\" name=\"Submit\" class=\"green\" />Cetak</button>";
		//echo "</form><br />";
		//echo $query;
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama </b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th><b>Jam Kerja</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Edit</b></th></tr>";
		while ($hasil = mysql_fetch_array($data))
			{
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		if($hasil['JamMasuk'] == '00:00:00'){
			echo "<td>IZIN/ TUGAS DINAS</td><td>IZIN/ TUGAS DINAS</td>";
		}else{
			echo "<td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td>";
		}
		if($hasil['hari']== 'Fri'){
			$jam= temdif('01:30:00',$hasil['selisih']);
			echo "<td>$jam</td>";
		}else{
			$jam= temdif('00:30:00',$hasil['selisih']);
			echo "<td>$jam</td>";
		}
		echo "<td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$hasil['FotoKeluar']."\" title=\"Foto Keluar ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoKeluar']."' width='95'></a></td><td><a href='adm.view.kar.php?app=Karyawan&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
			}
		echo "</table>";
		}
	
}

function FormBAUK(){
	$bag=$_SESSION['userdata']['Fak'];
	//include ("func_date.php");
	echo "<div></div>";
	echo "<h1>Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "Tanggal: <input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
	$subag=fetchRow("adm_jurusan","where bag='".$bag."' and Jab='Karyawan'");
	/**
	echo "<select name=\"subbag\">";
	echo "<option value=\"\">Sub.Bag</option>\n";
	echo "<option value=\"all\">Tampil Semua</option>\n";
	foreach($subag as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "<option value=\"Umper/Cleaning\">Cleaning</option>\n";
	echo "</select>\n";
	**/
        echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
       $start=$_POST['start'];
	$subbag=$_POST['subbag'];
       $pecahTanggal = explode("-", $start);
       $tanggal = $pecahTanggal[2];
       $bulan   = $pecahTanggal[1];
       $tahun   = $pecahTanggal[0];
	$jur	 = stripslashes($_POST['jur']);
      	$bt      = $bulan.'-'.$tahun;
	$noUrut  = 1;
	if (isset($_POST['submit1'])) //jk tombol submit1 ditekan
		{
		//if($_POST['subbag']=="all"){
			
		//$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='$fakk' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
	//}else{
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='BAUK' AND profile.bag='$bag' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
		//}
		
		$data = mysql_query($query);
		//echo $fakk;
		//echo "<form name=\"form1\" method=\"post\" action=\"print.php\">";
		//echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
		//echo "<button type=\"submit\" name=\"Submit\" class=\"green\" />Cetak</button>";
		//echo "</form><br />";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama </b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th><b>Jam Kerja</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Edit</b></th></tr>";
		while ($hasil = mysql_fetch_array($data))
			{
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		if($hasil['JamMasuk'] == '00:00:00'){
			echo "<td>IZIN/ TUGAS DINAS</td><td>IZIN/ TUGAS DINAS</td>";
		}else{
			echo "<td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td>";
		}
		if($hasil['hari']== 'Fri'){
			$jam= temdif('01:30:00',$hasil['selisih']);
			echo "<td>$jam</td>";
		}else{
			$jam= temdif('00:30:00',$hasil['selisih']);
			echo "<td>$jam</td>";
		}
		echo "<td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$hasil['FotoKeluar']."\" title=\"Foto Keluar ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoKeluar']."' width='95'></a></td><td><a href='adm.view.kar.php?app=Karyawan&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
			}
		echo "</table>";
		}
}

function FormBAAKPSI(){
	$bag=$_SESSION['userdata']['Fak'];
	//echo $bag;
	echo "<div></div>";
	echo "<h1>Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "Tanggal: <input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
	$subag=fetchRow("adm_jurusan","where bag='".$bag."' and Jab='Karyawan'");
	
	echo "<select name=\"subbag\">";
	echo "<option value=\"\">Sub.Bag</option>\n";
	echo "<option value=\"all\">Tampil Semua</option>\n";
	foreach($subag as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "<option value=\"Umper/Cleaning\">Cleaning</option>\n";
	echo "</select>\n";
	
        echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
       $start=$_POST['start'];
	$subbag=$_POST['subbag'];
       $pecahTanggal = explode("-", $start);
       $tanggal = $pecahTanggal[2];
       $bulan   = $pecahTanggal[1];
       $tahun   = $pecahTanggal[0];
	$jur	 = stripslashes($_POST['jur']);
      	$bt      = $bulan.'-'.$tahun;
	$noUrut  = 1;
	if (isset($_POST['submit1'])) //jk tombol submit1 ditekan
		{
		if($_POST['subbag']=="all"){
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='BAAKPSI' AND profile.bag='$bag' AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
	}else{
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,date_format(presensi.Tanggal,'%a') as hari, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND profile.Fak='BAAKPSI' AND profile.bag='$bag' AND Jurusan='$subbag'AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC LIMIT 0,125";
		}
		//echo $query;
		$data = mysql_query($query);
		//echo $fakk;
		//echo "<form name=\"form1\" method=\"post\" action=\"print.php\">";
		//echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
		//echo "<button type=\"submit\" name=\"Submit\" class=\"green\" />Cetak</button>";
		//echo "</form><br />";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama </b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th><b>Jam Kerja</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Edit</b></th></tr>";
		while ($hasil = mysql_fetch_array($data))
			{
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		if($hasil['JamMasuk'] == '00:00:00'){
			echo "<td>IZIN/ TUGAS DINAS</td><td>IZIN/ TUGAS DINAS</td>";
		}else{
			echo "<td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td>";
		}
		if($hasil['hari']== 'Fri'){
			$jam= temdif('01:30:00',$hasil['selisih']);
			echo "<td>$jam</td>";
		}else{
			$jam= temdif('00:30:00',$hasil['selisih']);
			echo "<td>$jam</td>";
		}
		echo "<td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$hasil['FotoKeluar']."\" title=\"Foto Keluar ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoKeluar']."' width='95'></a></td><td><a href='adm.view.kar.php?app=Karyawan&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
			}
		echo "</table>";
		}
}

function EditJabatan () {
	if ($_GET['app']== Dosen) { //jk type = Dosen tampilkan detail
			$id = abs ((int)$_GET['id']);
			$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk, presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan='Dosen' AND presensi.id = '$id'";
			$data = mysql_query($Query);
			echo "<p class='info'><b>Detail Presensi Dosen Universitas Negeri Yogyakarta</b><span>X</span></p>";
			echo "<div id='kotak'>";
			while ($hasil = mysql_fetch_array($data)) {
				echo "<table>";
				echo "<tr><td><b>Nama</b></td><td>&nbsp; : ".$hasil['NamaLengkap']."&nbsp;".$hasil['NamaBelakang']."</td></tr>";
				echo "<tr><td><b>NIP</b></td><td>&nbsp; : ".$hasil['Nip']."</td></tr>";
				echo "<tr><td><b>Jabatan</b></td><td>&nbsp; : ".$hasil['Jabatan']."</td></tr>";
				echo "<tr><td><b>Jurusan</b></td><td>&nbsp; : ".$hasil['Jurusan']."</td></tr>";
				echo "<tr><td><b>Jam Masuk</b></td><td>&nbsp; : ".$hasil['JamMasuk']."</td></tr>";
				echo "</table>";
				echo "<table>";
				echo "<tr><td align ='center'> &nbsp;<img src='../".$hasil['FotoMasuk']."' width='200'></td></tr>";
				echo "<tr><td align ='center'><b>Foto Masuk</b></td></tr>";
				echo "</table>";
			}
			echo "</div>";
			echo "<br />";
			echo "<p class='success'><b><a class='view_all' href='javascript:history.back()'>Kembali </a></b><span>X</span></p>";
		}
	elseif ($_GET['app']== Karyawan){ // jk type = Karyawan tampilkan detail
			$id = abs((int)$_GET['id']);
			$Query = "SELECT TIMEDIFF(JamKeluar,JamMasuk) AS selisih, profile.Nip, profile.NamaLengkap,profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal, presensi.FotoMasuk,presensi.FotoKeluar,presensi.abs FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan='Karyawan' AND presensi.id = '$id'";
			//$Query1 = "SELECT TIMEDIFF(JamKeluar,JamMasuk) AS selisih FROM presensi WHERE id = '$id'";
			//$data1 = mysql_query($Query1);
			$data = mysql_query($Query);
			echo "<p class='info'><b>Update data Presensi Universitas Negeri Yogyakarta</b><span>X</span></p>";
			echo "<div id='kotak'>";
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
				echo "<tr><td align ='center'> &nbsp;<img src='../".$hasil['FotoMasuk']."' width='200'></td><td>&nbsp;</td><td>&nbsp;</td><td align ='center'> &nbsp;<img src='../".$hasil['FotoKeluar']."' width='200'></td></tr>";
				echo "<tr><td align ='center'><b>Foto Masuk</b></td><td>&nbsp;</td><td>&nbsp;</td><td align ='center'><b>Foto Keluar</b></td></tr>";
                                echo "</table>";
                                echo "<p><b>Presensi Pegawai Atas Nama ".$hasil['NamaLengkap']." dinyatakan :</b></p>";
                                echo "<form method=\"post\" >";
                                echo "<select name=\"publish\">";
                               if ($hasil['abs']=='1'){
                                    echo "<option value=\"1\" SELECTED>Masuk</option>\n";
                                    echo "<option value=\"0\">Tidak</option>\n";
                                }else{
                                    echo "<option value=\"1\">Masuk</option>\n";
                                    echo "<option value=\"0\" SELECTED>Tidak</option>\n";
                                }                               
					echo "</select><br /><br />";
                                echo "<button type=\"submit\" name=\"kirim\" class=\"green\">Simpan</button>";
                                echo "</form>";
                                if (isset($_POST['kirim'])) {
                                    $publish=$_POST['publish'];
                                   // echo $publish;
                                    //echo "<br />";
                                    //echo $id;
                                    $query = "UPDATE presensi SET abs='$publish' WHERE id='$id'";
                                    if ($hasil = mysql_query($query)) {
                                        $pesan= "Update data dengan ID $id telah berhasil<br />";
                                    }
                                }
			}
			echo "</div>";
                        echo "<br />";
			echo "<p class=\"success\"><b><a class=\"view_all\" href=\"".$_SERVER['PHP_SELF']."\"> $pesan Kembali</a></b><span>X</span></p>";
		}
}

?>