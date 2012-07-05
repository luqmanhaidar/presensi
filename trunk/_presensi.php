<?php
include_once("koneksi.php");
if ($_GET['i'] === ''){
	print "Gagal | ERROR: ID / Password Tidak Boleh Kosong";
} else {
    $pass=stripslashes($_GET['i']);
	$Query =mysql_query("SELECT id,Nama,NamaLengkap,Nip,Fak,Jabatan,Jurusan FROM profile WHERE pass='".$_GET['i']."'")or die(mysql_error());
	if (mysql_num_rows($Query)>0){
		$row  = mysql_fetch_object($Query);
		$id   = $row->id;
		$Nama = $row->Nama;
        $Nip  = $row->Nip;
        $Fak  = $row->Fak;
		$NamaLengkap = $row->NamaLengkap;
        $Jabatan = $row->Jabatan;
        $Jurusan = $row->Jurusan;
		putenv("TZ=Asia/Jakarta");
        $dir ="foto/";
		$filename=$dir.$id.date('YmdHis').'.jpg';
        $jam= date ("H:i:s");
		$tgl = date("Y-m-d");
		$capture = file_put_contents( $filename, file_get_contents('php://input') );
        $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
        
        //Cek Dosen
        $query2 = mysql_query("SELECT Nama FROM profile WHERE Nama = '$Nama' AND Jabatan = 'Dosen' LIMIT 1") or die(mysql_error());
			if(mysql_num_rows($query2)>0){
				// dosen
				//$capture = file_put_contents( $NewImage, file_get_contents('php://input') );
				$query3 = mysql_query("SELECT login FROM presensi WHERE Tanggal='$tgl' AND login='$Nama' AND abs='1' LIMIT 1");
				if (mysql_num_rows($query3)>0) {
				      echo  "Maaf Anda Telah Telah Presensi Hari ini<br>";
				}else {
				      $query7= "INSERT INTO presensi (Nip, login, Tanggal, JamMasuk, FotoMasuk, abs) VALUES ('$Nip','$Nama','$tgl','$jam','$filename','1')";
				      if ($hasil = mysql_query($query7)){
				        echo "<b><p align=\"center\" class=\"blinking\">presensi Dosen Sukses</b>";
                        echo "<br /></p>";
                        echo "<table>
                                <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
                                <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
                                <tr><td><b>Jam masuk</b></td><td><b>$jam</b></td></tr>
                              </table>";
				      }	
				}
				
			}else{
				// karyawan
				$query4 = mysql_query("SELECT login FROM presensi WHERE JamKeluar is null AND login = '$Nama' AND Tanggal='$tgl' LIMIT 1") or die (mysql_error());
				if (mysql_num_rows($query4)>0){
					// update
					$query5="UPDATE presensi SET JamKeluar='$jam', FotoKeluar='$filename',abs='1' where Tanggal='".$tgl."' AND login = '$Nama'";
					if ($hasil = mysql_query($query5)){
					   echo "<b><p align=\"center\" class=\"blinking\">Presensi Karyawan Sukses</b>";
                        echo "<br /></p>";
                        echo "<table>
                                <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
                                <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
                                <tr><td><b>Jam Pulang</b></td><td><b>$jam</b></td></tr>
                              </table>";
					}
				}else{
					//$date
					$query8= mysql_query("SELECT login FROM presensi WHERE login = '$Nama' AND Tanggal = '$tgl' LIMIT 1");
					if (mysql_num_rows($query8)>0){
                        echo "<br>Maaf Anda Sudah Presensi 2X Hari ini...";
					}else {
						$query6= "INSERT INTO presensi (Nip, login, Tanggal, JamMasuk, FotoMasuk, abs) VALUES ('$Nip','$Nama','$tgl','$jam','$filename','0')";
						if($hasil = mysql_query($query6)){
						  echo "<b><p align=\"center\" class=\"blinking\">Presensi Karyawan Sukses</b>";
                        echo "<br /></p>";
                        echo "<table>
                                <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
                                <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
                                <tr><td><b>Jam masuk</b></td><td><b>$jam</b></td></tr>
                              </table>";
						}
					}
				}
			}
	} else {
		print "<br><p class=\"blinking\">Gagal | ID / Password yg Anda masukkan Tidak Valid</p>";
	}
}
?>
