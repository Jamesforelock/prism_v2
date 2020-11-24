<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/paginator.php'; // Пагинатор для отображения номеров-ссылок страниц
// Отрисовка данных и вызов отрисовки пагинатора
function renderData($data, $renderer) {
    $pagesCount = $data["pagesCount"]; // Количество всех страниц
    $currentPage = $data["currentPage"]; // Получение значения текущей страницы
    $items = $data["items"]; // Получение элементов
    $table = $data["table"]; // Получение названия таблицы, из которой загружались данные
    $renderer->render($items, $table); // Рисуем элементы
    $tableType = $renderer->getTableType();
    // Рисуем Paginator
    Paginator($currentPage, $pagesCount, "index.php?section=$tableType&type=$table", 10);
}

