<?php

function FromKaryawan(){
    echo "<br /><br />";
    echo "<h1>Jumlah Kehadiran Karyawan Universitas Negeri Yogyakarta</h1>";
    echo "<br />";
    echo "<form method=\"post\" class=\"nice\">";
    echo "<table>";
    echo "<tr align=\"center\"><td><b>Dari Tanggal</b></td><td><b>Sampai Tanggal</b></td><td></td></tr>";
    echo "<tr><td>";
    echo "<input class=\"dateinput\" name=\"start\" type=\"text\" id=\"start\">";
    echo "</td><td>";
    echo "<input class=\"dateinput\" name=\"end\" type=\"text\" id=\"end\">";
    echo "</td>";
    echo "<td>";
    echo "<button type=\"submit\" class=\"green\" name=\"submit\">Tampil</button>\n";
    echo "</td></tr>";
    echo "</table>";
    echo "</form>\n";
    TampilTerlambat();
}

function TampilTerlambat(){
    if(isset($_POST['submit'])){
        $start=$_POST['start'];
        $end=$_POST['end'];
        $FT=numRow("profile,presensi","WHERE profile.Fak='FT' AND profile.Jabatan='Karyawan' AND presensi.JamMasuk >=070200 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $FBS=numRow("profile,presensi","WHERE profile.Fak='FBS' AND profile.Jabatan='Karyawan' AND presensi.JamMasuk >=070200 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $MIPA=numRow("profile,presensi","WHERE profile.Fak='MIPA' AND profile.Jabatan='Karyawan' AND presensi.JamMasuk >=070200 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $FISE=numRow("profile,presensi","WHERE profile.Fak='FISE' AND profile.Jabatan='Karyawan' AND presensi.JamMasuk >=070200 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $FIP=numRow("profile,presensi","WHERE profile.Fak='FIP' AND profile.Jabatan='Karyawan' AND presensi.JamMasuk >=070200 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $FIK=numRow("profile,presensi","WHERE profile.Fak='FIK' AND profile.Jabatan='Karyawan' AND presensi.JamMasuk >=070200 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $TltFT=numRow("profile,presensi","WHERE profile.Fak='FT' AND profile.Jabatan='karyawan' AND presensi.JamMasuk <=070159 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $TltFBS=numRow("profile,presensi","WHERE profile.Fak='FBS' AND profile.Jabatan='karyawan' AND presensi.JamMasuk <=070159 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $TltMIPA=numRow("profile,presensi","WHERE profile.Fak='MIPA' AND profile.Jabatan='karyawan' AND presensi.JamMasuk <=070159 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $TltFISE=numRow("profile,presensi","WHERE profile.Fak='FISE' AND profile.Jabatan='karyawan' AND presensi.JamMasuk <=070159 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $TltFIP=numRow("profile,presensi","WHERE profile.Fak='FIP' AND profile.Jabatan='karyawan' AND presensi.JamMasuk <=070159 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $TltFIK=numRow("profile,presensi","WHERE profile.Fak='FIK' AND profile.Jabatan='karyawan' AND presensi.JamMasuk <=070159 AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $HdrFT=numRow("profile,presensi","WHERE profile.Fak='FT' AND profile.Jabatan='karyawan' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $HdrFBS=numRow("profile,presensi","WHERE profile.Fak='FBS' AND profile.Jabatan='karyawan' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $HdrMIPA=numRow("profile,presensi","WHERE profile.Fak='MIPA' AND profile.Jabatan='karyawan' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $HdrFISE=numRow("profile,presensi","WHERE profile.Fak='FISE' AND profile.Jabatan='karyawan' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $HdrFIP=numRow("profile,presensi","WHERE profile.Fak='FIP' AND profile.Jabatan='karyawan' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
        $HdrFIK=numRow("profile,presensi","WHERE profile.Fak='FIK' AND profile.Jabatan='karyawan' AND presensi.Tanggal BETWEEN '$start' AND '$end' AND profile.Nama=presensi.login","presensi.id");
    
    echo "<b>Data dari tanggal: ".dateConv($start)." sampai dengan tanggal ".dateConv($end)."</b><br />";
    echo "<table>";
    echo "<tr><td><b>Fakultas Teknik</b></td><td></td></tr>";
    echo "<tr><td>Jumlah Hadir Tepat waktu</td><td>: $TltFT</td></tr>";
    echo "<tr><td>Jumlah Terlambat</td><td>: $FT</td></tr>";
    echo "<tr><td>Jumlah Hadir</td><td>: $HdrFT</td></tr>";
    echo "<tr><td>&nbsp;</td><td></td></tr>";
    echo "<tr><td><b>Fakultas Bahasa dan Seni</b></td><td></td></tr>";
    echo "<tr><td>Jumlah hadir Tepat waktu</td><td>: $TltFBS</td></tr>";
    echo "<tr><td>Jumlah Terlambat</td><td>: $FBS</td></tr>";
    echo "<tr><td>Jumlah Hadir</td><td>: $HdrFBS</td></tr>";
    echo "<tr><td>&nbsp;</td><td></td></tr>";
    echo "<tr><td><b>Fakultas Matematika dan Ilmu Pengetahuan Alam</b></td><td></td></tr>";
    echo "<tr><td>Jumlah hadir Tepat waktu</td><td>: $TltMIPA</td></tr>";
    echo "<tr><td>Jumlah Terlambat</td><td>: $MIPA</td></tr>";
    echo "<tr><td>Jumlah Hadir</td><td>: $HdrMIPA</td></tr>";
    echo "<tr><td>&nbsp;</td><td></td></tr>";
    echo "<tr><td><b>Fakultas Ilmu Sosial dan Ekonomi</b></td><td></td></tr>";
    echo "<tr><td>Jumlah hadir Tepat waktu</td><td>: $TltFISE</td></tr>";
    echo "<tr><td>Jumlah Terlambat</td><td>: $FISE</td></tr>";
    echo "<tr><td>Jumlah Hadir</td><td>: $HdrFISE</td></tr>";
    echo "<tr><td>&nbsp;</td><td></td></tr>";
    echo "<tr><td><b>Fakultas Ilmu Pendidikan<b></td><td></td></tr>";
    echo "<tr><td>Jumlah hadir Tepat waktu</td><td>: $TltFIP</td></tr>";
    echo "<tr><td>Jumlah Terlambat</td><td>: $FIP</td></tr>";
    echo "<tr><td>Jumlah Hadir</td><td>: $HdrFIP</td></tr>";
    echo "<tr><td>&nbsp;</td><td></td></tr>";
    echo "<tr><td><b>Fakultas Ilmu Keolahragaan</b></td><td></td></tr>";
    echo "<tr><td>Jumlah hadir Tepat waktu</td><td>: $TltFIK</td></tr>";
    echo "<tr><td>Jumlah Terlambat</td><td>: $FIK</td></tr>";
    echo "<tr><td>Jumlah Hadir</td><td>: $HdrFIK</td></tr>";
    echo "</table>";
    }
}
?>