<?php
/*****2nd_lab******
* Programm for five-dimensional array printing with different colors for every dimension.
*/


//Array of colors.
$colors = array(
	"red",
	"blue",
	"green",
	"purple",
	"yellow"
	);

//Five-dimensional array.
$matrix = array(10, "my", true, "heart", 3.14, "in", 
		 array(100, "the", 1.27, "hilands", 2, "my", 
			array("heart", 1000, "is", 5.001, "not", true, "here", 
				array(10000, "my", 2.1, "heart", 242, "in", 
					array(100000, "the", 123, "hilands", "743", "chasing", 23.23, "a", true, "dear")
					)
				)
			)
		);

//Recursive function for matrix output.
function printArray($arr, $depth)
{
	//Changing font color due to the matrix depth level.
	echo "<div style=\"color:".$GLOBALS["colors"][$depth % count($GLOBALS["colors"])]."\">";	
	foreach ($arr as $value)
	{
		//Checking if the current item is array.
		if (is_array($value))
		{
			printArray($value, $depth + 1);	
		}	
		else
		{
			echo $value."  ";
		}
	}
	echo "</div><br />";
}

//Print function call.
printArray($matrix, 0);

?>
