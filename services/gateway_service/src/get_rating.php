<?php
include "./utils.php";
$username= getallheaders()['X-User-Name'] ?? "Test_User";
$numStars = curl("http://rating_system:80/num_stars?username=$username");
echo $numStars;