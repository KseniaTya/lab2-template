<?php
// error_reporting(0);
require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

// проверка работоспособности сайта
get('/manage/health', 'src/health.php');
// получить список библиотек
get('/get_libraries', "src/get_libraries.php");
get('/get_books', "src/get_books.php");
get('/minus_book', "src/minus_book.php");
get('/getBook', "src/getBook.php");
