<?php
include "./utils.php";
echo curl("https://gateway_service:80/api/v1/libraries?city=Москва&page=0&size=10");