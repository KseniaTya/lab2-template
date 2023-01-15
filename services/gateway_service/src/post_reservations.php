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
        $reservation = json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: ksenia']));
        $rating = json_decode(curl("http://gateway_service:80/api/v1/rating", ['X-User-Name: ksenia']));
        $book = $reservation->book;
        $library = $reservation->library;
        $result = "{
          \"reservationUid\": \"$reservation->reservationUid\",
          \"status\": \"$reservation->status\",
          \"startDate\": \"$reservation->startDate\",
          \"tillDate\": \"$reservation->tillDate\",
          \"book\": {
            \"bookUid\": \"$book->bookUid\",
            \"name\": \"$book->name\",
            \"author\": \"$book->author\",
            \"genre\": \"$book->genre\"
          },
          \"library\": {
            \"libraryUid\": \"$library->libraryUid\",
            \"name\": \"$library->name\",
            \"address\": \"$library->address\",
            \"city\": \"$library->city\"
          },
          \"rating\": {
            \"stars\": \"$rating->stars\"
          }
        }";
        echo $result;
       // echo json_encode($reservation);

    }else{
        http_response_code(400);
        echo json_encode(["message" => "numBooks > numStars or available_count == 0"]);
    }



