<?php
include ("koneksi.php");
function DaftarKaryawan(){
	echo "<br /><br />";
	echo "<h1>Daftar Hadir Karyawan Fakultas Teknik</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<table>";
	echo "<tr align=\"center\"><td><b>Tahun</b></td><td><b>Bulan</b></td><td><b>Nama</b></td><td></td></tr>";
	echo "<tr><td>";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "</select>";
	echo "</td><td>";
	echo "<select name=\"bulan\">";
	echo "<option>Bulan</option>\n";
	echo "<option value=\"1\">Januari</option>\n";
	echo "<option value=\"2\">Februari</option>\n";
	echo "<option value=\"3\">Maret</option>\n";
	echo "<option value=\"4\">April</option>\n";
	echo "<option value=\"5\">Mei</option>\n";
	echo "<option value=\"6\">Juni</option>\n";
	echo "<option value=\"7\">Juli</option>\n";
	echo "<option value=\"8\">Agustus</option>\n";
	echo "<option value=\"9\">September</option>\n";
	echo "<option value=\"10\">Oktober</option>\n";
	echo "<option value=\"11\">November</option>\n";
	echo "<option value=\"12\">Desember</option>\n";
	echo "</select>\n";
	echo "</td><td>";
	echo "<input type=\"text\" name=\"User\" value=\"\" >\n";
	echo "</td><td>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>\n";
	TampilKaryawan ();
}

function DaftarDosen(){
	echo "<br /><br />";
	echo "<h1>Daftar Hadir Dosen Fakultas Teknik</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun Bulan dan nama untuk login</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<table>";
	echo "<tr align=\"center\"><td><b>Tahun</b></td><td><b>Bulan</b></td><td><b>Nama </b></td><td></td></tr>";
	echo "<tr><td>";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
	echo "<option value =\"2009\">2009</option>\n";
	echo "<option value =\"2010\">2010</option>\n";
	echo "<option value =\"2011\">2011</option>\n";
	echo "</select>";
	echo "</td><td>";
	echo "<select name=\"bulan\">";
	echo "<option>Bulan</option>\n";
	echo "<option value=\"1\">Januari</option>\n";
	echo "<option value=\"2\">Februari</option>\n";
	echo "<option value=\"3\">Maret</option>\n";
	echo "<option value=\"4\">April</option>\n";
	echo "<option value=\"5\">Mei</option>\n";
	echo "<option value=\"6\">Juni</option>\n";
	echo "<option value=\"7\">Juli</option>\n";
	echo "<option value=\"8\">Agustus</option>\n";
	echo "<option value=\"9\">September</option>\n";
	echo "<option value=\"10\">Oktober</option>\n";
	echo "<option value=\"11\">November</option>\n";
	echo "<option value=\"12\">Desember</option>\n";
	echo "</select>\n";
	echo "</td><td>";
	echo "<input type=\"text\" name=\"User\" value=\"\" >\n";
	echo "</td><td>";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>\n";
	TampilDosen ();
}

function TampilDosen (){
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$User = $_POST['User'];
	$bt = $bulan."-".$tahun;
	$noUrut=1;
	if (isset($_POST['submit'])){
	$Query = "SELECT profile.Nip, profile.NamaLengkap, profile.Jurusan, presensi.JamMasuk, presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Jabatan='Dosen' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND profile.Nama=presensi.login AND presensi.login = '$User'  ";
	$Data = mysql_query($Query);
	$num_rows = mysql_num_rows($Data);
	echo "<form method=\"post\" action=\"prints.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th></tr>";
	while ($Hasil=mysql_fetch_array($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".$Hasil['Tanggal']."</td><td>".$Hasil['hari']."</td><td>".$Hasil['JamMasuk']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><th colspan=\"5\" class=\"pagination\" scope=\"col\" ><b>Jumlah Kedatangan</b></th><th>".$num_rows." Hari</th></tr>";
	echo "</table>";
	$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /></p> ";
	}
}


function TampilKaryawan (){
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$User = $_POST['User'];
	$bt = $bulan."-".$tahun;
	$noUrut=1;
	if (isset($_POST['submit'])){
	$Query = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih, profile.Nip, profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk, presensi.JamKeluar,presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi, profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan' AND date_format(presensi.Tanggal, '%m-%Y') = '$bt' AND presensi.login ='$User'";
	$Query1 = "SELECT * FROM profile WHERE Nama='$User'";
	$Query2 = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah FROM presensi WHERE login='$User'";
	$Query3 = "SELECT * FROM harikerja WHERE Bulan='$bt'";
	$Data1 = mysql_query($Query1);
	$Data = mysql_query($Query);
	$Data2 = mysql_query($Query2);
	$Data3 = mysql_query($Query3);
	$Hasil1 = mysql_fetch_array($Data2);
	$Hasil2 = mysql_fetch_array($Data3);
	$Hasil = mysql_fetch_array($Data1);
	echo "<form method=\"post\" action=\"printz.php\">";
	echo "<input name=\"Nama\" type=\"hidden\" value=\"$User\" />";
	echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
	echo "<button type=\"submit\" class=\"green\" name=\"submit\">Cetak</button>\n";
	echo "</form>";
	echo "<br />";
	echo "<table width=\"100%\" id=\"data\">";
	echo "<tr><th><b>No</b></th><th><b>Nama</b></th><th><b>NIP</b></th><th><b>Tanggal</b></th><th><b>Hari</b></th><th><b>Datang</b></th><th><b>Pulang</b></th><th><b>JamKerja</b></th></tr>";
	while ($hasil=mysql_fetch_array($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$Hasil['NamaLengkap']."</td><td>".$Hasil['Nip']."</td><td>".$hasil['Tanggal']."</td><td>".$hasil['hari']."</td><td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td><td>".$hasil['selisih']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><th colspan=\"7\" class=\"pagination\" scope=\"col\" ><b>Jumlah Jam Kerja</b></th><th>".$Hasil1['jumlah']."</th></tr>";
	echo "</table>";
	$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
	echo "<p><b>Keterangan :</b><br />";
	echo "a. Data Kehadiran Berdasarkan database dalam FT-CAM Attendace System<br>";
	echo "b. Ketidaksesuaian dapat terjadi karena tidak ingatnya karyawan melakukan presensi saat datang /pulang kerja.<br /> ";
	echo "c. Jumlah kerja Normal Bulan ini : <b>".$Hasil2['JamKerja']."</b> Jam<br />";
	echo "d. Jumlah real jam yang bersangkutan dalam bulan ini:<b> ".$Hasil1['jumlah']."</b> Jam<br />";
	echo "e. Kekurangan jam kerja yang bersangkutan untuk bulan ini:<b> ".$kekurangan."</b> Jam<br />";
	echo "f. Kelebihan jam kerja yang bersangkutan untuk bulan ini</p>";
	}
}
?>