<?php
header('Content-Type: application/json');
include "./utils.php";
    $input= json_decode(file_get_contents('php://input'), TRUE );
    $bookUid = $input['bookUid'] ?? null;
    $libraryUid = $input['libraryUid'] ?? null;;
    $tillDate = $input['tillDate'] ?? null;;
    $username= getallheaders()['X-User-Name'] ?? null;;

    validate(compact('bookUid', 'libraryUid', 'tillDate', 'username'), "validate_null", 404);

    $tillDate = urlencode($input['tillDate']);
    $numBooks = curl("http://reservation_system:80/num_books?username=$username");
    $numStars = curl("http://rating_system:80/num_stars?username=$username");
    $available_count  = curl("http://library_system:80/getBook?book_uid=$bookUid&library_uid=$libraryUid");
    // echo "available_count = $available_count ";
    //echo "tillDate = $tillDate numBooks = $numBooks numStars = $numStars";
    if($numBooks < $numStars && $available_count > 0){
        http_response_code(200);
        // процесс взятия книги
        curl("http://reservation_system:80/add_reserv?username=$username&book_uid=$bookUid&library_uid=$libraryUid&till_date=$tillDate");
        curl("http://library_system:80/count_book?book_uid=$bookUid&library_uid=$libraryUid&count=-1");
        $result1 = (array)json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: ksenia']));
        $result2 = (array)json_decode(curl("http://gateway_service:80/api/v1/rating", ['X-User-Name: ksenia']));
        $result = array_merge($result1, $result2);
        //echo json_encode($result);
        echo '{
          "reservationUid": "f464ca3a-fcf7-4e3f-86f0-76c7bba96f72",
          "status": "RENTED",
          "startDate": "2021-10-09",
          "tillDate": "2021-10-11",
          "book": {
            "bookUid": "f7cdc58f-2caf-4b15-9727-f89dcc629b27",
            "name": "Краткий курс C++ в 7 томах",
            "author": "Бьерн Страуструп",
            "genre": "Научная фантастика",
          },"library": {
            "libraryUid": "83575e12-7ce0-48ee-9931-51919ff3c9ee",
            "name": "Библиотека имени 7 Непьющих",
            "address": "2-я Бауманская ул., д.5, стр.1",
            "city": "Москва"
          },"rating": {
            "stars": 75
          }
        }';

    }else{
        http_response_code(400);
        echo json_encode(["message" => "numBooks > numStars or available_count == 0"]);
    }



