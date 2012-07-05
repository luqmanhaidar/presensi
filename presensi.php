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
    $liburan = array('Sunday','Saturday');
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
        if ($type === 'datang'){
            if ($Jabatan == 'Dosen'){
		if(in_array($harini,$liburan)){
			echo "<h3 align='center'>Maaf ini Hari Libur silahkan istirahat dirumah..</h3>";
		}else{
                if($Tanggal == $tgl && $abs == '1'){
                    echo "<h3 align='center'>Maaf ANDA sudah PRESENSI MASUK</h3>";
                }else {
		     if($Tanggal == $tgl && $abs == '3'){
			echo "<h3 align='center'>Maaf ANDA sudah Mengajukan Izin Tugas Dinas</h3>";
		     }else{
			if($Tanggal == $tgl && $abs == '6'){
			   echo "<h3 align='center'>Maaf Bukannya Anda Sakit?? kok masih Pengen presensi</h3>";
			}else{
			   if($Tanggal == $tgl && $abs =='4'){
			      echo "<h3 align='center'>Maaf Anda Sudah Mengajukan Ijin Alasan Penting</h3>";
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
			   
			}
			
		     }
                    
		    }
                }
            }else{
                //presensi Masuk Karyawan
		if(in_array($harini,$liburan) && $Jurusan <> 'Security' && $Jurusan <> 'Umper/Cleaning'){
			echo "<h3 align='center'>Maaf ini Hari Libur silahkan istirahat dirumah..</h3>";
		  }else{
                if($Tanggal == $tgl){
                    echo "<h3 align='center'>Maaf ANDA telah PRESENSI DATANG..</h3>";
			//echo date('l');
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
            }
            //Dosen Memilih Presensi pulang...
        }elseif($type === 'pulang'){ 
            if ($Jabatan === 'Dosen'){
                echo "<h3 align='center'>Anda Tidak Perlu presensi Pulang cukup presensi masuk sekali saja..</h3><br />";
            }else{
                if ($Tanggal == $tgl){
                    if ($Tanggal == $tgl && $JamKeluar <> NULL ){
                        echo "<h3 align='center'>Maaf ANDA Telah PRESENSI PULANG Hari ini..</h3>";
                    }else{
                        $capture  = file_put_contents( $filename, file_get_contents('php://input') );
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
                    //Presensi Pulang Tanpa Presensi Masuk...
                    //modharo ora duwe jam Kerja
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
            }
        }else{
            echo "<h3>tidak Valid ANDA BUKAN PEGAWAI UNY..</h3>";
        }
    }else{
        echo "<br><p class=\"blinking\">Gagal | ID / Password yg Anda masukkan Tidak Valid</p>";
    }         
}

?>