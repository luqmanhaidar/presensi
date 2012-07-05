<?php
require_once("adm.db.php");
?>
<html>
<head>
<title>Matrix Dosen Fakultas Teknik UNY</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<style type="text/css">
body {
  color : #000000;
  background : #ffffff;
  font-family : "Times New Roman", Times, serif;
  font-size : 12pt;
}
table.mytable {border: 1px solid #000000;}
table.mytable td { bo/rder: 1px solid #000000;}
table.mytable tr.special td { border: 1px solid #000000;  }
</style>
<?php
if (isset($_POST['submit'])){
//if($_GET['jur']){
    $jur  = $_POST['jur'];
    $bln  = $_POST['bulan'];
    $thn  = $_POST['tahun'];
    $bt   = $bln."-".$thn;
    $fakk = 'FT';
    $j    = 0;
    $a    = 1;
    $sql  = fetchRow("profile","where Jabatan='Dosen' AND Fak='$fakk' AND Jurusan='".$jur."' AND status='1' ORDER BY sort ASC","distinct (Nama),(NamaLengkap)");
    //print_r($sql);
    switch ($bln) {
		case '1':  $namabulan = "Januari";   break;
		case '2':  $namabulan = "Februari";  break;						
		case '3':  $namabulan = "Maret";     break;					
		case '4':  $namabulan = "April";     break;
		case '5':  $namabulan = "Mei";       break;						
		case '6':  $namabulan = "Juni";      break;
		case '7':  $namabulan = "Juli";      break;
		case '8':  $namabulan = "Agustus";   break;						
		case '9':  $namabulan = "September"; break;						
		case '10': $namabulan = "Oktober";   break;	
		case '11': $namabulan = "November";  break;	
		case '12': $namabulan = "Desember";						
	}
    echo "<h2 align=\"center\">Data Matrik Dosen Universitas Negeri Yogyakarta";
	echo "<br />";
	$jur=fetchRow("adm_jurusan","where Fakultas='".$fakk."' AND JurId='$jurusan'");
	foreach($jur as $t) {
		echo "Jurusan: ".$t[JurDet]."</h2>";
	}
    echo "<p align =\"center\" ><b>Bulan: ".$namabulan." Tahun : ".$thn."</b></p>";
    echo "<table class=\"mytable\"><tr class=\"special\"><td>No</td><td style= \"padding-left: 90px; padding-right: 90px; \"><b>Nama</b></td>";
                    for ($i=1;$i<=31;$i++) {
                    echo "<td><b>Tgl".$i."</b></td>";
                    }
            echo "<td>Jml</td></tr>";
    foreach($sql as $user){
        $j++;
        $Row=countRow("presensi","where login='".$user['Nama']."' AND date_format( presensi.Tanggal, '%m-%Y' ) = '$bt'","abs");
        echo "<tr class=\"special\"><td>".$a."</td><td>".$user['NamaLengkap']."</td>";
        for($day=1;$day<=31;$day++){
            $hari=$thn."-".$bln."-".$day;
            $index[$j] = "SELECT abs FROM presensi WHERE login='".$user['Nama']."' AND Tanggal = '$hari' ";
            $query_abs = mysql_query($index[$j]);
            $row = mysql_num_rows($query_abs);
            if($row == 0){
                echo "<td style=\"background-color:#000;\">xXx</td>";
            }else{
                $hasil = mysql_fetch_array($query_abs,MYSQL_ASSOC);
                switch($hasil['abs']){
                    case    "3" :
                        echo "<td style=\"background-color:#FFFFFF;\"> T </td>";
                        break;
                    case    "4" :
                        echo "<td style=\"background-color:#FFFFFF;\"> I </td>";
                        break;
                    case    "5" :
                        echo "<td style=\"background-color:#FFFFFF;\"> H </td>";
                        break;
                    case    "6" :
                        echo "<td style=\"background-color:#FFFFFF;\"> S </td>";
                        break;
                    case    "7" :
                        echo "<td style=\"background-color:#FFFFFF;\"> C </td>";
                        break;
                    case    "1" :
                        echo "<td style=\"background-color:#FFFFFF;\"> H </td>";
                        break;
                    default     :
                        //echo "<td style=\"background-color:#000;\">xXx</td>";
                        echo "<td style=\"background-color:#FFFFFF;\"> XXX </td>";
                        break;
                }
            }
            
        }
        echo "<td>$Row</td>";
        $a++;
    }
    echo "</tr></table>";
}
?>
</body>
</html>