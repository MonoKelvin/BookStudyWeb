<?php
require_once(dirname(__FILE__) . '\..\api\utility.php');

$id = @$_GET['id'];
$first = @$_GET['first'];
$number = @$_GET['number'];

if ($first !== null && $number !== null && $first >= 0 && $number >= 0) {
    getBookInfoWithNumber($first, $number, @$_GET['key']);
}

if ($id !== null && $id >= 0) {
    getBookInfoById($id);
}

function getBookInfoById($id)
{
    $db = MySqlAPI::getInstance();
    $res = $db->getRow(
        "select * from bookinfo as bi
        join bookdetail as bd
        on bi.id = bd.id and bi.id = " . $id
    );
    $db->close();

    echo json_encode($res);
}

function getBookInfoWithNumber($first = 0, $number = 20, $key = null)
{
    $db = MySqlAPI::getInstance();
    $res = [];
    if (!isValidString($key)) {
        $key = null;
    }
    if ($key != null) {
        $where = '';
        if (is_numeric($key)) {
            if (strlen($key) == 13) {
                $where = 'isbn13=' . $key;
            }
        } else {
            $where = "author like '%$key%' or title like '%$key%' or tags like '%$key%'";
        }
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS *
            from books_for_app where $where
            limit $first, $number"
        );
    } else {
        $res = $db->getAll("select SQL_CALC_FOUND_ROWS * from books_for_app limit $first, $number");
    }

    // $res['count'] = $db->getRow("select found_rows() num")['num'];

    $db->close();

    echo json_encode($res);
}
