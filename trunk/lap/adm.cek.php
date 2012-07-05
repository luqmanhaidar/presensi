<?php
include_once ("adm.db.php");
  // Answers Array
$array = array('a', 'b', 'a', 'a', 'c', 'a', 'd', 'a', 'c', 'd');
$sql= "SELECT * FROM presensi Where login='coco' AND date_format(presensi.Tanggal,'%m-%Y')='03-2012'";
$data= mysql_query($sql);
$row = mysql_fetch_row($data);

print_r($row);


function array_icount_values($arr,$lower=true) { 
     $arr2=array(); 
     if(!is_array($arr['0'])){$arr=array($arr);} 
     foreach($arr as $k=> $v){ 
      foreach($v as $v2){ 
      if($lower==true) {$v2=strtolower($v2);} 
      if(!isset($arr2[$v2])){ 
          $arr2[$v2]=1; 
      }else{ 
           $arr2[$v2]++; 
           } 
    } 
    } 
    return $arr2; 
}
?>
