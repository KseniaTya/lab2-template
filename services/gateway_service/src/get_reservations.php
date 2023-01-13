<?php
    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    $ch = curl_init("http://reservation_system:80/get_reservations?username=$username");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    echo $html;
