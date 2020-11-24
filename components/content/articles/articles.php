<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/dataConnector.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/renderData.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/intro.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/articlesRenderer.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/excursionsRenderer.php';
    $conn = $GLOBALS['conn'];
    $user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;
    if(isset($_GET['type'])) { // Проверяем, установлен ли тип статей
        $sectionType = $_GET['type'];
    }
    else { // Если тип статей не установлен
        $sectionType = 'excursion';
    }
    if(isset($_GET['page'])) { // Проверяем, задан ли параметр page
        $currentPage = $_GET['page'];
    }
    else { // Если page не задан, то отрисуется первая страница
        $currentPage = 1;
    }
    switch ($sectionType) {
        case 'excursion': // Если тип статей - экскурсии
            Intro("Excursions", "Here you can see our nice Excursions");
            echo '<div class="articles container appearable">';
            // Если пользователь - посетитель, то рисуем экскурсии как экскурсии,
            // то есть так, чтобы на них можно было записаться
            $data = getData($conn, 5, "excursion", $currentPage);
            if($user && $user["type"] === "visitor") {
                renderData($data, new ExcursionsRenderer());
                break;
            }
            // Иначе рисуем экскурсии как обычные статьи, на которых нельзя записываться
            renderData($data, new ArticlesRenderer());
            break;
        case 'stand': // Если тип статей - стенды
            Intro("Stands", "Here you can see our nice Stands");
            echo '<div class="articles container appearable">';
            $data = getData($conn, 5, "stand", $currentPage);
            renderData($data, new ArticlesRenderer());
            break;
    }
?>
</div> <!--Закрываем тег div, который открывался в одном из cas'ов-->
    <?php
    // Если мы находимся на первой странице, то "слушаем" новые статьи
    // с учетом типа статей ($sectionType)
    if($currentPage === 1) echo '
        <script src="./scripts/newArticleListener.js"></script>
        <script>listenNewArticle("'.$sectionType.'")</script>
        ';
    ?>