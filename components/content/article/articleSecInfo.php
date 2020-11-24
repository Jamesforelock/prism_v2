<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vistavca/components/content/people/peopleRenderer.php';

function standSecInfo($conn, $id) {
    $getUserExcursions_query = "SELECT * FROM `sa` WHERE `Stand_ID` = $id";
    $standAssistants = mysqli_query($conn, $getUserExcursions_query); // Получаем назначенные стенды
    $standAssistantsId = array();
    while ($row = mysqli_fetch_array($standAssistants)) {
        $standAssistantsId[] = $row['Assistant_Login']; // Получаем логины привязанных к стенду стендистов
    }
    if(count($standAssistantsId) != 0) { // Если у стенда есть привязаные стендисты
        echo '
         <hr>
         <div class="container">
         <h2>Set stand assistants</h2>
         ';
        $getAssistants_query = "SELECT * FROM `assistant` WHERE ";
        // Цикл формирования запроса
        // С каждой итерацией добавляется OR для добавления в результат выборки очередного ассистента
        for($i = 0; $i<count($standAssistantsId); $i++) {
            $getAssistants_query = $getAssistants_query . "Login = '$standAssistantsId[$i]'";
            if($i === count($standAssistantsId) - 1) continue;
            $getAssistants_query = $getAssistants_query . " OR ";
        }
        // Получаем и отображаем привязанных к стенду стендистов
        $assistants = mysqli_query($conn, $getAssistants_query);
        $renderer = new PeopleRenderer();
        $renderer->render($assistants, 'assistant');
        echo '</div>';
    }

}