<?php
include("koneksi.php");
include ("CnnNav.php");

function fetchRow($table, $where = "", $fieldName = "") {
        $arrResult = array();
        $fieldStr = "";
        if (empty($fieldName) ) {
                $fieldStr = "*  ";
        }
        elseif (is_array($fieldName) ){
                foreach ($fieldName as $field) {
                        $fieldStr .= $field.", ";
                }
        }
        else {
                for ($i = 2; $i < func_num_args(); $i++){
                        $fieldStr        .= func_get_arg($i).", ";
                }
        }
        $fields = substr($fieldStr, 0, -2);
        $query = "SELECT ".$fields." FROM ".$table." ".$where;
        $result = mysql_query($query) or die("You have an error in your SQL syntax." . mysql_error());
        while ($row = mysql_fetch_assoc($result) ) {
                array_push($arrResult, $row);
        }
        return $arrResult;
}

function profileDosen() {
    echo "<div></div>";
    echo "<h1>Data Dosen Fakultas Teknik</h1>";
    echo "<br />";
    echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
    echo "<tr><th><b>NIP</b></th><th><b>Login </b></th><th><b>Nama Lengkap</b></th></tr>";
        $max=30;
        $listnav=new CnnNav($max,"profile","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
        $start=$_GET['offset']?$_GET['offset']*$max:0;
        $list=fetchRow("profile","WHERE Jabatan= 'Dosen' ORDER BY NamaLengkap ASC LIMIT ".$start.",".$max);
        foreach($list as $n){
	    echo "<tr><td>".$n[Nip]."</td><td>".$n[Nama]."</td><td>".$n[NamaLengkap]."</td></tr>";
			}
	    echo "</table>";
            echo "<div class=\"pagination\">";
            $listnav->printnav();
            echo "</div>";      
}

function profileKaryawan() {
    echo "<div></div>";
    echo "<h1>Data Karyawan Fakultas Teknik</h1>";
    echo "<br />";
    echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' id='data'>";
    echo "<tr><th><b>NIP</b></th><th><b>Login </b></th><th><b>Nama Lengkap</b></th></tr>";
    $max=30;
    $listnav=new CnnNav($max,"profile","","*","id","9","5","3","&laquo;","&raquo;"," ", "");
    $start=$_GET['offset']?$_GET['offset']*$max:0;
    $list=fetchRow("profile","WHERE Jabatan= 'Karyawan' ORDER BY NamaLengkap ASC LIMIT ".$start.",".$max);
    foreach($list as $n){
		echo "<tr><td>".$n[Nip]."</td><td>".$n[Nama]."</td><td>".$n[NamaLengkap]."</td></tr>";
			}
		echo "</table>";
                echo "<div class=\"pagination\">";
                $listnav->printnav();
                echo "</div>";
}
?>