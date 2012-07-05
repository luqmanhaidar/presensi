<?php
include ("../koneksi.php");
        echo "<div></div>";
	echo "<h1>Presensi Karyawan Universitas Negeri Yogyakarta</h1>";
	echo "<br />";
	echo "<p class='info'>Tampilkan Berdasarkan Tahun dan Bulan</p>";
	echo "<form method=\"post\" class=\"nice\">";
	echo "<select name=\"tahun\">";
	echo "<option>Tahun</option>\n";
            for ($i=2009; $i<=2020; $i++) {
                echo "<option value=\"$i\">".$i."</option>\n";
            }
        echo "</select>";
	echo "<select name=\"bulan\">";
	echo "<option>Bulan</option>\n";
	echo "<option value=\"01\">Januari</option>\n";
	echo "<option value=\"02\">Februari</option>\n";
	echo "<option value=\"03\">Maret</option>\n";
	echo "<option value=\"04\">April</option>\n";
	echo "<option value=\"05\">Mei</option>\n";
	echo "<option value=\"06\">Juni</option>\n";
	echo "<option value=\"07\">Juli</option>\n";
	echo "<option value=\"08\">Agustus</option>\n";
	echo "<option value=\"09\">September</option>\n";
	echo "<option value=\"10\">Oktober</option>\n";
	echo "<option value=\"11\">November</option>\n";
	echo "<option value=\"12\">Desember</option>\n";
	echo "</select>\n";
        echo "<select name=\"tanggal\">";
        echo "<option>Tgl</option>\n";
            for ($i=1; $i<=31 ; $i++) {
            echo "<option value=\"$i\">".$i."</option>\n";
        }
	echo "</select>\n";
        echo "<button type=\"submit\" class=\"green\" name=\"submit1\">Tampil</button>\n";
	echo "</form>\n";	
	echo "<div><br /><br /></div>";
        $tanggal=stripslashes($_POST['tanggal']);
	$tahun=stripslashes($_POST['tahun']); 
	$bulan=stripslashes($_POST['bulan']);
	//$jur=stripslashes($_POST['jur']);
        $tgl=$tahun.'-'.$bulan.'-'.$tanggal;
	$bt=$bulan.'-'.$tahun;
	$noUrut=1;
	if (isset($_POST['submit1'])) //jk tombol submit1 ditekan
		{
		$query = "SELECT * FROM presensi WHERE JamKeluar is NOT NULL AND Tanggal='$tgl'";
		$data = mysql_query($query);
		//echo $fakk;
		echo "<form name=\"form1\" method=\"post\" >";
		echo "<input name=\"bt\" type=\"hidden\" value=\"$bt\" />";
		echo "<button type=\"submit\" name=\"Submit\" class=\"green\" />Hapus</button>";
		echo "</form><br />";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
		echo "<tr><th><b>NO</b></th><th><b>NIP</b></th><th><b>Nama </b></th><th><b>Tanggal</b></th><th><b>Jam masuk</b></th><th><b>Jam Keluar</b></th><th><b>Foto Masuk</b></th><th><b>Foto Keluar</b></th><th><b>Edit</b></th></tr>";
		while ($hasil = mysql_fetch_array($data))
			{
		echo "<tr><td>".$noUrut."</td><td>".$hasil['Nip']."</td><td>".$hasil['login']."</td><td>".$hasil['Tanggal']."</td><td>".$hasil['JamMasuk']."</td><td>".$hasil['JamKeluar']."</td><td><img src='../".$hasil['FotoMasuk']."' width='95'></td><td><img src='../".$hasil['FotoKeluar']."' width='95'></td><td><a href='adm.view.php?app=Karyawan&id=".$hasil['id']."'><img src='images/icon_calendar.gif'></a></td></tr>";
		$noUrut++;
			}
		echo "</table>";
		}
                if (isset($_POST['submit'])){
                    $query1= mysql_query("UPDATE presensi SET JamKeluar = NULL ,FotoKeluar = '',abs = '0' WHERE JamKeluar is NOT NULL  AND Tanggal='$tgl'");
                }

?>