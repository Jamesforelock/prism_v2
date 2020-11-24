<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
    session_start(); // Запуск сессии
    session_unset(); // Удаление всех значений из сессии
    session_destroy(); // Уничтожение сессии
    unset($GLOBALS['user']); // Удаление пользовательских данных из $GLOBALS
    if(isset($_COOKIE['hash'])) { // Если в куках есть hash
        $conn = connectToDb(); // Подключение к БД
        $hash = $_COOKIE['hash']; // Получение значения hash
        $deleteHash_query = 'DELETE FROM hu WHERE hash = "'. mysqli_real_escape_string($conn, $hash).'"';
        $deleteHash = mysqli_query($conn, $deleteHash_query);
        if($deleteHash) {
            setcookie("hash", "", time()-3600, "/"); // Удаление хеша из куков
        }
   }
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/vistavca/index.php');
    exit;