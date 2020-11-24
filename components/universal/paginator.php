<?php
// Функция для задания класса active номеру страницы в случае,
// если номер текущей страницы == номеру-ссылки рассматриваемой страницы
function isActive($currentPage, $linkPageNumber) {
    if ($currentPage == $linkPageNumber){
        return "active";
    }
    return "";
}

function PageLink($pageNumber, $baseAddress, $isActive) { // Рисует номер-ссылку на страницу
    echo '
    <li class="page-item ' . ($isActive ? "active" : "") . '">
        <a class="page-link" href="' . $baseAddress . '&page='.$pageNumber.'" aria-label="Previous">
            <span aria-hidden="true">'.$pageNumber.'</span>
        </a>
    </li>
    ';
}

function PageArrowLink($currentPage, $baseAddress, $type) { // Рисует стрелочную ссылку на след. (пред.) страницу
    $arrow = "";
    $pageNumber = 0;
    switch ($type) {
        case "LEFT":
            $arrow = "<<";
            $pageNumber = $currentPage - 1;
            break;
        case "RIGHT":
            $arrow = ">>";
            $pageNumber = $currentPage + 1;
            break;
    }
    echo '
    <li class="page-item">
        <a class="page-link" href="' . $baseAddress . '&page=' . $pageNumber . '" aria-label="Previous">
            <span aria-hidden="true">'.$arrow.'</span>
        </a>
    </li>
    ';
}

function Ellipsis() { // Рисует многоточие
    echo '
    <li class="page-item active">
        <a class="page-link" aria-label="Previous">
            <span aria-hidden="true">...</span>
        </a>
    </li>';
}

function Paginator($currentPage, $pagesCount, $baseAddress, $linksCount) {
    if($pagesCount > 1) {
        echo ' <nav aria-label="Page navigation example" class="paginationContainer"> <ul class="pagination">';
        if ($currentPage != 1) { // Вывод ссылки "назад", если текущая страница != номеру первой страницы
            PageArrowLink($currentPage, $baseAddress, "LEFT");
        }
        // Вывод ссылки на первую страницу
        PageLink(1, $baseAddress, isActive($currentPage, 1));
        $isEllipsisLeft = false;
        $isEllipsisRight = false;
        for ($i = 2; $i <= $pagesCount-1; $i++) { // Вывод всех номеров-ссылок страниц
            // Если рисуемый номер страницы - номер текущей страницы >= максимальному числу отображенных
            // номеров страниц
            if($i - $currentPage >= $linksCount) {
                if(!$isEllipsisRight) { // Если ещё нет многоточия справа
                    Ellipsis();
                    $isEllipsisRight = true;
                }
                continue; // Номер страницы не рисуем
            }
            // Если номер текущей страницы - рисуемый номер страницы >= максимальному числу отображенных
            // номеров страниц
            if($currentPage - $i >= $linksCount){
                if(!$isEllipsisLeft) { // Если ещё нет многоточия слева
                    Ellipsis();
                    $isEllipsisLeft = true;
                }
                continue; // Номер страницы не рисуем
            }
            PageLink($i, $baseAddress, isActive($currentPage, $i));
        }
        // Вывод ссылки на последнюю страницу
        PageLink($pagesCount, $baseAddress, isActive($currentPage, $pagesCount));
        // Вывод стрелки "вперед", если текущая страница != числу всех страниц (номеру последней страницы)
        if ($currentPage != $pagesCount) {
            PageArrowLink($currentPage, $baseAddress, "RIGHT");
        }
        echo '</ul></nav>';


    }
}