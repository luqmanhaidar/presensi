<?php

/**
 * @author mrcoco
 * @copyright 2010
 */

require_once "koneksi.php";
if($_GET['i']===''){
   echo "<h3 align='center'>Gagal | ERROR: ID / Password Tidak Boleh Kosong</h3>";
}else{
    $pass=stripslashes(mysql_escape_string($_GET['i']));
    $type=stripslashes(mysql_escape_string($_GET['type']));
    putenv("TZ=Asia/Jakarta");
    $date = date('Y-m-d-H-i-s');
    $tgl= date("Y-m-d");
    $jam = date('H:i:s');
    $harini = date('l');
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $ip=getIP();
    $rever=$ip."-".$hostname;
    $libur_nas = numRow("hari_libur","where Tanggal='".$tgl."'");
    $liburan   = array('Sunday','Saturday');
    $Query=mysql_query("SELECT profile.id,Nama,profile.Nip,NamaLengkap,Jurusan,Jabatan,abs,Tanggal,JamMasuk,JamKeluar 
                        FROM profile 
                        JOIN presensi ON profile.Nama = presensi.login 
                        WHERE pass = '$pass' 
                        ORDER BY Tanggal DESC 
                        LIMIT 1") or die(mysql_error());
    
    if (mysql_num_rows($Query)>0){
        $row=mysql_fetch_object($Query);
        $id          = $row->id;
        $abs         = $row->abs;
        $Nip         = $row->Nip;
        $Nama        = $row->Nama;
        $Jabatan     = $row->Jabatan;
        $Jurusan     = $row->Jurusan;
        $Tanggal     = $row->Tanggal;
        $JamMasuk    = $row->JamMasuk;
        $JamKeluar   = $row->JamKeluar;
        $NamaLengkap = $row->NamaLengkap;
        $dir = "foto/";
        $filename = $dir.$id.'-'.date('YmdHis').'.jpg';
		//$capture  = file_put_contents( $filename, file_get_contents('php://input') );
        switch($type){
	    case	"datang"	:
	       switch($Jabatan)	{
		  case	"Dosen"		:
		     if($libur_nas == 0){
			if($tgl == $Tanggal){
			   if(in_array($harini,$liburan)){
			      echo "<h3 align='center'>Maaf ini Hari Libur silahkan istirahat dirumah..</h3>";
			   }else{
			      switch($abs){
				 case	"1"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK</h3>";
				    break;
				 case	"2"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual admin</h3>";
				    break;
				 case	"3"	:
				    echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Tugas Dinas</h3>";
				    break;
				 case	"4"	:
				    echo "<h3 align='center'>Maaf Anda Sudah Mengajukan Ijin Alasan Penting</h3>";
				    break;
				 case	"5"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual karena jaringan error</h3>";
				    break;
				 case	"6"	:
				    echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Sakit</h3>";
				    break;
				 case "7"	:
				    echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Cuti</h3>";
				    break;
				 case	"8"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual karena salah klik</h3>";
				    break;
				 default	:
				    echo "<h3 align='center'>Error..</h3>";
				    break;
			      }
			   }
			}else{
			      $capture  = file_put_contents( $filename, file_get_contents('php://input') );
			      $Query1="INSERT INTO presensi (Nip, login, Tanggal, JamMasuk, FotoMasuk, abs,reverer) 
				      VALUES ('$Nip','$Nama','$tgl','$jam','$filename','1','$rever')";
			      if ($hasil=mysql_query($Query1)){
				  echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI DATANG..</h3>";
				  echo "<table>
					  <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
					  <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
					  <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
					  <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
					  <tr><td><b>Jam masuk</b></td><td><b>$jam</b></td></tr>
					</table>";
			      } else {
				  echo "<h3 align='center'>Proses Presensi Gagal</h3>";
			      }
			}
		     }else{
			echo "<h3 align='center'>Maaf ini Hari Libur Nasional.. Cek kembali Kalender anda</h3>";
		     }
		     break;
		  case	"Karyawan"	:
		     if($libur_nas == 0){
			if(in_array($harini,$liburan){
			   if($Jurusan == "Umper/Cleaning"){
				 if($tgl == $Tanggal){
				 switch($abs){
				    case	"1"	:
				       echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK</h3>";
				       break;
				    case	"2"	:
				       echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual admin</h3>";
				       break;
				    case	"3"	:
				       echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Tugas Dinas</h3>";
				       break;
				    case	"4"	:
				       echo "<h3 align='center'>Maaf Anda Sudah Mengajukan Ijin Alasan Penting</h3>";
				       break;
				    case	"5"	:
				       echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual karena jaringan error</h3>";
				       break;
				    case	"6"	:
				       echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Sakit</h3>";
				       break;
				    case "7"	:
				       echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Cuti</h3>";
				       break;
				    case	"8"	:
				       echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual karena salah klik</h3>";
				       break;
				    default	:
				       echo "<h3 align='center'>Error..</h3>";
				       break;
				 }
			      }else{
				 $capture  = file_put_contents( $filename, file_get_contents('php://input') );
				 $Query2="INSERT INTO presensi (Nip, login, Tanggal, JamMasuk, FotoMasuk, abs,reverer) 
					 VALUES ('$Nip','$Nama','$tgl','$jam','$filename','1','$rever')";
				 if ($hasil1=mysql_query($Query2)){
				     echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI DATANG</h3>";
				     echo "<table>
					     <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
					     <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
					     <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
					     <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
					     <tr><td><b>Jam Masuk</b></td><td><b>$jam</b></td></tr>
					     <tr><td><b>IP</b></td><td><b>$ip</b></td></tr>
					   </table>";
				     
				 }else{
				     echo "<h3 align='center'>Proses Presensi Gagal</h3>";
				 }
			      }
			   }else{
			      echo "<h3 align='center'>Maaf ini Hari Libur silahkan istirahat dirumah..</h3>";
			   }
			}else{
			   if($tgl == $Tanggal){
			      switch($abs){
				 case	"1"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK</h3>";
				    break;
				 case	"2"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual admin</h3>";
				    break;
				 case	"3"	:
				    echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Tugas Dinas</h3>";
				    break;
				 case	"4"	:
				    echo "<h3 align='center'>Maaf Anda Sudah Mengajukan Ijin Alasan Penting</h3>";
				    break;
				 case	"5"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual karena jaringan error</h3>";
				    break;
				 case	"6"	:
				    echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Sakit</h3>";
				    break;
				 case "7"	:
				    echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Cuti</h3>";
				    break;
				 case	"8"	:
				    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK melalui presensi Manual karena salah klik</h3>";
				    break;
				 default	:
				    echo "<h3 align='center'>Error..</h3>";
				    break;
			      }
			   }else{
			      $capture  = file_put_contents( $filename, file_get_contents('php://input') );
			      $Query2="INSERT INTO presensi (Nip, login, Tanggal, JamMasuk, FotoMasuk, abs,reverer) 
				      VALUES ('$Nip','$Nama','$tgl','$jam','$filename','1','$rever')";
			      if ($hasil1=mysql_query($Query2)){
				  echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI DATANG</h3>";
				  echo "<table>
					  <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
					  <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
					  <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
					  <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
					  <tr><td><b>Jam Masuk</b></td><td><b>$jam</b></td></tr>
					  <tr><td><b>IP</b></td><td><b>$ip</b></td></tr>
					</table>";
				  
			      }else{
				  echo "<h3 align='center'>Proses Presensi Gagal</h3>";
			      }
			   }
			}
		     }else{
			echo "<h3 align='center'>Maaf ini Hari Libur Nasional.. Cek kembali Kalender anda</h3>";
		     }
		     break;
		  default		:
		     echo "<h3 align='center'>Data Tidak Valid</h3>";
		     break;
	       }
	       break;
	    case	"pulang"	:
	       switch($Jabatan){
		  case	"Dosen"		:
		     echo "<h3 align='center'>Anda Tidak Perlu presensi Pulang cukup presensi masuk sekali saja..</h3><br />";
		     break;
		  case	"Karyawan"	:
		     if($tgl == $Tanggal){
			if($JamKeluar <> NULL){
			   if($abs == "1"){
			      if($JamMasuk <> NULL){
				 echo "<h3 align='center'>Maaf Anda telah Presensi Pulang</h3><br />";
			      }else{
				 echo "<h3 align='center'>Kemungkinan Ada salah Klik Presensi saat datang. Silahkan Hubungi Admin</h3><br />";
			      }
			   }else{
			      echo "<h3 align='center'>Maaf Anda telah Presensi Pulang</h3><br />";
			   }
			}else{
			   capture  = file_put_contents( $filename, file_get_contents('php://input') );
			   $Query3="UPDATE presensi SET JamKeluar='$jam', FotoKeluar='$filename',abs='1', reverer='$rever' 
				   where Tanggal='".$tgl."' AND login = '$Nama'";
			   if ($hasil2=mysql_query($Query3)){
			       echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI PULANG..</h3>";
			       echo "<table>
				   <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
				   <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
				   <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
				   <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
				   <tr><td><b>Jam Pulang</b></td><td><b>$jam</b></td></tr>
				 </table>";
			   }else{
			       echo "<h3 align='center'>Proses Presensi Gagal</h3>";
			   }
			}
			
		     }else{
			$capture = file_put_contents( $filename, file_get_contents('php://input') );
			$Query4= "INSERT INTO presensi (Nip, login, Tanggal, JamKeluar, FotoKeluar, abs, reverer) VALUES ('$Nip','$Nama','$tgl','$jam','$filename','1','$rever')";
			if ($hasil3=mysql_query($Query4)){
			    echo "<h3 align='center'>Terima Kasih Anda Telah berhasil PRESENSI PULANG</h3>";
			    echo "<table>
				    <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
				    <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
				    <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
				    <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
				    <tr><td><b>Jam Pulang</b></td><td><b>$jam</b></td></tr>
				  </table>";
			}else {
			    echo "<h3 align='center'>Proses Presensi Gagal</h3>";
			}
		     }
		     break;
		  default		:
		     echo "<h3 align='center'>Data Tidak Valid</h3>";
		     break;
	       }
	       break;
	    default			:
	       echo "<h3 align='center'>Data Tidak Valid</h3>";
	       break;
	}
    }else{
        echo "<br><p class=\"blinking\">Gagal | ID / Password yg Anda masukkan Tidak Valid</p>";
    }         
}
?>