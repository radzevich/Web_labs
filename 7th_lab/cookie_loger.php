<?php

require('index.php');


    $items_to_buy = $_COOKIE["items_to_buy"];
    $items_to_buy[] = $_POST["id"];
    setcookie("items_to_buy", $items_to_buy);

    print_r($_COOKIE);