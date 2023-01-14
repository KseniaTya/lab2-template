<?php
header('Content-Type: application/json; charset=utf-8');
    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    include "./utils.php";

    echo curl("http://reservation_system:80/get_reservations?username=$username");
