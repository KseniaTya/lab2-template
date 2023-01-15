<?php
include_once "./utils.php";
$arr = json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: ksenia']));
$reservation_uid = $arr->reservationUid;


echo curl_post("http://gateway_service:80/api/v1/reservations/$reservation_uid/return",
    "
    {\n    \"condition\": \"EXCELLENT\",\n    \"date\": \"2021-10-11\"\n}"
    ,['X-User-Name: ksenia']);

