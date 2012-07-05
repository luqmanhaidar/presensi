<?php
include("adm.db.php");
$profile =fetchDistinct ("profile","","(Nama)");
foreach($profile as $t) {
    echo "<li>$t[Nama]</li>";
}
$row = numRow("profile","where Jabatan='Karyawan' and Fak='FT'");
echo $row;
?>