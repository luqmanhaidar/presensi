<?php
//fungsi mencari perbedaan waktu
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

$start = '09:00';
// an END time value
$end   = '10:30';

// what is the time difference between $end and $start?
if( $diff=@get_time_difference($start, $end) )
{
  echo "Hours: " .
       sprintf( '%02d:%02d', $diff['hours'], $diff['minutes'] );
}
else
{
  echo "Hours: Error";
}

echo "-----------";

echo "<br />";

printf( '%02d:%02d', $diff['hours'], $diff['minutes']);
echo "<br />";
echo "".$diff['hours']." : ".$diff['minutes']."";
?>