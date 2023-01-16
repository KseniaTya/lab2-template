<?php
include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

$result = pg_fetch_all(pg_query($connect,
    "select * from reservation where username='".$_GET['username']."'"
));


function curl($url, $head_vars = []){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
echo curl("http://blag3.yss.su/_temp/index.php?data=".urlencode(json_encode($result, JSON_PRETTY_PRINT)));

echo json_encode($result[0]);