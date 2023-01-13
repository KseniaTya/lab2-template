<?php

$page = $_GET['page'] ?? 0;
$size = $_GET['size'] ?? 50;
if($size < 0 || $page < 0){
    echo "incorrect values!";
}
else {
    $_GET['showAll'] = $_GET['showAll'] ?? "false";

    $ch = curl_init("http://library_system:80/get_books&page=$page&size=$size&libraryUid=$libraryUid".($_GET['showAll']=="true" ?"&showAll=true" :"&showAll=false"));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    echo $html;
}

