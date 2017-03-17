<?php

$colors = array(
	"red",
	"blue",
	"green",
	"purple",
	"yellow"
	);

$matrix = array(
	array(10, "my", true, "heart", 3.14, "in"), 
	array(100, "the", 1.27, "hilands", 2, "my"), 
	array("heart", 1000, "is", 5.001, "not", true, "here"), 
	array(10000, "my", 2.1, "heart", 242, "in"), 
	array(100000, "the", 123, "hilands", "743", "chasing", 23.23, "a", true, "dear")
	);

for ($i = 0; $i < count($matrix); $i++)
{
    echo "<div style=\"color:".$colors[$i]."\">";
	for ($j = 0; $j < count($matrix[$i]); $j++)
	{
		//echo "<div style='background:".$colors[$i]."'>".$matrix[$i][$j]."</div>";
        echo $matrix[$i][$j];
	}
	echo "</div><br />";
} 

?>
