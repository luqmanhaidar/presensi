<?php
$fakk=$_SESSION['userdata']['Fak'];

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
	echo "<p class=\"left\">";
	echo "<label><b>Tanggal</b></label>";
	echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
	echo "</p>";
	echo "<p class=\"right\">";
	$jur=fetchRow("adm_jurusan","where Jab='Dosen' order by Fakultas ASC");
	echo "<label>Jurusan</label>";
	echo "<select name=\"jur\" class=\"inputText\">";
	echo "<option>Pilih Jurusan</option>\n";
	foreach($jur as $t) {
		echo "<option value=\"$t[JurId]\">$t[JurDet]</option>\n";
	}
	echo "</select>\n";
	echo "<br clear=\"all\">";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>";
	echo "</p>";
	echo "<div class=\"clear\"></div>";
	echo "</form>\n";
	echo "<div><br /><br /></div>";
        $tanggal=stripslashes($_POST['tanggal']);
	$tahun=stripslashes($_POST['tahun']); 
	$bulan=stripslashes($_POST['bulan']);
	$jur=stripslashes($_POST['jur']);
        $tgl=$tahun.'-'.$bulan.'-'.$tanggal;
	$start=stripslashes($_POST['start']);
	$bt=$bulan.'-'.$tahun;
	$noUrut=1;
	if (isset($_POST['submit'])) //jk tombol submit ditekan
	{
		$query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
                            presensi.FotoMasuk, presensi.JamMasuk, presensi.Tanggal, presensi.id
                            FROM presensi, profile WHERE profile.Nama = presensi.login
                            AND profile.Jabatan = 'Dosen' AND profile.Jurusan = '$jur'
                            AND presensi.Tanggal = '$start' ORDER BY presensi.id DESC";
		$data = mysql_query($query);
		//echo $query;
		//echo "<div><br /></div>";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama</b> </th><th><b>Jurusan</b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Foto Masuk</b></th></tr>";	
		while ($hasil = mysql_fetch_assoc($data))
			{		
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".$hasil['Jurusan']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		if ($hasil['JamMasuk'] == '00:00:00')
		{
			echo "<td><b>IJIN</b></td>";
		}
		else
		{
			echo "<td>".$hasil['JamMasuk']."</td>";
		}
		echo "<td><a href=\"../".$hasil['FotoMasuk']."\" class=\"thickbox\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\"><img src='../".$hasil['FotoMasuk']."' width='100'></a></td></tr>";
		$noUrut++;
		}
		echo "</table>";
	}
}

