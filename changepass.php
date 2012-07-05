<?php
require_once ("koneksi.php");
session_start();
$unip = $_SESSION['nip'];
$uid  = $_SESSION['id'];
if(isset($_POST)){
    if($_POST['niplama'] == '') { //Nip lama tidak boleh kosong
        echo "<b>Silahkan Isikan NIP / ID Anda..!<br /></b>";
    }elseif($_POST['nipbaru'] == ''){ //pass baru tidak boleh kosong
        echo "<b>Silahkan Isikan ID / Password baru Anda..<br /></b>";
    }elseif($_POST['nipulang'] == ''){ //pass2 tidak boleh kosong
        echo "<b>Silahkan Isikan sekali lagi ID / Password baru Anda.. <br /></b>";
    }
    $niplama      = $_POST['niplama'];
    $passlama     = $_POST['passlama'];
    $nipbaru      = mysql_real_escape_string(stripslashes($_POST['nipbaru']));
    $ulang        = mysql_real_escape_string(stripslashes($_POST['nipulang']));
    $Qspam        = mysql_query("SELECT spam FROM nopass WHERE spam = '$nipbaru'");
    if (! $hasil2 = mysql_num_rows($Qspam)>0){
        $Qpass = mysql_query("SELECT pass FROM profile WHERE pass = '$passlama' AND Nip='$niplama' LIMIT 1");
        if ($hasil3=mysql_num_rows($Qpass)>0){
              if ($nipbaru == $ulang) { //cek apakah kedua pass baru sama
                if (strlen($nipbaru)>5){ //cek apakah jumlah karakter lebih dari 3 karakter
                    if (! ereg('[^A-Za-z0-9]', $nipbaru)) { //cek apakah karakter berupa alphanumerik
                                $query = mysql_query("SELECT pass FROM profile WHERE Nip='$niplama' LIMIT 1");
                                if ($hasil  = mysql_num_rows($query)>0){ //cek apakah Nip ada dlm database
                                    $query2 = mysql_query("SELECT pass FROM profile WHERE pass = '".$nipbaru."' LIMIT 1");
                                    if (! $hasil = mysql_num_rows($query2)>0){ //cek apakah pass baru masih tersedia
                                            $query1 = "UPDATE profile SET pass ='".$nipbaru."' WHERE Nip='".$niplama."' LIMIT 1";
                                            if ($hasil1 = mysql_query($query1)){
                                                echo "<b>Penggantian Password Sukses..<br /> Silahkan Klik <a href=\"index.php\" >Home</a> untuk kembali ke halaman presensi</b>" ;
                                                unset($_SESSION['nip']);
                                                unset($_SESSION['id']);
                                                mysql_close($link);
                                            } else {
                                                    echo "Penggantian Password Gagal";
                                                    }
                                    } else {
                                            echo "<b>Password Tidak tersedia..<br /> Silahkan Gunakan Password yang lain..</b>";
                                            }           
                                } else {
                                        echo "<b>Nip Yang Anda Masukkan Salah..</b>";
                                        }            
                    }   else {
                            echo "<b>Karakter yang diijinkan hanya karakter alphanumeric (A-Za-z0-9)</b>";
                            }
                }
                else {
                        echo "<b>Jumlah karakter minimal 6 huruf..</b>";
                        }
            } else {
                    echo "<b>Password yang Anda masukkan Tidak sama</b>";    
                    }
        } else {
            echo "<b>Pass lama Tidak sesuai</b>";
        }
    }   else {
            echo "<b>Anda Tidak Diijinkan menggunakan Kata tersebut sebagai Password</b>";
         }
}
?>