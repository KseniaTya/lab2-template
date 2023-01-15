<?php
header('Content-Type: application/json; charset=utf-8');
include "./utils.php";
$username= getallheaders()['X-User-Name'] ?? "Test_User";
$numStars = curl("http://rating_system:80/num_stars?username=$username");
$result = ["stars" => $numStars];

echo json_encode($result);