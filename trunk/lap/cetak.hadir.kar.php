<style type="text/css">
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	padding: 3px;
}
tr {
	height: 20px;
}
.tableContent{
	border-top-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-left-color: #000000;
}
.tableContent td{
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	border-right-width: 1px;
	border-right-style: solid;
	border-right-color: #000000;
}
#td{
	padding: 0px;
	height: 10px;
}

</style>
<?
include ("../koneksi.php");
	//$bt     = $_POST['bt'];
	//$Nip    = $_POST['Nip'];
        $start  = mysql_escape_string($_POST['start']);
        $end    = mysql_escape_string($_POST['end']);
	$Nama   = mysql_escape_string($_POST['Nama']);
	$noUrut = 1;
	$Query  = "SELECT TIMEDIFF(presensi.JamKeluar,presensi.JamMasuk) AS selisih, profile.Nip,
		profile.NamaLengkap, profile.Jabatan, profile.Jurusan, presensi.id, presensi.JamMasuk,
		presensi.JamKeluar,presensi.Tanggal, date_format(presensi.Tanggal,'%a') AS hari FROM presensi,
		profile WHERE profile.Nama = presensi.login AND profile.Jabatan = 'Karyawan'
		AND presensi.Tanggal BETWEEN '$start' AND '$end' AND presensi.login ='$Nama' ORDER BY id ASC";
	$Query1 = "SELECT DISTINCT NamaLengkap, Nip FROM profile WHERE Nama='$Nama'";
	$Query2 = "SELECT sec_to_time( SUM( time_to_Sec( TIMEDIFF( JamKeluar, JamMasuk ) ) ) ) AS jumlah
		FROM presensi WHERE login='$Nama' AND presensi.Tanggal BETWEEN '$start' AND '$end'";
	$Query3 = "SELECT Bulan, JmlHari, JamKerja FROM harikerja WHERE Bulan='$bt' LIMIT 1";
	$Query4 = "SELECT id FROM presensi WHERE JamMasuk >=070100 AND login='$Nama'
		AND presensi.Tanggal BETWEEN '$start' AND '$end' LIMIT 23";
	$Query5 = "SELECT id FROM presensi WHERE JamKeluar <=152959 AND login='$Nama'
		AND dayname( presensi.Tanggal ) <> 'friday' AND presensi.Tanggal BETWEEN '$start' AND '$end' LIMIT 23";
	$Query7 = "SELECT id FROM presensi WHERE presensi.Tanggal BETWEEN '$start' AND '$end'
		AND dayname( presensi.Tanggal ) = 'friday' AND login = '$User' AND JamKeluar <=135959 LIMIT 23";
	$Query6 = "SELECT id FROM presensi WHERE login='$Nama' AND presensi.Tanggal BETWEEN '$start' AND '$end' LIMIT 23";
	$Query8 = "SELECT id FROM presensi WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=152959
		AND presensi.Tanggal BETWEEN '$start' AND '$end' AND dayname( presensi.Tanggal ) <> 'friday'";
	$Query9 = "SELECT id FROM presensi WHERE login='$Nama' AND JamKeluar IS NULL AND abs='0' AND JamMasuk <=135959
		AND presensi.Tanggal BETWEEN '$start' AND '$end' AND dayname( presensi.Tanggal ) = 'friday'";
	$Data1 = mysql_query($Query1);
	$Data  = mysql_query($Query);
	$Data2 = mysql_query($Query2);
	$Data3 = mysql_query($Query3);
	$Data4 = mysql_query($Query4);
	$Data5 = mysql_query($Query5);
	$Data6 = mysql_query($Query6);
	$Data7 = mysql_query($Query7);
	$Data8  = mysql_query($Query8);
	$Data9  = mysql_query($Query9); 
	$bolos = mysql_num_rows($Data5);
	$bolos1= mysql_num_rows($Data7);
	$bolos2 = mysql_num_rows($Data8);
	$bolos3 = mysql_num_rows($Data9);
	$ttlbolos  = $bolos+$bolos1+$bolos2+$bolos3;
	$telat     = mysql_num_rows($Data4);
	$kehadiran = mysql_num_rows($Data6);
	$Hasil1    = mysql_fetch_assoc($Data2);
	$Hasil2    = mysql_fetch_assoc($Data3);
	$Hasil     = mysql_fetch_assoc($Data1);
	//echo "Nip:".$Nip."";
	//echo "Nama:".$_POST['Nama']."";
	echo "<h1 align=\"center\">DAFTAR KEHADIRAN<br>";
	echo "KARYAWAN UNIVERSITAS NEGERI YOGYAKARTA</h1>";
	//echo "<h2 align=\"center\">Bulan: &nbsp;".$bt."</h2>";
	echo "<table>";
	echo "<tr><td><b>Nama&nbsp;</b></td><td>:&nbsp;".$Hasil['NamaLengkap']."</td></tr>";
	echo "<tr><td><b>NIP / ID&nbsp;</b></td><td>:&nbsp;".$Hasil['Nip']."</td></tr>";
	echo "</table>";
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class=\"tableContent\">";
	echo "<tr><td><b>No</b></td><td><b>Tanggal</b></td><td><b>Hari</b></td><td><b>Datang</b></td><td><b>Pulang</b></td><td><b>JamKerja</b></td></tr>";
	while ($hasil=mysql_fetch_assoc($Data)) {
	echo "<tr><td>".$noUrut."</td><td>".$hasil['Tanggal']."</td><td>".$hasil['hari']."</td><td>&nbsp;".$hasil['JamMasuk']."</td><td>&nbsp;".$hasil['JamKeluar']."</td><td>&nbsp;".$hasil['selisih']."</td></td></tr>";
	$noUrut++;
	}
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Jam Kerja</b></td><td>".$Hasil1['jumlah']."</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Kehadiran</b></td><td>".$kehadiran."&nbsp;Kali</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Datang Terlambat</b></td><td>".$telat."&nbsp;Kali</td></tr>";
	echo "<tr><td colspan=\"5\" scope=\"col\" ><b>Jumlah Pulang Awal</b></td><td>".$ttlbolos."&nbsp;Kali</td></tr>";
	echo "</table>";
	$kekurangan = $Hasil2['JamKerja'] -$Hasil1['jumlah'];
?>