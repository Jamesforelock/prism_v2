<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

// Устанавливает (снимает) ассистента на стенд
function toggleAssistant($conn, $standId, $assistantLogin, $toggleType) {
    // Проверка существования ассистента (если его нет, то ф-ция возвращает false)
    $findAssistant_query = "SELECT * FROM `assistant` WHERE Login = '$assistantLogin'";
    $foundAssistant = mysqli_query($conn, $findAssistant_query);
    if (!$foundAssistant || mysqli_num_rows($foundAssistant) == 0) return false;
    // В зависимости от указанного типа взаимодействия со стендом производится установка (снятие) ассистента со стенда
    switch ($toggleType) {
        case "SET":
            $query = "INSERT INTO `sa` (`Stand_ID`, `Assistant_Login`) VALUES ($standId, '$assistantLogin')";
            break;
        case "UNSET":
            $query = "DELETE FROM `sa` WHERE `Stand_ID` = $standId AND `Assistant_Login` = '$assistantLogin'";
            break;
    }
    return mysqli_query($conn, $query);
}

if($user['type'] === 'admin' && isset($_POST['standId'], $_POST['assistantId'], $_POST['toggleType'])){
    $standId = intval($_POST['standId']);
    $assistantId = intval($_POST['assistantId']);
    $toggleType = $_POST['toggleType'];
    $getAssistant_query = "SELECT * FROM `assistant` WHERE `ID` = $assistantId";
    $assistantLogin = mysqli_fetch_array(mysqli_query($conn, $getAssistant_query))['Login'];
    $setAssistant_query = "INSERT INTO `sa` (`Stand_ID`, `Assistant_Login`) VALUES ($standId, '$assistantLogin')";
    // В зависимости от того, успешно ли произошло добавление, возвращается соотв. ответ (1 или 0)
    echo toggleAssistant($conn, $standId, $assistantLogin, $toggleType) ? 1 : 0;
}