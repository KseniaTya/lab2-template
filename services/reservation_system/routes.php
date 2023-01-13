<?php
// error_reporting(0);
require_once __DIR__.'/router.php';
// ##################################################
// ##################################################
// ##################################################
// добавить резервацию
get('/add_reserv', "src/add_reserv.php");

// проверка работоспособности сайта
get('/manage/health', 'src/health.php');
// получить список резерваций пользователя
get('/get_reservations', "src/get_reservations.php");
// получить кол-во
get('/num_books', "src/get_num_rented_books.php");
