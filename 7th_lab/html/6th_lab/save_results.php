<?php

    require ('index.php');
    require ('Submit_window.html');

    function incVal($link, $id)
    {
        mysqli_query($link, "UPDATE `Answers` SET answers_num = answers_num + 1 WHERE id = '".$id."'");
    }


    if (isset($_POST["done"]))
    {
        $link = connectToDB();

        foreach ($_POST as $value)
        {
            if ($value == "Send") {
                continue;
            }
            incVal($link, $value);
        }
	
	if(empty('Submit_window.html') || !file_exists('Submit_window.html'))
        {
            return false;
        }
        else
        {
            echo file_get_contents('Submit_window.html');
        }

        $link->close();
    }




