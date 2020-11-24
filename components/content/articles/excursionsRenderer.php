<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/articlesRenderer.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';
// Класс рисовальщика экскурсий
class ExcursionsRenderer extends ArticlesRenderer {
    public function render($items, $table) {
        $items = parent::reverseMySqlRes($items); // Переворачиваем результат выборки
        $userExcursions = $this->getUserExcursions(); // Получаем информацию о привязанных к посетителю экскурсиях
        $userExcursionsId = array(); // Массив id экскурсий, на которые записан посетитель
        foreach ($userExcursions as $userExcursion) { // Заполнение массива id экскурсий
            $userExcursionsId[] = $userExcursion['Excursion_ID'];
        }
        foreach ($items as $item) { // Отрисовка каждой экскурсии
            // Последним параметром булевое значение "Есть ли id данной экскурсии в
            // массиве id тех, что привязаны к посетителю"
            if($item['Picture'] === "") $articlePicture = 'noPhoto_a.png';
            else $articlePicture = $item['Picture'];
            echo Excursion($item['ID'], $item['Name'], $item['Description'], 'assets/i/' . $table . '/' . $articlePicture,
                $item['Date'], in_array($item['ID'], $userExcursionsId));
        }
    }

    // Возвращает экскурсии, на которые записан посетитель из связующей таблицы ev
    private function getUserExcursions() {
        if(!isset($GLOBALS['user'])) {
            return false;
        }
        $user = $GLOBALS['user'];
        $login = $user['login'];
        $conn = $GLOBALS['conn'];
        $getUserExcursions_query = "SELECT * FROM `ev` WHERE Visitor_Login = '$login'";
        $userExcursions = mysqli_query($conn, $getUserExcursions_query);
        if(!$userExcursions) {
            return false;
        }
        return parent::reverseMySqlRes($userExcursions);
    }
}