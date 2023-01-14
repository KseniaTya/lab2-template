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

    $array = json_decode(curl("http://library_system:80/get_books&page=$page&size=$size&libraryUid=$libraryUid".($_GET['showAll']=="true" ?"&showAll=true" :"&showAll=false")));
    $items = array_map(fn($item) => [
        "bookUid" => $item -> book_uid,
        "name"=> $item -> name,
        "author"=> $item -> author,
        "genre"=> $item -> genre,
        "condition" => $item -> condition,
        "availableCount" => $item -> availableCount
    ], $array);
    $result = [
        "page" => $page+1,
        "pageSize" => count($items) < $size ? count($items):$size,
        "totalElements" => count($items),
        "items" => $items
    ];
    echo json_encode($result);

}

