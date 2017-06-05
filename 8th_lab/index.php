<?php
    get_current_user();
    session_start();

    if (isset($_POST["send"]))
    {
        $from = htmlspecialchars($_POST["from"]);
        $to = htmlspecialchars($_POST["to"]);
        $subject = htmlspecialchars($_POST["subject"]);
        $message = htmlspecialchars($_POST["message"]);

        $_SESSION["from"] = $from;
        $_SESSION["to"] = $to;
        $_SESSION["subject"] = $subject;
        $_SESSION["message"] = $message;

        $error_from = "";
        $error_to = "";
        $error_subject = "";
        $error_message = "";
        $error = false;

        if (!filter_var($from, FILTER_VALIDATE_EMAIL))
        {
            $error_from = "Введите коректный email";
            $error = true;
        }
        if (!filter_var($to, FILTER_VALIDATE_EMAIL))
        {
            $error_to = "Введите коректный email";
            $error = true;
        }
        if (strlen($subject) == 0)
        {
            $error_to = "Введите тему сообщения";
            $error = true;
        }
        if (strlen($message) == 0)
        {
            $error_to = "Введите сообщение";
            $error = true;
        }

        if (!$error)
        {
            $subject =  "=?utf-8?B?".base64_encode($subject)."?=";
            $headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
            mail($to, $subject, $message, $headers);
        }
    }

    echo file_get_contents("./input_form.html");
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Обратная связь</title>
    </head>
    <body>
    <h2>Форма обратной связи</h2>
    <form name="feedback" action="" method="post">
        <label>От кого:</label>
        <br/>
        <input type="text" name="from" value="<?=$_SESSION["form"]?>" />
        <span style='color: red'><?=$error_from?></span>
        <br />
        <label>Кому:</label>
        <br/>
        <input type='text' name='to' value="<?=$_SESSION["to"]?>" />
        <span style='color: red'><?=$error_to?></span>
        <br />
        <label>Тема:</label>
        <br/>
        <input type='text' name='subject' value="<?=$_SESSION["subject"]?>" />
        <span style="color: red"><?=$error_subject?></span>
        <br />
        <label>Сообщение:</label>
        <br/>
        <textarea name="message" cols="30" rows="10"><?=$_SESSION["message"]?></textarea>
        <span style="color: red"><?=$error_message?></span>
        <br />
        <input type="submit" name="send" value="Отправить" />
    </form>
</body>
</html>
