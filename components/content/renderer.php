<?php

// Абстрактный класс рисовальщика данных на текущей странице
abstract class Renderer {
    public abstract function render ($items, $table);
    public abstract function getTableType();
    // Переворачивает результат Mysql-выборки и возвращает его в виде массива
    protected function reverseMySqlRes ($items) {
        $itemsArray = array();
        if(!$items) { // Если результат запроса вернул false, возвращаем пустой массив
            return array();
        }
        while ($item = mysqli_fetch_array($items)) {
            $itemsArray[] = $item;
        }
        return array_reverse($itemsArray);
    }
}