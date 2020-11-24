<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;

function findArticles($conn, $searchText, $table) {
    $findArticles_query = "SELECT *,
    (
        IF(`Name` LIKE '%$searchText%', 40, 0) +
        IF(`Description` LIKE '%$searchText%', 40, 0)
    ) AS `relevant`
    FROM `$table` HAVING `relevant` > 0 ORDER BY `relevant`";
    $foundArticles = mysqli_query($conn, $findArticles_query);
    $articles = array();
    while($row = mysqli_fetch_array($foundArticles)) {
        $articles[] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Description' => $row['Description'],
            'Date' => $row['Date'],
            'Picture' => $row['Picture']
        );
    }
    return $articles;
}

function getRenderedEditArticles($articles, $articleType) {
    $renderedArticles = "";
    switch ($articleType){
        case "excursion":
            foreach ($articles as $article) {
                if($article['Picture'] === "") $articlePicture = 'noPhoto_a.png';
                else $articlePicture = $article['Picture'];
                $renderedArticles = $renderedArticles . ExcursionEdit($article['ID'], $article['Name'], $article['Description'],
                    'assets/i/excursion/' . $articlePicture, $article['Date']);
            }
            break;
        case 'stand':
            foreach ($articles as $article) {
                if($article['Picture'] === "") $articlePicture = 'noPhoto_a.png';
                else $articlePicture = $article['Picture'];
                $renderedArticles = $renderedArticles . StandEdit($article['ID'], $article['Name'], $article['Description'],
                    'assets/i/stand/' . $articlePicture, $article['Date']);
            }
            break;
    }
    return $renderedArticles;
}

if($user['type'] === 'admin' && isset($_POST['searchText'])){
    $searchText = mysqli_real_escape_string($conn, $_POST['searchText']);
    $excursions = findArticles($conn, $searchText, 'excursion');
    $stands = findArticles($conn, $searchText, 'stand');
    $response = array();
    $response['excursions'] = !empty($excursions) ? getRenderedEditArticles($excursions, 'excursion') : null;
    $response['stands'] = !empty($stands) ? getRenderedEditArticles($stands, 'stand') : null;
    $response = json_encode($response);
    echo $response;
}
