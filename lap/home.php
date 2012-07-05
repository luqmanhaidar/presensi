<?php
include "fungsi.php";
$mode=stripslashes($_GET['mode']);
    switch ($mode) {
	case 'Dosen': 
	    DaftarDosen ();
	    break;
	    case 'Karyawan': 						
	    DaftarKaryawan ();
	    break;
	    default : 
	    DaftarDosen ();
	    break;
	}
?>