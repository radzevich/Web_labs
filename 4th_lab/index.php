<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
</head>
<body>
<form name="year_input" action="" method="get">
    <p align="left"> Insert string</p>
    <input type="text" name="text">
    <input type="submit" name="done" value="done">
    <p></p>
</form>
</body>
</html>

<?php

define (DEFAULT_FONT, "");
define (INTEGER_FONT, "style='color:blue;'");
define (FLOAT_FONT, "style='color:red;'");

define (SEPARATORS, "[\.,;!?]*");
define (INTEGER_PAT, "^-?\d+");
define (FLOAT_PAT, "^-?\d+\.\d+");

//$str = '. .-32.,. sdf 533.1..!';

//Check if word accords to pattern.
function answerTheDescription($word, $pattern)
{
    $local_pat = "/".$pattern.SEPARATORS."[^0-9]*$/";
    return (preg_match($local_pat, $word) > 0);
}

//Output function.
function printWord($word, $font)
{
    echo "<font "."$font".">"."$word[0]"."</font>";

    for ($i = 1; $i < count($word); $i++)
    {
        echo "<font ".DEFAULT_FONT.">"."$word[$i]"."</font>";
    }

    echo " ";
}

function splitString($word, $pattern)
{
    $local_pat = "/".$pattern."/";
    preg_match($local_pat, $word, $matches);
    $splited_word[0] = $matches[0];
    $local_pat = "/[^0-9]*$/";
    preg_match($local_pat, $word, $matches);
    $splited_word[1] = $matches[0];

    return $splited_word;
}

//Rounding float value.
function roundFloat($word, $pattern)
{
    $local_pat = "/".$pattern."\.\d{1}/";
    preg_match($local_pat, $word, $matches);
    return $matches[0];
}

$str = ($_GET["text"]);
$words = explode(" ", $str);

echo "<p>Input: ".$str."</p>";
echo "<p>Output: ";

foreach ($words as $word)
{
    $font = DEFAULT_FONT;
    $splited_word = array("0" => $word);

    //Check if value is float.
    if (answerTheDescription($word, FLOAT_PAT)) {
        $font = FLOAT_FONT;
        $splited_word = splitString($word, FLOAT_PAT);
        $splited_word[0] = roundFloat($splited_word[0], INTEGER_PAT);
    }
    //Check of value is integer;
    else if (answerTheDescription($word, INTEGER_PAT)) {
        $font = INTEGER_FONT;
        $splited_word = splitString($word, INTEGER_PAT);
    }

    //Output.
    printWord($splited_word, $font);
}

echo "</p>";

