<?php
header('Content-Type: application/json; charset=utf-8');
    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    include "./utils.php";

    $reservation = json_decode(curl("http://reservation_system:80/get_reservations?username=$username"));
    $book = json_decode(curl("http://library_system:80/get_book_by_uid?book_uid=".$reservation[0]->book_uid));
    $library = json_decode(curl("http://library_system:80/get_library_by_uid?library_uid=".$reservation[0]->library_uid));

    $reserv = $reservation[0];
    $result = [
        "reservationUid" => $reserv -> reservation_uid,
        "status" => 'RENTED',
        "startDate" => $reserv -> start_date,
        "tillDate" => $reserv -> till_date,
        "book" => [
            "bookUid" => $book -> book_uid,
            "name" => $book -> name,
            "author" => $book -> author,
            "genre" => $book -> genre
        ],
        "library" => [
            "libraryUid" => $library -> library_uid,
            "name" => $library -> name,
            "address" => $library -> address,
            "city" => $library -> city
        ]
    ];
    echo json_encode($result);

