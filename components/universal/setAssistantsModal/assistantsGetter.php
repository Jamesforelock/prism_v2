<?php

// Получение массива всех ассистентов
function getAllAssistants($conn) {
    $getAllAssistants_query = "SELECT * FROM `assistant` ORDER BY `ID` DESC";
    $foundAssistants = mysqli_query($conn, $getAllAssistants_query);
    $assistants = array();
    while($row = mysqli_fetch_array($foundAssistants)) {
        $assistants[] = array(
            "ID" => $row['ID'],
            "Login" => $row['Login'],
            "Name" => $row['Name'],
            "Description" => $row['Description'],
            "Picture" => $row['Picture']
        );
    }
    return $assistants;
}

// Возвращает из связующей таблицы логины ассистентов, что установлены на стенд
function getSetAssistantsLogins($conn, $standId) {
    $getAssistants_query = "SELECT * FROM `sa` WHERE `Stand_ID` = $standId";
    $foundAssistantsLogins = mysqli_query($conn, $getAssistants_query);
    $assistantsLogins = array();
    while($row = mysqli_fetch_array($foundAssistantsLogins)) {
        $assistantsLogins[] = $row['Assistant_Login'];
    }
    return $assistantsLogins;
}