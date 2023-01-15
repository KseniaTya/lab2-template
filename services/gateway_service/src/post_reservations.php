<?php
header('Content-Type: application/json; charset=utf-8');
include "./utils.php";
    echo $_POST['bookUid'];
    $bookUid = $_POST['bookUid'] ?? null;
    $libraryUid = $_POST['libraryUid'] ?? null;;
    $tillDate = $_POST['tillDate'] ?? null;;
    $username= getallheaders()['X-User-Name'] ?? null;;

    validate(compact('bookUid', 'libraryUid', 'tillDate', 'username'), "validate_null", 400);

    $tillDate = urlencode($_POST['tillDate']);
    $numBooks = curl("http://reservation_system:80/num_books?username=$username");
    $numStars = curl("http://rating_system:80/num_stars?username=$username");
    $available_count  = curl("http://library_system:80/getBook?book_uid=$bookUid&library_uid=$libraryUid");
    // echo "available_count = $available_count ";
    //echo "tillDate = $tillDate numBooks = $numBooks numStars = $numStars";
    if($numBooks < $numStars && $available_count > 0){
        // процесс взятия книги
        curl("http://reservation_system:80/add_reserv?username=$username&book_uid=$bookUid&library_uid=$libraryUid&till_date=$tillDate");
        curl("http://library_system:80/count_book?book_uid=$bookUid&library_uid=$libraryUid&count=-1");
        $result = json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: ksenia']));
        $result = (object) array_merge((array)$result, (array)json_decode(curl("http://gateway_service:80/api/v1/rating", ['X-User-Name: ksenia'])));
        echo json_encode($result);

    }else{
        echo "numBooks > numStars or available_count == 0 ";
    }

    function validate($array, $func, $err_code){
        $result = [];
        foreach ($array as $k => $v){
            $result += $func($k, $v, "variable isnt set");
        }
        if($result != []){
            http_response_code($err_code);
            echo json_encode($result);
            exit;
        }
    }
    function validate_null($k, $v, $message):array{
        return $v != null ? [] : ["$k" => "$message"];
    }



