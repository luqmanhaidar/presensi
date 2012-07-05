<?php
session_start();
require("adm.conf.php");
mysql_connect($_config['host'],$_config['user'],$_config['pass']) or die($_lang['err_db_host']);
mysql_select_db($_config['dbname']) or die($_lang['err_db_db']);

function fetch($table, $where = "", $fieldName = "") {
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

//echo
        $query = "SELECT ".$fields." FROM ".$table." ".$where;
        $result = mysql_query($query) or die("You have an error in your SQL syntax." . mysql_error() );
        $arrResult = mysql_fetch_assoc($result);
        return $arrResult;
}

function padText($text, $limit = "100") {
        if (strlen($text) > ($limit + 15) ) {
                $spacePos = @strpos($text, " ", $limit);
                return substr($text, 0, $spacePos)."...";
        } else {
                return $text;
        }
}

function dateConv($date){
        $monthId = array("00"=>"", "01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"July", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember");
        $pattern = "/(19|20)(\d{2})-(\d{2})-(\d{1,2})([\w: ]*)/e";
        $replacement = '"\\4 ".$monthId["\\3"]." \\1\\2"';
        return preg_replace($pattern, $replacement, $date);
}

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

//echo
        $query = "SELECT ".$fields." FROM ".$table." ".$where;
        $result = mysql_query($query) or die("You have an error in your SQL syntax." . mysql_error());
        while ($row = mysql_fetch_assoc($result) ) {
                array_push($arrResult, $row);
        }
       return $arrResult;
       //echo $query;
}

function fetchDistinct($table, $where = "", $fieldName = "") {
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

//echo
        $query = "SELECT DISTINCT ".$fields." FROM ".$table." ".$where;
        $result = mysql_query($query) or die("You have an error in your SQL syntax." . mysql_error());
        while ($row = mysql_fetch_assoc($result) ) {
                array_push($arrResult, $row);
        }
        return $arrResult;
}


function duration_time($parambegindate, $paramenddate) {
  $begindate = strtotime($parambegindate);
  $enddate = strtotime($paramenddate);
  $diff = intval($enddate) - intval($begindate);                 
  $diffday = intval(floor($diff/86400));
  $modday = ($diff%86400);
  $diffhour = intval(floor($modday/3600));
  $diffminute = intval(floor(($modday%3600)/60));
  $diffsecond = ($modday%60);
  return round($diffday)." Day(s), ".round($diffhour)." Hour(s), ".round($diffminute,0)." Minute(s), ".round($diffsecond,0)." Second(s).";
}

function numRow($table, $where = "", $fieldName = "") {
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

//echo
        $query = "SELECT ".$fields." FROM ".$table." ".$where;
        $result = mysql_query($query) or die("You have an error in your SQL syntax." . mysql_error() );
        $arrResult = mysql_num_rows($result);
        return $arrResult;
}

function countRow($table,$where = ""){
  $query  = mysql_query("SELECT COUNT(*) FROM ".$table." ".$where." ");
  $result = mysql_result($query,0,0);
  return $result;
}
//$_conf=fetchRow($_table_prefix."config");
//print_r($_conf);


function anti_sql_injection( $input ) {   
          $aforbidden = array (
          "insert", "select", "update", "delete", "truncate",
          "replace", "drop", " or ", ";", "#", "--", "=" );
          // lakukan cek, input tidak mengandung perintah yang tidak boleh
          $breturn=true;   
          foreach($aforbidden as $cforbidden) {
              if(strripos($input, $cforbidden)) {
                  $breturn=false;
                  break;   
            }   
          }
          return $breturn;
      }


function jur_det($x){
        $sql= "SELECT JurDet FROM adm_jurusan WHERE JurId='$x'";
        $data= mysql_query($sql);
        $obj = mysql_fetch_object($data);
        $jur = $obj->JurDet;
        return $jur;
}
/**
function jml_waktu($time1,$time2){
        $time1_unix = strtotime(date('Y-m-d').' '.$time1.':00');
        $time2_unix = strtotime(date('Y-m-d').' '.$time2.':00');
        
        $begin_day_unix = strtotime(date('Y-m-d').' 00:00:00');
        
        $jumlah_time = date('H:i', ($time1_unix + ($time2_unix - $begin_day_unix)));
        return $jumlah_time;
}

function kurang_jam($time1,$time2){
        $time1_unix = strtotime(date('Y-m-d').' '.$time1.':00');
        $time2_unix = strtotime(date('Y-m-d').' '.$time2.':00');
        
        $begin_day_unix = strtotime(date('Y-m-d').' 00:00:00');
        
        $kurang_time = date('H:i', ($time1_unix - ($time2_unix - $begin_day_unix)));
}
**/
function temdif($t1,$t2)
{
     $SQL= mysql_query("SELECT TIMEDIFF('".$t2."','".$t1."')");
     $Res = mysql_result($SQL,0,0);
     return $Res;
}
?>