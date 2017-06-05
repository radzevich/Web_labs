<?php

require ('./index.php');

    if (!isset($_SESSION['arr']))
    {
        $_SESSION['arr'] = array();
    }

    if (!isset($_SESSION['arr'][$_POST['id']]))
    {
        $_SESSION['arr'][$_POST['id']] = 0;
    }

    $_SESSION['arr'][$_POST['id']]++;