<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
</head>
<body>
    <form name="year_input" action="" method="get">
        <p align="left"> Insert year</p>
        <input type="text" name="year">
        <input type="submit" name="done" value="done">
        <p></p>
</form>
</body>
</html>


<?php

define(INITIAL_DAY, 1);
define(INITIAL_MONTH, 9);
define(DAYS_IN_CALENDAR, 364);
define(WINTER_BACKGROUND, "img/winter3.jpg");
define(SPRING_BACKGROUND, "img/spring2.jpg");
define(SUMMER_BACKGROUND, "img/summer4.jpg");
define(AUTUMN_BACKGROUND, "img/autumn2.jpg");

//$today = time();
//$first_day = ["year" => date("Y", $today), "month", "day"];
$calendar = array();
$holidays = array(
    array("day" => 1, "mon" => 1),
    array("day" => 23, "mon" => 2),
    array("day" => 8, "mon" => 3),
    array("day" => 1, "mon" => 5),
    array("day" => 9, "mon" => 5),
    array("day" => 3, "mon" => 7),
    array("day" => 7, "mon" => 11),
);


//Getting the first day of week seted day is a member.
//(The August 28-th in case the 1-st of September is Thursday for example)
function getFirstDay($year, $month, $day)
{
    //Getting the current week day.
    $time = mktime(0, 0, 0, $month, $day, $year);
    $first_day = date("N", $time);
    //Calculation of the first day of week.
    $first_week_day = mktime(0, 0, 0, $month, $day - $first_day + 1, $year);

    return $first_week_day;
}

//Getting next day info.
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
        $time = nextDay($time);
        $day = getdate($time);
        $index++;

    } while ($index <= DAYS_IN_CALENDAR);
}

//Checking if the current day is a holiday.
function checkHolidays($day)
{
    foreach ($GLOBALS["holidays"] as $item) {
        if (($item["day"] == $day[mday]) && ($item["mon"] == $day[mon]))
            return "red";
    }
    return "black";
}

function createTable($calendar)
{
    for ($i = 0; $i < 13; $i++) {
        showMonth($calendar, $i * 28 + 1);
    }
}

//Creating of 4-weeks table
function showMonth($calendar, $index)
{
    echo "<table border='2' 
            cellpadding='2' 
            width='99%' 
            height='34%' 
            align='left' 
            background='" . seasonBackground($calendar[$index + 14][mon]) .
        "'>";
    //Table header.
    echo "<tr><td colspan='8' 
            height='5%' 
            align='center'><font size='5' color='red'><b> " . $calendar[$index + 13][year] . "</b></font></td></tr>";
    //Cells contained month and the number of a day.
    for ($i = 1; $i <= 4; $i++) {
        echo "<tr>";
        echo "<td width='2%' align='center'>" . $i;
        for ($j = 0; $j < 7; $j++) {
            echo "<td align='center' 
                valign='center' 
                width='200' ><font color='".checkHolidays($calendar[$index])."'><b>" .$calendar[$index][month] . "</b><br/>" . $calendar[$index][mday]. "</font>";
            $index++;
            }
            echo "<tr/>";
        }
    echo "<table/><br />";
}


//Returns background image according to season.
function seasonBackground($month)
{
    switch ($month) {
        case 1:
        case 2:
        case 12:
            return WINTER_BACKGROUND;
        case 3:
        case 4:
        case 5:
            return SPRING_BACKGROUND;
        case 6:
        case 7:
        case 8:
            return SUMMER_BACKGROUND;
        case 9:
        case 10:
        case 11:
            return AUTUMN_BACKGROUND;
    }
}

//Getting request.
$year = intval($_GET["year"]);

//Creating of the calendar for the year in case it's number is valid.
if ($year) {
    $first_day = getFirstDay($year, INITIAL_MONTH, INITIAL_DAY);
    fillCalendar($calendar, $first_day);
    createTable($calendar);
}
//Creating of the calendar for the current year in case requested number is invalid.
else {
    $first_day = getFirstDay(date("Y", time()), INITIAL_MONTH, INITIAL_DAY);
    fillCalendar($calendar, $first_day);
    createTable($calendar);
}

?>

