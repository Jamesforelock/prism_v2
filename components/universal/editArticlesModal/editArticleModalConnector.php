<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/editArticleModal.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/articleGetter.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

if($user['type'] === 'admin' && isset($_POST['articleId']) && isset($_POST['articleType'])){
    $id = intval($_POST['articleId']);
    $type = mysqli_real_escape_string($conn, $_POST['articleType']);
    $articleData = getArticle($conn, $id, $type);
    echo EditArticleModal($articleData, $type);
}



