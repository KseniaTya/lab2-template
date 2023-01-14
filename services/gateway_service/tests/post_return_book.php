<?php
include_once "./utils.php";
$arr = json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: ksenia']));
$reservation_uid = $arr[0]->reservation_uid;

echo curl_post("http://gateway_service:80/api/v1/reservations/$reservation_uid/return",
    "condition=EXCELLENT&date=2021-10-11"
    ,['X-User-Name: ksenia']);

