<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/imagePathGetter.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

if($user['type'] === 'admin') {
// Удаление изображения из файловой структуры и восстановление исходного (из БД)
    if (isset($_POST['articleType'], $_POST['articleId'])) {
        if($_POST['imagePath'] != "cleared")
            unlink($_SERVER['DOCUMENT_ROOT'] . '/vistavca' . $_POST['imagePath']);
        $imagePath = getImagePath($conn, $_POST['articleId'], $_POST['articleType']);
        if(!isset(pathinfo($_SERVER['DOCUMENT_ROOT'] . '/vistavca/'.$imagePath)['extension'])) {
            echo "noPhoto";
        }
        else {
            echo getImagePath($conn, $_POST['articleId'], $_POST['articleType']);
        }
    }
}

