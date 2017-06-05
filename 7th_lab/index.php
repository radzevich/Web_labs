<?php
get_current_user();
session_start();
require('template.php');

//Returns link to database.
function connectToDB()
{
    //Connection to database.
    $link = mysqli_connect("localhost", "root", "1111", "shop") or die(mysqli_error());
    //Check connection.
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    }
    $link->query("SET NAMES 'utf8'");

    return $link;
}

//Returns the list of items in database.
function getCatalog($link)
{
    $res = mysqli_query($link, "SELECT * FROM `items`");

    $catalog = array();

    while ($item = mysqli_fetch_array($res))
    {
        $catalog[] = $item;
    }

    return $catalog;
}

//Returns the list of items added to the cart by user.
function getCatalogFromCart($link, $arr)
{
    $res = mysqli_query($link, "SELECT * FROM `items` WHERE `id` IN (".implode(',',array_keys($arr)).")");

    $catalog = array();

    while ($item = mysqli_fetch_array($res))
    {
        $catalog[] = $item;
    }

    return $catalog;
}

//Creates main page from template.
function createCatalogPage($catalog)
{
    $item_list = createItemList($catalog);

    $parse = new parse_class();
    $parse->get_tpl('./Templates/main_page.html');
    $parse->set_tpl('{CONTENT}', $item_list);
    $parse->set_tpl('{TITLE}', "Магазин");
    $parse->tpl_parse();

    return $parse->template;
}

//Creates item list according to the list in database.
function createItemList($catalog)
{
    $item_list = null;

    foreach ($catalog as $item)
    {
        $item_list .= createItem($item);
    }

    return $item_list;
}

//Creates item from the template.
function createItem($response)
{
    $parse = new parse_class();
    $parse->get_tpl('./Templates/item_template.html');
    $parse->set_tpl('{CUSTOMIZER}', setCatalogType($response['id']));
    $parse->set_tpl('{NAME}', $response['name']);
    $parse->set_tpl('{DESCRIPTION}', $response['description']);
    $parse->set_tpl('{CITY}', $response['city']);
    $parse->set_tpl('{COST}', $response['cost']);
    $parse->set_tpl('{IMAGE}', $response['image']);
    $parse->tpl_parse();

    return $parse->template;
}

//Add submit button or count field due to the type of window (shop or cart).
function setCatalogType($id)
{
    $parse = new parse_class();

    if (!isset($_POST['done']))
    {
        $parse->get_tpl('./Templates/add_button_template.html');
        $parse->set_tpl('{ID}', $id);
    }
    else
    {
        $parse->get_tpl('./Templates/counter_template.html');
        $parse->set_tpl('{COUNTER}', $_SESSION['arr'][$id]);
    }

    $parse->tpl_parse();

    return $parse->template;
}


//Connect to database;
$link = connectToDB();

//Create and show main shop page if 'done' button hasn't been pushed.
if (!isset($_POST['done']))
{
    echo createCatalogPage(getCatalog($link));
}
//Create and show main shop page if 'done' button has been pushed.
else
{
    echo createCatalogPage(getCatalogFromCart($link, $_SESSION['arr']));
    unset($_SESSION['arr']);
}

//Close database connection.
$link->close();