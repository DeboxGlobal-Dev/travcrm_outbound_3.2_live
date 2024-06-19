<?php
// for week days date
function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
{
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $dateArr = array();

    do
    {
        if(date("w", $startDate) != $weekdayNumber)
        {
            $startDate += (24 * 3600); // add 1 day
        }
    } while(date("w", $startDate) != $weekdayNumber);


    while($startDate <= $endDate)
    {
        $dateArr[] = date('Y-m-d', $startDate);
        $startDate += (7 * 24 * 3600); // add 7 days
    }

    return($dateArr);
}

// for date range in array
function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

// function timeing

function getIntervalTime($intervalTime)
{
$timeArr=array();
$starttime = '00:00:00';
$time = new DateTime($starttime);
//$interval = new DateInterval('PT15M');
$interval = new DateInterval($intervalTime);
$temptime = $time->format('H:i:s');

do {
   //echo $temptime . '<br />';
   $timeArr[]=$temptime;
   $time->add($interval);
   $temptime = $time->format('H:i:s');
} while ($temptime !== $starttime);


return $timeArr;


}




?>