function FormKaryawan () {
	$fakk=$_SESSION['userdata']['Fak'];
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
	echo "<label><b>Bagian / Fakultas</b></label>";
	echo "<select name=\"bagian\" class=\"dateinput\">";
        echo "<option value=\"\"> -Pilih Bagian- </option>\n";
        echo "<option value=\"FT\">Fakultas Teknik</option>\n";
        echo "<option value=\"FBS\">Fakultas Bahasa dan Seni</option>\n";
        echo "<option value=\"FIS\">Fakultas Ilmu Sosial</option>\n";
	echo "<option value=\"FE\">Fakultas Ekonomi</option>\n";
        echo "<option value=\"MIPA\">Fakultas MIPA</option>\n";
        echo "<option value=\"FIP\">Fakultas Ilmu Pendidikan</option>\n";
        echo "<option value=\"FIK\">Fakultas Ilmu Keolahragaan</option>\n";
        echo "<option value=\"PASKA\">Pascasarjana</option>\n";
        echo "<option value=\"BUPK\">BUPK</option>\n";
        echo "<option value=\"BAKI\">BAKI</option>\n";
        echo "<option value=\"PERPUS\">PERPUS</option>\n";
        echo "<option value=\"LPPM\">LPPM</option>\n";
        echo "<option value=\"PUSKOM\">PUSKOM</option>\n";
        echo "<option value=\"LPPMP\">LPPMP</option>\n";
	echo "<option value=\"WATES\">WATES</option>\n";
        echo "</select>\n";
	echo "<br clear=\"all\">";
	echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</p>";
	echo "<div class=\"clear\"></div>";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
        $bag=stripslashes($_POST['bagian']);
	$jur=stripslashes($_POST['jur']);
	$start=stripslashes($_POST['start']);
	$pecahTanggal = explode("-", $start);
        $tanggal = $pecahTanggal[2];
        $bulan   = $pecahTanggal[1];
        $tahun   = $pecahTanggal[0];
        //$tgl=$tahun.'-'.$bulan.'-'.$tanggal;
	//echo $tgl;
	$bt=$bulan.'-'.$tahun;
	$noUrut=1;
	if (isset($_POST['submit1'])) //jk tombol submit1 ditekan
		{
			/**
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
                            profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
                            presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal,
                            presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs, harikerja.Bulan,
                            harikerja.JmlHari FROM presensi, profile, harikerja
                            WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
                            AND profile.Fak='$bag' AND presensi.Tanggal = '$start'
                            AND harikerja.Bulan='$bt' ORDER BY presensi.id DESC LIMIT 0,200";
                            **/
		$query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih,
                            profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan,
                            presensi.id, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal,
                            presensi.FotoMasuk, presensi.FotoKeluar,presensi.abs FROM presensi, profile
                            WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
                            AND profile.Fak='$bag' AND presensi.Tanggal = '$start' ORDER BY presensi.id
			    DESC LIMIT 0,200";	
		$data = mysql_query($query);
		//echo $query;
		echo "<br />";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama </b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th><b>Jam Kerja</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Edit</b></th></tr>";
		while ($hasil = mysql_fetch_assoc($data))
			{
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['NamaLengkap']."</td><td>".dateConv($hasil['Tanggal'])."</td>";
		if($hasil['JamMasuk'] == '00:00:00' && $hasil['JamKeluar'] == '00:00:00')
		{
			echo "<td><b>Ijin</b></td><td><b>Ijin</b></td>";
		}else{
			echo "<td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td>";	
		}
		
		echo "<td>".$hasil['selisih']."</td><td><a href=\"../".$hasil['FotoMasuk']."\" title=\"Foto Masuk ".$hasil['NamaLengkap']."\" class=\"thickbox\"><img src='../".$hasil['FotoMasuk']."' width='95'></a></td><td><a href=\"../".$hasil['FotoKeluar']."\" class=\"thickbox\" title=\"Foto Keluar ".$hasil['NamaLengkap']."\"><img src='../".$hasil['FotoKeluar']."' width='95'></a></td><td><a href='adm.view.php?app=Karyawan&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
			}
		echo "</table>";
		}
		
	
}

function EditJabatan () {
	if ($_GET['app']== Dosen) { //jk type = Dosen tampilkan detail
			$id = abs ((int)$_GET['id']);
			$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jabatan,
                                profile.Jurusan, presensi.JamMasuk, presensi.JamKeluar, presensi.Tanggal,
                                presensi.FotoMasuk FROM presensi, profile WHERE profile.Nama = presensi.login
                                AND profile.Jabatan='Dosen' AND presensi.id = '$id'";
			$data = mysql_query($Query);
			echo "<p class='info'><b>Detail Presensi Dosen Universitas Negeri Yogyakarta</b><span>X</span></p>";
			echo "<div id='kotak'>";
			while ($hasil = mysql_fetch_assoc($data)) {
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
			$Query = "SELECT TIMEDIFF(JamKeluar,JamMasuk) AS selisih, profile.Nip,
                                    profile.NamaLengkap,profile.NamaLengkap, profile.Jabatan,
                                    profile.Jurusan, presensi.JamMasuk, presensi.JamKeluar,
                                    presensi.Tanggal, presensi.FotoMasuk,presensi.FotoKeluar
                                    FROM presensi, profile WHERE profile.Nama = presensi.login
                                    AND profile.Jabatan='Karyawan' AND presensi.id = '$id'";
			//$Query1 = "SELECT TIMEDIFF(JamKeluar,JamMasuk) AS selisih FROM presensi WHERE id = '$id'";
			//$data1 = mysql_query($Query1);
			$data = mysql_query($Query);
			echo "<p class='info'><b>Update data Presensi Universitas Negeri Yogyakarta</b><span>X</span></p>";
			echo "<div id='kotak'>";
			//$hasil1 = mysql_fetch_array($data1);
			while ($hasil = mysql_fetch_assoc($data)) {
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
                                echo "<option value=\"1\">Masuk</option>\n";
                                echo "<option value=\"0\">Tidak</option>\n";
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