<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/setAssistantsModal/setAssistantsModal.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/setAssistantsModal/assistantsGetter.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/setAssistantsModal/assistantModal.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

// Возвращает отрисованных ассистентов (с учетом уже установленных)
function renderAssistants($assistants, $setAssistantsLogins) {
    $renderedAssistants = "";
    foreach ($assistants as $assistant) {
        if($assistant['Picture'] === NULL) $assistantPicture = 'noPhoto_u.jpg';
        else $assistantPicture = $assistant['Picture'];
        $renderedAssistants .= AssistantModal($assistant['ID'], $assistant['Name'],
            $assistant['Description'], 'assets/i/assistant/'.$assistantPicture,
            in_array($assistant['Login'], $setAssistantsLogins), $assistant['Login']);
    }
    return $renderedAssistants;
}

if($user['type'] === 'admin' && $_POST['standId']){
    $standId = intval($_POST['standId']);
    $setAssistantsLogins = getSetAssistantsLogins($conn, $standId);
    $assistants = getAllAssistants($conn);
    $renderedAssistants = renderAssistants($assistants, $setAssistantsLogins);
    echo $renderedAssistants; // Производит ответ в виде отрисованных стендистов
}
