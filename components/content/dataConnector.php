<?php
// Возвращает количество всех элементов в таблице
function getAllItemsCount($conn, $table) {
    $query_getAllItemsCount = 'SELECT COUNT(*) FROM '.$table;
    $getAllItemsCount = mysqli_query($conn, $query_getAllItemsCount);
    return mysqli_fetch_array($getAllItemsCount)[0]; // Число всех элементов в таблице БД
}

//  Возвращает число всех страниц при данном количестве всех элементов и количестве выводимых элементов на страницу
function getPagesCount($allItemsCount, $renderedItemsCount) {
    return ceil($allItemsCount / $renderedItemsCount); // Число всех страниц
}

// Возвращает массив, состоящий из порядкового номера первого и последнего элементов на странице
// Пример: если количество элементов = 20, то вывести элементы от 20-5 до 20 на 1 странице
// Пример: если количество элементов = 20, то вывести элементы от 20-10 до 20-5 на 2 странице
function getItemsIndexes($allItemsCount, $renderedItemsCount, $currentPage) {
    $first = $allItemsCount - $renderedItemsCount * $currentPage;
    $last = $allItemsCount - $renderedItemsCount * ($currentPage - 1);

    return array("first" => $first, "last" => $last);
}

// Возвращает записи из БД
function getItems($conn, $table, $itemsIndexes) {
    $first = $itemsIndexes["first"];
    $last = $itemsIndexes["last"];
    if($first < 0) $first = 0;
    $query_getItems = "SELECT * FROM `$table` LIMIT $first, $last";
    return $items = mysqli_query($conn, $query_getItems);
}

// Возвращает записи из БД для текущей страницы с заданным числом рисуемых элементов
function getData($conn, $renderedItemsCount, $table, $currentPage) {
    $allItemsCount = getAllItemsCount($conn, $table); // Число всех элементов
    $pagesCount = getPagesCount($allItemsCount, $renderedItemsCount); // Количество всех страниц
    $itemsIndexes = getItemsIndexes($allItemsCount, $renderedItemsCount, $currentPage); // Порядковые номера первого и второго элементов
    $items = getItems($conn, $table, $itemsIndexes);
    // Возвращение рисуемых элементов для текущей страницы (данные)
    // а также информации для функции отрисовки (метаданные)
    return array("items" => $items,
        "table" => $table,
        "renderedItemsCount" => $renderedItemsCount,
        "pagesCount" => $pagesCount,
        "currentPage" => $currentPage);
}