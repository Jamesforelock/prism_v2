<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/imagePathGetter.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

if($user['type'] === 'admin' && isset($_POST['articleId']) && isset($_POST['articleType'])){
    $id = intval($_POST['articleId']);
    $type = mysqli_real_escape_string($conn, $_POST['articleType']);
    echo deleteArticle($conn, $id, $type);
}

function deleteArticle($conn, $id, $table) {
    $deleteArticle_query = "DELETE FROM `$table` WHERE `ID` = $id";
    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/vistavca/'.getImagePath($conn, $id, $table);
    if(isset(pathinfo($imagePath)['extension'])) { // Если установлена картинка
        unlink($imagePath); // Удаляем картинку
    }
    if(mysqli_query($conn, $deleteArticle_query)) return 1;
    return 0;
}