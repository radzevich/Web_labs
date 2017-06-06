<?php

    if (isset ($_POST['messageFF']))
    {
        $to = "virtuain98@gmail.com";
        $subject = "заполнена контактная форма с ".$_SERVER['HTTP_REFERER'];
        $message =  "Имя: ".$_POST['nameFF'].
                    "\nEmail: ".$_POST['contactFF'].
                    "\nIP: ".$_SERVER['REMOTE_ADDR'].
                    "\nАгент: ".$_SERVER['HTTP_USER_AGENT'].
                    "\nСообщение: ".$_POST['messageFF'];

        mail ($to, $subject, $message);
        echo ('<p style="color: green">Ваше сообщение получено, спасибо!</p>'); 
    }

    echo file_get_contents("./index.html");



