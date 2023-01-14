<?php
include "./utils.php";
    $bookUid = $_POST['bookUid'];

    $libraryUid = $_POST['libraryUid'];
    $tillDate = urlencode($_POST['tillDate']);

    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    $numBooks = curl("http://reservation_system:80/num_books?username=$username");
    $numStars = curl("http://rating_system:80/num_stars?username=$username");
    $available_count  = curl("http://library_system:80/getBook?book_uid=$bookUid&library_uid=$libraryUid");
    // echo "available_count = $available_count ";
    //echo "tillDate = $tillDate numBooks = $numBooks numStars = $numStars";
    if($numBooks < $numStars && $available_count > 0){
        // процесс взятия книги
        $p = curl("http://reservation_system:80/add_reserv?username=$username&book_uid=$bookUid&library_uid=$libraryUid&till_date=$tillDate");
        $f = curl("http://library_system:80/count_book?book_uid=$bookUid&library_uid=$libraryUid&count=-1");
        echo "$p ";
    }else{
        echo "Error";
    }




