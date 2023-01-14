<?php
include "./utils.php";
$condition = $_POST['condition'];
$date = urlencode($_POST['date']);
$username= getallheaders()['X-User-Name'] ?? "Test_User";
// сдать книгу и получить данные о книге из резервации
$reservationData = curl("http://reservation_system:80/return_book?username=$username&reservationUid=$reservationUid&date=$date");
if($reservationData == "[]"){
    echo "Error";
}
else{
    $arr = json_decode($reservationData);
    // увеличить счетчик доступных книг
    //$numBooks = curl("http://library_system:80/return_book?username=$username&reservationUid=$reservationUid");
    $f = curl("http://library_system:80/count_book?book_uid=$arr->book_uid&library_uid=$arr->library_uid&count=1");

    $book = json_decode(curl("http://library_system:80/get_book_by_uid?book_uid=$arr->book_uid"));
    $stars = 0;
    if($arr->status == 'EXPIRED'){
        $stars -= 10;
    }
    if($book->condition != $condition){
        $stars -= 10;
        curl("http://library_system:80/change_condition_book?book_uid=$arr->book_uid&condition=$condition");
    }
    if($stars == 0){
        $stars+= 1;
    }
    //todo
    curl("http://rating_system:80/change_rating?username=$username&stars=$stars");


    // изменить рейтинг

}


