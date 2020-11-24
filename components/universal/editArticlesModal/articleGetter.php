<?php
function getArticle($conn, $id, $type) {
    $findArticle_query = "SELECT * FROM `$type` WHERE `ID` = $id";
    $foundArticle = mysqli_query($conn, $findArticle_query);
    $article = array();
    while($row = mysqli_fetch_array($foundArticle)) {
        $article['ID'] = $row['ID'];
        $article['Name'] = $row['Name'];
        $article['Description'] = $row['Description'];
        $article['Date'] = $row['Date'];
        $article['Picture'] = $row['Picture'];
    }
    return $article;
}