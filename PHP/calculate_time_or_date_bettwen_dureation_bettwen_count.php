<?php

$assigned_time = "07:00:00 AM";
$completed_time= "02:00:00 PM"; 
$start_date = "2016-01-02";
$end_date = "2016-12-21";
$dureation = '1:30';


$d1 = new DateTime($assigned_time);
$d2 = new DateTime($completed_time);
$interval = $d2->diff($d1);
$hour = $interval->format('%H').'<br>';

function hourMinute2Minutes($strHourMinute) {
    $from = date('Y-m-d 00:00:00');
    $to = date('Y-m-d '.$strHourMinute.':00');
    $diff = strtotime($to) - strtotime($from);
    $minutes = $diff / 60;
    return (int) $minutes;
}
function dateDifference($start_date, $end_date) {
    // calulating the difference in timestamps 
    $diff = strtotime($start_date) - strtotime($end_date);
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds
    return ceil(abs($diff / 86400));
}

// call dateDifference() function to find the number of days between two dates
$dateDiff = dateDifference($start_date, $end_date);
  
echo ($dateDiff*$hour)/(hourMinute2Minutes($dureation)/60);
?>
