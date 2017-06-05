<?php
    require ('template.php');

    function connectToDB()
    {
        //Connection to database.
        $link = mysqli_connect("localhost", "root", "1111", "Votings") or die(mysqli_error());
        //Check connection.
        if (mysqli_connect_errno()) {
            printf("Не удалось подключиться: %s\n", mysqli_connect_error());
            exit();
        }
        $link->query("SET NAMES 'utf8'");

        return $link;
    }

    function getVoting($link, $id)
    {
        $res = mysqli_query($link, "SELECT * FROM `votings` WHERE id ='".$id."'");
        return $res;
    }

    function getItemsThroughParentId($link, $table_name, $pid)
    {
        $res = mysqli_query($link, "SELECT * FROM `".$table_name."` WHERE `pid` = '".$pid."'");
        $items = array();

        while ($item = mysqli_fetch_array($res)) {
            $items[] = $item;
        }

        return $items;
    }

    function createVoting($link, $voting)
    {
        $questions = createItemList($link, "Questions", $voting['id'], "createQuestions");

        $parse = new parse_class();
        $parse->get_tpl('voting_page.html');
        $parse->set_tpl('{ID}', $voting['id']);
        $parse->set_tpl('{TITLE}', $voting['name']);
        $parse->set_tpl('{VOTING}', $questions);
        $parse->tpl_parse();

        return $parse->template;
    }

    function createQuestions($link, $question)
    {
        $answers = createItemList($link, "Answers", $question['id'], "createAnswer");

        $parse = new parse_class();
        $parse->get_tpl('template.html');
        $parse->set_tpl('{ID}', $question['id']);
        $parse->set_tpl('{QUESTION}', $question['text']);
        $parse->set_tpl('{VARIANTS}', $answers);
        $parse->tpl_parse();
        $parse->template .= "</br>";

        return $parse->template;
    }

    function createAnswer($link, $answer)
    {
        $parse = new parse_class();
        $parse->get_tpl('answer_template.html');
        $parse->set_tpl('{ID}', $answer['id']);
        $parse->set_tpl('{PID}', $answer['pid']);
        $parse->set_tpl('{ANSWER}', $answer['text']);
        $parse->tpl_parse();

        return $parse->template;
    }

    function createItemList($link, $table_name, $parent_table_id, $procedure)
    {
        $responce = getItemsThroughParentId($link, $table_name, $parent_table_id);
        $items = null;

        foreach ($responce as $item)
        {
            $items .= $procedure($link, $item);
        }

        return $items;
    }


    $link = connectToDB();
    $voting = mysqli_fetch_array(getVoting($link, 1));

    echo createVoting($link, $voting);

    $link->close();

