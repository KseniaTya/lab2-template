<?php
    $page = $_GET['page'] ?? 0;
    $size = $_GET['size'] ?? 50;
    $city = $_GET['city'] ?? "null";
    if($size < 0 || $page < 0){
        echo "incorrect values!";
    }
    else {
        $ch = curl_init("http://library_system:80/get_libraries?city=$city&page=$page&size=$size");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        echo $html;
    }

