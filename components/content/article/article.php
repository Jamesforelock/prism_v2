<?php
if(!isset($_GET['article'])) { // Если данные статьи не установлены
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/vistavca/index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/article/articleInfo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/article/articleSecInfo.php';

$conn = $GLOBALS['conn'];

// Возвращает массив данных статьи и БД
function getArticleFromDB($conn, $table, $name) {
    $getArticle_query = "
    SELECT * FROM `$table` WHERE `Name` = '$name'";
    $foundArticle = mysqli_query($conn, $getArticle_query); // Поиск статьи по названию
    if(!$foundArticle) return false;
    $article = array();
    while($row = mysqli_fetch_array($foundArticle)) {
        $article['ID'] = $row['ID'];
        $article['name'] = $row['Name'];
        $article['type'] = $table;
        $article['description'] = $row['Description'];
        $article['picture'] = $row['Picture'];
        $article['date'] = $row['Date'];
    }
    return $article;
}

$articleName = openssl_decrypt(base64_decode($_GET['article']), "AES-128-ECB", "some password");
$articleName = htmlspecialchars(mysqli_real_escape_string($conn, $articleName));
$articleFromDb = getArticleFromDB($conn, 'excursion', $articleName);
$articleFromDb = $articleFromDb ? $articleFromDb : getArticleFromDB($conn, 'stand', $articleName);
if(!$articleFromDb) die("Sorry, but the article doesn't exist");
if($articleFromDb['picture'] === "") $articlePicture = 'noPhoto_a.png';
else $articlePicture = $articleFromDb['picture'];
articleInfo($articleFromDb['name'], $articleFromDb['description'], 'assets/i/' . $articleFromDb['type'] . '/' . $articlePicture, $articleFromDb['date']);

if($articleFromDb['type'] === "stand") {
    standSecInfo($conn, $articleFromDb['ID']);
}
?>