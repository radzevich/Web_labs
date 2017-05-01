<?php

define(INITIAL_DAY, 1);
define(INITIAL_MONTH, 9);

//$today = time();
//$first_day = ["year" => date("Y", $today), "month", "day"];
$calendar = array();


//Getting the first day of the first September week in seted year.
//(The August 28-th in case the 1-st of September is Thursday for example)
function getFirstDay($year)
{
    //Getting the week day number of September the 1-st.
    $time = mktime(0, 0, 0, INITIAL_MONTH, INITIAL_DAY, $year);
    $day = date("N", $time);
    //Calculation of the first day of week containing the 1-st of September.
    $first_week_day = mktime(0, 0, 0, INITIAL_MONTH, INITIAL_DAY - $day + 1, $year);

    return $first_week_day;
}


function nextDay($time)
{
    $day = date("d", $time);
    $month = date("m", $time);
    $year = date("Y", $time);

    return mktime(0, 0, 0, $month, $day + 1, $year);
}


function fillCalendar(&$calendar, $time)
{
    $index = 1;
    $day = getdate($time);

    
    do
    {
        $calendar[$index] = $day;
        //echo $day."<br />";
        $time = nextDay($time);
        $day = getdate($time);

    } while (($day[mday] != INITIAL_DAY) )&& ($day[mon] != INITIAL_MONTH));
}


$first_day = getFirstDay(2016);
fillCalendar($calendar, $first_day);

?>


