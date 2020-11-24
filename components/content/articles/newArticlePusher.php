<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
$conn = connectToDb(); // Подключение к БД
session_start();
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;
session_write_close(); // Для избежания заморозки браузера (чтобы не занималась сессия процессом обработки новых статей)
$currentLastArticleId = $_POST['lastArticleId']; // ID текущей отрисованной статьи на странице
$articlesType = $_POST['articlesType']; // Тип рассматриваемых статей (экскурсии и стенды)
$getLastArticle_query = "SELECT * FROM `$articlesType` WHERE `ID` > '$currentLastArticleId'";
while(true) {
    $lastArticle = mysqli_query($conn, $getLastArticle_query);
    // Если найдена статья, id у которой больше id последней отрисованной статьи
    if(mysqli_num_rows($lastArticle) != 0) {
        $lastArticleArr = array(); // Массив для значений новой статьи
        while ($row = mysqli_fetch_array($lastArticle)) { // Пакуем новые значения в массив
            $lastArticleArr['ID'] = $row['ID'];
            $lastArticleArr['Name'] = $row['Name'];
            $lastArticleArr['Description'] = $row['Description'];
            $lastArticleArr['Date'] = $row['Date'];
            $lastArticleArr['Picture'] = $row['Picture'];
        }
        if($lastArticleArr['Picture'] === "") $articlePicture = 'noPhoto_a.png';
        else $articlePicture = $lastArticleArr['Picture'];
        // Если рисуем экскурсии для посетителя
        if($user && $user['type'] === "visitor" && $articlesType === "excursion") {
            $htmlArticle = Excursion($lastArticleArr['ID'], $lastArticleArr['Name'], $lastArticleArr['Description'], 'assets/i/' . $articlesType . '/' . $articlePicture,
                $lastArticleArr['Date'], false);
        }
        // Если рисуем статьи не для посетителя
        else {
            $htmlArticle = Article($lastArticleArr['ID'], $lastArticleArr['Name'], $lastArticleArr['Description'], 'assets/i/' . $articlesType . '/' . $articlePicture,
                $lastArticleArr['Date']);
        }
        $data = array("html" => $htmlArticle); // Загрузка полученного html-кода
        echo json_encode($data); // Отвечаем ajax-запросу массивом data в json формате
        flush(); // Очищаем буфер вывода
        exit; // Выходим из скрипта
    }
    sleep(5); // Ждем 5 секунд перед тем, как осуществить ешё один запрос нахождения новой статьи
}
