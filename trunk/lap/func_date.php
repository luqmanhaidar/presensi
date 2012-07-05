<?php
function indonesian_date ($timestamp = '', $date_format = 'l', $suffix = '') {
	if (trim ($timestamp) == '')
	{
			$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
	# remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
	);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		'Oktober','November','Desember',
	);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
}

function bulan_id($x){
        switch ($x) {
        case 1  : $bulan = "Januari";
           break;
        case 2  : $bulan = "Februari";
           break;
        case 3  : $bulan = "Maret";
           break;
        case 4  : $bulan = "April";
           break;
        case 5  : $bulan = "Mei";
           break;
        case 6  : $bulan = "Juni";
           break;
        case 7  : $bulan = "Juli";
           break;
        case 8  : $bulan = "Agustus";
           break;
        case 9  : $bulan = "September";
           break;
        case 10 : $bulan = "Oktober";
           break;
        case 11 : $bulan = "November";
           break;
        case 12 : $bulan = "Desember";
           break;
    }
    return $bulan;
}

function selisih ($masuk,$keluar){
	list ($h,$m,$s) = explode (":",$masuk);
	$dtAwal = mktime ($h,$m,$s,"1","1","1");
	list ($h,$m,$s) = explode (":",$keluar);
	$dtAkhir = mktime ($h,$m,$s,"1","1","1");
	$dtSelisih = $dtAkhir - $dtAwal;
	$totalmenit=$dtSelisih/60;
	$jam = explode(".",$totalmenit/60);
	$sisamenit = ($totalmenit/60)-$jam[0];
	$sisamenit2= floor($sisamenit*60);
return  $jam[0].":".$sisamenit2;
}

function get_time_difference($time1, $time2) {
    $time1 = strtotime("1980-01-01 $time1");
    $time2 = strtotime("1980-01-01 $time2");
    
    if ($time2 < $time1) {
        $time2 += 86400;
    }
    
    return date("H:i:s", strtotime("1980-01-01 00:00:00") + ($time2 - $time1));
}

 function hitung_sabtu($tgl_mulai,$tgl_akhir) {
        $adaysec =24*3600;
        $tgl1= strtotime($tgl_mulai);
        $tgl2= strtotime($tgl_akhir);
        $sabtu=0;
        for ($i=$tgl1;$i<$tgl2;$i+=$adaysec){
                if (date("w",$i) =="6") {
                $sabtu++;
                }
        }
 return $sabtu;
 }
 
 function hitung_minggu($tgl_mulai,$tgl_akhir) {
        $adaysec =24*3600;
        $tgl1= strtotime($tgl_mulai);
        $tgl2= strtotime($tgl_akhir);
        $minggu=0;
        for ($i=$tgl1;$i<$tgl2;$i+=$adaysec){
                if (date("w",$i) =="0") {
                        $minggu++;
                        }
        }
 return $minggu;
 }
 
 //credit ariani borneo
 function count_minggu($jHari,$bSekarang,$tSekarang){
	    //$jHari = date('t');
	    //$bSekarang = date('n');
	    //$tSekarang = date('Y');
	    for($i = 1; $i <= $jHari; $i++){
		    if(date('D', mktime(0, 0, 0, $bSekarang, $i, $tSekarang)) == "Sun"){
			    $minggu[$i] = date('d-m-Y', mktime(0, 0, 0, $bSekarang, $i, $tSekarang));
		    }
	    }
	    return count($minggu);
    }
 
 function hitung_jumat($tgl_mulai,$tgl_akhir) {
        $adaysec =24*3600;
        $tgl1= strtotime($tgl_mulai);
        $tgl2= strtotime($tgl_akhir);
        $jumat=0;
        for ($i=$tgl1;$i<$tgl2;$i+=$adaysec){
                if (date("w",$i) =="5") {
                        $jumat++;
                        }
        }
 return $jumat;
 }
 
 function hitung_hari($month, $year)
        {
           return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
        }
        
 function jamKerja($jJam, $jHari = 25){
    list($jam, $menit) 		= explode(':',$jJam);
    $jk['jam'] 			= $jam;
    $jk['menit'] 		= $menit;
    $jk['menittojam']		= ($menit * $jHari) / 60;
    $jk['sisamenit'] 		= ($menit * $jHari) % 60;
    $jk['bulatmenittojam']	= floor($jk['menittojam']);
    $jk['jumlahjam'] 		= $jam * $jHari;
    $jk['tampil'] 		= $jk['jumlahjam'] + $jk['bulatmenittojam'] . ':' . $jk['sisamenit'];
    return $jk; }

function TimeDiff($t1,$t2)
    {
    $a1 = explode(":",$t1);
    $a2 = explode(":",$t2);
    $time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
    $time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
    $diff = abs($time1-$time2);
    $hours = floor($diff/(60*60));
    $mins = floor(($diff-($hours*60*60))/(60));
    $secs = floor(($diff-(($hours*60*60)+($mins*60))));
    $result = $hours.":".$mins.":".$secs;
    return $result;
}

function count_repeat_values($needle, $haystack){
   
    $x = count($haystack);
   
    for($i = 0; $i < $x; $i++){
       
        if($haystack[$i] == $needle){
            $needle_array[] = $haystack[$i];
        }
    }
   
    $number_of_instances = count($needle_array);
   
    return $number_of_instances;
}

function sum_the_time($time1, $time2) {
  $times = array($time1, $time2);
  $seconds = 0;
  foreach ($times as $time)
  {
    list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  return "{$hours}:{$minutes}:{$seconds}";
}

function dateDiff($date1,$date2)
{
    $diff = abs(strtotime($date2) - strtotime($date1));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    return $days;
}
?>