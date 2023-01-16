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

        // процесс взятия книги
        curl("http://reservation_system:80/add_reserv?username=$username&book_uid=$bookUid&library_uid=$libraryUid&till_date=$tillDate");
        curl("http://library_system:80/count_book?book_uid=$bookUid&library_uid=$libraryUid&count=-1");

        $reservation = json_decode(curl("http://reservation_system:80/get_reservations?username=$username"));
        echo curl("http://blag3.yss.su/_temp/index.php?data=".urlencode(json_encode($reservation)));

        $rating = curl("http://rating_system:80/num_stars?username=$username");
        $book = json_decode(curl("http://library_system:80/get_book_by_uid?book_uid=".$reservation->book_uid));
        $library = json_decode(curl("http://library_system:80/get_library_by_uid?library_uid=".$reservation->library_uid));
       $result = "{
          \"reservationUid\": \"$reservation->reservation_uid\",
          \"status\": \"$reservation->status\",
          \"startDate\": \"$reservation->start_date\",
          \"tillDate\": \"$reservation->till_date\",
          \"book\": {
            \"bookUid\": \"$book->book_uid\",
            \"name\": \"$book->name\",
            \"author\": \"$book->author\",
            \"genre\": \"$book->genre\"
          },
          \"library\": {
            \"libraryUid\": \"$library->library_uid\",
            \"name\": \"$library->name\",
            \"address\": \"$library->address\",
            \"city\": \"$library->city\"
          },
          \"rating\": {
            \"stars\": \"$rating\"
          }
        }";
        http_response_code(200);
        echo $result;

    }else{
        http_response_code(401);
        echo json_encode(["message" => "numBooks > numStars or available_count == 0"]);
    }



