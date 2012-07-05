<?php
require_once("lap/adm.db.php");
if ($_GET['i']===''){
    echo "<h3 align='center'>Gagal | ERROR: ID / Password Tidak Boleh Kosong</h3>";
}else {
    $pass  =stripslashes($_GET['i']);
    $type  =stripslashes($_GET['types']);
    $shift =stripslashes($_GET['Shift']);
    putenv("TZ=Asia/Jakarta");
    $date = date('Y-m-d-H-i-s');
    $tgl= date("Y-m-d");
    $jam = date('Y-m-d H:i:s');
    $Query = mysql_query("SELECT id,Nip,Nama,NamaLengkap,Jurusan FROM profile WHERE pass='$pass'") or die(mysql_error());
    if(mysql_num_rows($Query)>0){
        $row = mysql_fetch_object($Query);
        $id          = $row->id;
        $Nip         = $row->Nip;
        $Nama        = $row->Nama;
        $NamaLengkap = $row->NamaLengkap;
        $Jurusan     = $row->Jurusan;
        $Query1 = mysql_query("SELECT login,Tanggal,JamMasuk,JamKeluar,shift FROM satpam WHERE login='$Nama' ORDER BY Tanggal DESC 
                        LIMIT 1") or die(mysql_error());
        $row1 = mysql_fetch_object($Query1);
        $Tanggal   = $row1->Tanggal;
        $JamMasuk  = $row1->JamMasuk;
        $JamKeluar = $row1->JamKeluar;
        $shft      = $row1->shift;
        $dir = "foto/";
        $filename = $dir.$id.'-'.date('YmdHis').'.jpg';
        if ($Jurusan == 'Security'){
            if ($shift == 'shift1'){
                if ($type == 'datang'){
                    if($Tanggal == $tgl && $JamMasuk <> NULL){
                        echo "Maaf Anda Telah Presensi Datang";
                    }else {
                        $capture  = file_put_contents( $filename, file_get_contents('php://input') );
                        $Query2   = "INSERT INTO satpam (Nip,login,Tanggal,JamMasuk,FotoMasuk,shift,abs) VALUES ('$Nip','$Nama','$tgl','$jam','$filename','$shift','0')";
                        if($hasil = mysql_query($Query2)){
                            echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI DATANG..</h3>";
                            echo "<table>
                                    <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                    <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                    <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
                                    <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
                                    <tr><td><b>Jam masuk</b></td><td><b>$jam</b></td></tr>
                                  </table>";
                        }else {
                            echo "Presensi GAGAL";
                        }
                    }
                }elseif($type == 'pulang'){
                        if ($Tanggal == $tgl && $JamKeluar <> NULL){
                            echo "<h3 align='center'>Maaf ANDA Telah PRESENSI PULANG Hari ini..</h3>";
                        }else {
                            $capture  = file_put_contents( $filename, file_get_contents('php://input') );
                            $Query3   = "UPDATE satpam SET JamKeluar='$jam', FotoKeluar='$filename',abs='1' WHERE login='$Nama' AND shift='shift1'";
                            if ($hasil2 = mysql_query($Query3)){
                                echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI PULANG..</h3>";
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
            }elseif($shift == 'shift2'){
                if ($type == 'datang'){
                    if($Tanggal == $tgl && $JamMasuk <> NULL){
                        echo "Maaf Anda Telah Presensi Datang2";
                    }else {
                        $capture  = file_put_contents( $filename, file_get_contents('php://input') );
                        $Query2   = "INSERT INTO satpam (Nip,login,Tanggal,JamMasuk,FotoMasuk,shift,abs) VALUES ('$Nip','$Nama','$tgl','$jam','$filename','$shift','0')";
                        if($hasil = mysql_query($Query2)){
                            echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI DATANG..</h3>";
                            echo "<table>
                                    <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                    <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                    <tr><td><b>Jabatan</b></td><td><b>$Jabatan</b></td></tr>
                                    <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
                                    <tr><td><b>Jam masuk</b></td><td><b>$jam</b></td></tr>
                                  </table>";
                        }else {
                            echo "Presensi GAGAL";
                        }
                    }
                }elseif($type == 'pulang'){
                        if ($Tanggal == $tgl && $JamKeluar <> NULL){
                            echo "<h3 align='center'>Maaf ANDA Telah PRESENSI PULANG Hari ini..</h3>";
                        }else {
                            $capture  = file_put_contents( $filename, file_get_contents('php://input') );
                            $Query3   = "UPDATE satpam SET JamKeluar='$jam', FotoKeluar='$filename',abs='1' WHERE login='$Nama' AND shift='shift2'";
                            if ($hasil2 = mysql_query($Query3)){
                                echo "<h3 align='center'>Terima Kasih ANda Telah berhasil PRESENSI PULANG..</h3>";
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
            }
            
            elseif($shift == 'shift3'){
                if($type == 'datang'){
                    if($Tanggal == $tgl && $JamMasuk <> NULL){
                        echo "<h3 align='center'>Maaf ANDA Telah PRESENSI DATANG Hari Ini...</h3>";
                    }else{
                        $capture = file_put_contents( $filename, file_get_contents('php://input'));
                        $Query2  = "INSERT into satpam (Nip,login,Tanggal,JamMasuk,FotoMasuk,shift,abs) VALUES ('$Nip','$Nama','$tgl','$jam','$filename','$shift','0')";
                        if($hasil= mysql_query($Query2)){
                            echo "<h3 align='center'>Terima Kasih Anda Telah Berhasil PRESENSI Datang..</h3>";
                            echo "<table>
                                    <tr>td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                    <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                    <tr><td><b>Jabatan </b></td><td><b>$Jabatan</b></td></tr>
                                    <tr><td><b>Jurusan / Sub.Bag</b></td><td><b>$Jurusan</b></td></tr>
                                    <tr><td><b>Jam Datang</b></td><td><b>$jam</b></td></tr>
                                </table>";
                        }else{
                            echo "<h3 align='center'>PROSES PRESENSI GAGAL</h3>";
                        }
                    }
                }elseif($type == 'pulang'){
                    if($Tanggal == $tgl && $JamKeluar <> NULL){
                        echo "<h3 align='center'>Maaf ANDA Telah PRESENSI PULANG Hari Ini..</h3>";
                        
                    }else{
                        $capture == file_put_contents( $filename, file_get_contents('php://input'));
                        $Query3  = "UPDATE satpam SET JamKeluar='$jam', FotoKeluar='$filename',abs='1' WHERE login='$Nama' AND shift='shift3'";
                        if ($hasil2 = mysql_query($Query3)){
                            echo "<h3 align='center'>Terima kasih Anda Telah Berhasil PRESENSI PULANG...</h3>";
                            echo "<table>
                                <tr><td><b>Nama Lengkap</b></td><td><b>$NamaLengkap</b></td></tr>
                                <tr><td><b>NIP / ID</b></td><td><b>$Nip</b></td></tr>
                                <tr><td><b>Jabatan </b></td><td><b>$Jabatan</b></td></tr>
                                <tr><td><b>Jurusan / Sub.Bag </b></td><td><b>$Jurusan</b></td></tr>
                                <tr><td><b>Jam PULANG</b></td><td><b>$jam</b></td></tr>
                        </table>";
                        }
                    }
                }
            
            }
            
            else{
                echo "ERROR: Shift Hanya Sampai 3";
            }
        }else{
            echo "ID ANDA Tidak Ada Dalam Daftar SATPAM / Petugas Jaga Malam";
        }
    }else{
        echo "<br><p class=\"blinking\">Gagal | ID / Password yg Anda masukkan Tidak Valid</p>";
    }
   
}
?>