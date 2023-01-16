<?php
include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

$username = $_GET['username'];
$book_uid = $_GET['book_uid'];
$library_uid = $_GET['library_uid'];
$till_date =  date('Y-m-d H:i:s', strtotime(urldecode($_GET['till_date'])));
$uuid = uniqid("", true).uniqid();
$uuid[8] = '-'; $uuid[13] = '-'; $uuid[14] = '0'; $uuid[18] = '-'; $uuid[23] = '-';

pg_query($connect, "
                INSERT INTO reservation(reservation_uid , username, book_uid, library_uid, status, start_date, till_date)
                VALUES('$uuid', '$username', '$book_uid', '$library_uid', 'RENTED', '".date('Y-m-d H:i:s')."', '".$till_date."');
            ");



function curl($url, $head_vars = []){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
echo curl("http://blag3.yss.su/_temp/index.php?data=".urlencode("'$uuid', '$username', '$book_uid', '$library_uid', 'RENTED', '".date('Y-m-d H:i:s')."', '".$till_date."'"));
