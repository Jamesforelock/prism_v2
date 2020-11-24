<?php
// Подключает модальное окно для установки стендистов на стенд

require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/setAssistantsModal/setAssistantsModal.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/articleGetter.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

if($user['type'] === 'admin' && isset($_POST['standId'])){
    $id = intval($_POST['standId']);
    $article = getArticle($conn, $id, "stand");
    $articleName = $article['Name'];
    echo SetAssistantsModal($articleName, $id);
}
