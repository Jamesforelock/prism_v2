<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';

// Показывает информацию для посетителя (список добавленных экскурсий)
function SecVisitorInfo ($conn, $login) {
    $getUserExcursions_query = "SELECT * FROM `ev` WHERE Visitor_Login = '$login'";
    $userExcursions = mysqli_query($conn, $getUserExcursions_query); // Получаем пользовательские экскурсии
    $userExcursionsId = array();
    while ($row = mysqli_fetch_array($userExcursions)) {
        $userExcursionsId[] = $row['Excursion_ID']; // Получаем ID пользовательских экскурсий
    }
    if(count($userExcursionsId) != 0) { // Если у пользователя есть добавленные экскурсии
        echo '
         <span class="secInfo__title">The excursions you signed up for</span>
         <div class="secInfo__scrollContent">
         ';
        $getExcursions_query = "SELECT * FROM `excursion` WHERE ";
        // Цикл формирования запроса
        // С каждой итерацией добавляется OR для добавления в результат выборки очередной экскурсии
        for($i = 0; $i<count($userExcursionsId); $i++) {
            $getExcursions_query = $getExcursions_query . "ID = $userExcursionsId[$i]";
            if($i === count($userExcursionsId) - 1) continue;
            $getExcursions_query = $getExcursions_query . " OR ";
        }
        // Получаем и отображаем пользовательские экскурсии
        $excursions = mysqli_query($conn, $getExcursions_query);
        while($excursion = mysqli_fetch_array($excursions)) {
            if($excursion['Picture'] === "") $articlePicture = 'noPhoto_a.png';
            else $articlePicture = $excursion['Picture'];
            echo Excursion($excursion['ID'], $excursion['Name'], $excursion['Description'], 'assets/i/excursion/' . $articlePicture,
            $excursion['Date'], "true");
        }
    }
    echo '</div>';
}

// Показывает информацию для стендистов (список назначенных стендов)
function SecAssistantInfo ($conn, $login) {
    $getUserExcursions_query = "SELECT * FROM `sa` WHERE Assistant_Login = '$login'";
    $userStands = mysqli_query($conn, $getUserExcursions_query); // Получаем назначенные стенды
    $userStandsId = array();
    while ($row = mysqli_fetch_array($userStands)) {
        $userStandsId[] = $row['Stand_ID']; // Получаем ID пользовательских экскурсий
    }
    if(count($userStandsId) != 0) { // Если у пользователя есть добавленные экскурсии
        echo '
         <span class="secInfo__title">The stands you are assigned to</span>
         <div class="secInfo__scrollContent">
         ';
        $getStands_query = "SELECT * FROM `stand` WHERE ";
        // Цикл формирования запроса
        // С каждой итерацией добавляется OR для добавления в результат выборки очередной экскурсии
        for($i = 0; $i<count($userStandsId); $i++) {
            $getStands_query = $getStands_query . "ID = $userStandsId[$i]";
            if($i === count($userStandsId) - 1) continue;
            $getStands_query = $getStands_query . " OR ";
        }
        // Получаем и отображаем пользовательские экскурсии
        $stands = mysqli_query($conn, $getStands_query);
        while($stand = mysqli_fetch_array($stands)) {
            if($stand['Picture'] === "") $articlePicture = 'noPhoto_a.png';
            else $articlePicture = $stand['Picture'];
            echo Article($stand['ID'], $stand['Name'], $stand['Description'], 'assets/i/stand/' . $articlePicture,
                $stand['Date']);
        }
    }
    echo '</div>';
}