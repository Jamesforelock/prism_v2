<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;
if($user && $user['type'] === "visitor") { // Если тип пользователя = посетитель
    switch ($_GET['action']) {
        case "add": // Если посетитель желает добавить экскурсию
            echo addExcursion($GLOBALS['conn'], $_POST['excursionId'], $user['login']);
            break;
        case "delete": // Если посетитель желает удалить экскурсию
            echo deleteExcursion($GLOBALS['conn'], $_POST['excursionId'], $user['login']);
            break;
    }
}

// Производит запрос в БД на добавления записи в связующей таблице между экскурсиями и людьми
function addExcursion($db, $excursionId, $userLogin) {
    $findArticle_query = "SELECT * FROM `excursion` WHERE ID = $excursionId";
    $foundArticle = mysqli_query($db, $findArticle_query);
    // Если экскурсии с данным id не существует
    if(!$foundArticle || mysqli_num_rows($foundArticle) == 0) {
        return 0; // Добавлением связи не занимаемся
    }
    $addExcursion_query = "INSERT INTO `ev` (Excursion_ID, Visitor_Login) VALUES ('$excursionId', '$userLogin')";
    if(mysqli_query($db, $addExcursion_query)) {
        return 1;
    }
    return 0;
}

// Производит запрос в БД на удаление записи в связующей таблице между экскурсиями и людьми
function deleteExcursion($db, $excursionId, $userLogin) {
    $deleteExcursion_query = "DELETE FROM `ev` WHERE Excursion_ID = '$excursionId' AND Visitor_Login = '$userLogin'";
    if(mysqli_query($db, $deleteExcursion_query)) {
        return 1;
    }
    return 0;
}
