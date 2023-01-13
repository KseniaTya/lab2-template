<?php
    $page = $_GET['page'] ?? 0;
    $size = $_GET['size'] ?? 50;
    $city = $_GET['city'] ?? "null";
    if($size < 0 || $page < 0){
        echo "incorrect values!";
    }
    else {
        include "./utils.php";
        echo curl("http://library_system:80/get_libraries?city=$city&page=$page&size=$size");

    }

