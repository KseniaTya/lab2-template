<?php
header('Content-Type: application/json; charset=utf-8');

$page = $_GET['page'] ?? 0;
$size = $_GET['size'] ?? 50;
if($size < 0 || $page < 0){
    echo "incorrect values!";
}
else {
    $_GET['showAll'] = $_GET['showAll'] ?? "false";
    include "./utils.php";
    echo curl("http://library_system:80/get_books&page=$page&size=$size&libraryUid=$libraryUid".($_GET['showAll']=="true" ?"&showAll=true" :"&showAll=false"));

}

