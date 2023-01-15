<?php
header('Content-Type: application/json; charset=utf-8');
    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    include "./utils.php";

    $reservation = json_decode(curl("http://reservation_system:80/get_reservations?username=$username"));
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
        }";
echo $result;
