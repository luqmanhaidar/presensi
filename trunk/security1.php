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
        $Jabatan     = $row->Jabatan;
        $Jurusan     = $row->Jurusan;
        $NamaLengkap = $row->NamaLengkap;
        $Query1 =mysql_query("SELECT Tanggal,JamMasuk,JamKeluar,abs FROM presensi WHERE login='$Nama' ORDER BY Tanggal DESC 
                        LIMIT 1")or die(mysql_error());
        $Row = mysql_fetch_object($Query1);
        $abs       = $Row->abs;
        $Tanggal   = $Row->Tanggal;
        $JamMasuk  = $Row->JamMasuk;
        $JamKeluar = $Row->JamKeluar;
        $dir = "foto/";
        $filename = $dir.$id.'-'.date('YmdHis').'.jpg';
        if ($type=='Datang'){
            if($shift == 'shift1'){
                if ($Tanggal == $tgl && $JamMasuk <> NULL){
                    echo "Maaf Anda Telah Presensi Datang";
                }else{
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
            }elseif ($shift == 'shift2'){
                 if ($Tanggal == $tgl && $JamMasuk <> NULL){
                    echo "Maaf Anda Telah Presensi Datang";
                }else{
                    $capture  = file_put_contents( $filename, file_get_contents('php://input') );
                    $Query3 = "INSERT INTO satpam (Nip,login,Tanggal,JamMasuk,FotoMasuk,shift,abs) VALUES ('$Nip','$Nama','$tgl',$jam,'$filename','$shift','0')";
                    if($hasil1 = mysql_query($Query3)){
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
            }else{
                echo "Maaf Cuma Ada 2 Shift";
            }
        }elseif($type == 'Pulang'){
            if($shift == 'shift1'){
                if ($Tanggal == '$tgl' && $JamKeluar <> NULL){
                   echo "Maaf Anda Telah Presensi Datang"; 
                }else{
                    
                }
            }elseif($shift == 'shift2'){
                
            }else{
                echo "ERROR: Shiftnya Hanya sampai 2 .."
            }
            
        }else{
            echo "ERROR:..";
        }
    }else{
        echo "<br><p class=\"blinking\">Gagal | ID / Password yg Anda masukkan Tidak Valid</p>";
    }
   
}
?>