<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;
if($user['type'] === "admin") {
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/multiButton.php';
}