<?php
    //echo " city=".$_GET['city']."&page=".$_GET['page']."&size=".$_GET['size'];
    // echo file_get_contents("http://localhost:8060/");
    $ch = curl_init("http://library_system:80/");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    echo $html;

    include("./db_connect/postgress_connect.php");

