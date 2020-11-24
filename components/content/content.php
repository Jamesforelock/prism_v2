<?php
    if(isset($_GET['section'])) { // Если в GET-запросе установлен параметр section
        switch ($_GET['section']) {
            case "articles":
                require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/articles.php';
                break;
            case "people":
                require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/people/people.php';
                break;
            case "profile":
                require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/profile/profile.php';
                break;
            case "article":
                require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/article/article.php';
                break;
            default: // Если значение параметра page будет некорректным
                echo "<span style='margin-left: 50px'>Sorry, but the page does not exist</span>";
                break;
        }
    }
    else { // Иначе возвращаем компонент со статьями
        require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/articles.php';
    }
?>