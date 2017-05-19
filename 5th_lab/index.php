<?php

//Returns the list of tables in database.
function get_tables($link)
{
    $table_list = array();
    $res = mysqli_query($link,"SHOW TABLES");
    while($c_row = mysqli_fetch_array($res))
    {
        $table_list[] = $c_row[0];
    }
    return $table_list;
}

//Returns the list of columns in table.
function get_columns($link, $table_name)
{
    $column_list = mysqli_query($link, "DESCRIBE `$table_name`");
    return $column_list;
}

//Returns data from table.
function get_data($link, $table_name)
{
    $data_list = array();
    $data = $link->query("SELECT * FROM $table_name");
    while ($item_of_data = $data->fetch_array())
    {
        $data_list[] = $item_of_data;
    }
    return $data_list;
}

function print_table_structure($table_name, $column_list, $data_list)
{
    echo $table_name . "<br />";
    echo "<table border='1' cellpadding='5'>";

    //Header.
    echo "<tr>";
    foreach ($column_list as $column_info)
    {
        echo "<td>" . $column_info['Field'] . "</td>";
    }
    echo "</tr>";

    //Body.
    foreach ($data_list as $item)
    {
        echo "<tr>";
        foreach ($column_list as $column_info)
        {
            echo "<td>" . $item[$column_info['Field']] . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}


function main_proc($db_address, $db_login, $db_password, $db_name)
{
    //Connection to database.
    $link = mysqli_connect($db_address, $db_login, $db_password, $db_name);

    //Check connection.
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    }

    $link->query("SET NAMES 'utf8'");

    //Getting a list of tables in database.
    $result = get_tables($link);

    foreach ($result as $table_name) {
        //Getting a list of columns in table.
        $column_list = get_columns($link, $table_name);
        //Getting data from table.
        $data_list = get_data($link, $table_name);
        //Printing out data.
        print_table_structure($table_name, $column_list, $data_list);

        echo "<br /><br />";
    }

    //Database connection closing.
    $link->close();
}


if (isset($_POST["done"]))
{
    $db_address = ($_POST["host"]);
    $db_login = ($_POST["login"]);
    $db_password = ($_POST["password"]);
    $db_name = ($_POST["name"]);
    main_proc($db_address, $db_login, $db_password, $db_name);
}

