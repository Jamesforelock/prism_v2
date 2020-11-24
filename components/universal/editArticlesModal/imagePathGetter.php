<?php
function getImagePath($conn, $articleId, $articleType) {
    $articleId = intval($articleId);
    $articleType = mysqli_real_escape_string($conn, $articleType);
    $getArticle_query = "SELECT * FROM `$articleType` WHERE `ID` = $articleId";
    $articleImageName = mysqli_fetch_array(mysqli_query($conn, $getArticle_query))['Picture'];
    return 'assets/i/'.$articleType.'/'.$articleImageName;
}