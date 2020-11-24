<?php
// Компонент одной статьи
function Article($id, $title, $description, $picturePath, $date) {
    $description = strTrim($description, $title); // Обрезка описания статьи
    return '
    <div class="card mb-3 article" id="'.$id.'">
        <div class="row no-gutters">
            <div class="col-md-4 article__imgContainer">
                <img src="'.$picturePath.'" class="card-img article__img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title article__title"><a href="./index.php?section=article&article='.base64_encode(openssl_encrypt($title, "AES-128-ECB", "some password")).'">'.$title.'</a></h5>
                    <hr>
                    <p class="card-text article__text">'.$description.'</p>
                    <p class="card-text article__date article__text_muted"><small class="text-muted">'.date("d.m.Y", strtotime($date)).'</small></p>
                </div>
            </div>
        </div>
    </div>
    ';
}

// Компонент одной экскурсии
function Excursion($id, $title, $description, $picturePath, $date, $isAdded) {
    $description = strTrim($description, $title); // Обрезка описания экскурсии
    if($isAdded) { // Если экскурсия у посетителя есть
        $addAndDeleteBtn = '<i class="fas fa-minus-circle article__btn article__btn_delete" onclick="removeExcursion('.$id.')"></i>';
    }
    else { // Если экскурсии у посетителя нет
        $addAndDeleteBtn = '<i class="fa fa-plus article__btn article__btn_add" onclick="addExcursion('.$id.')"></i>';
    }
    return '
    <div class="card mb-3 article '.($isAdded ? "article_added" : "").'" id="'.$id.'">
        <div class="row no-gutters">
            <div class="col-md-4 article__imgContainer">
                <img src="'.$picturePath.'" class="card-img article__img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title article__title"><a href="./index.php?section=article&article='.base64_encode(openssl_encrypt($title, "AES-128-ECB", "some password")).'">'.$title.'</a> '.$addAndDeleteBtn.'</h5>
                    <hr>
                    <p class="card-text article__text">'.$description.'</p>
                    <p class="card-text article__date article__text_muted"><small class="text-muted">'.date("d.m.Y", strtotime($date)).'</small></p>
                </div>
            </div>
        </div>
    </div>
    ';
}

function ExcursionEdit($id, $title, $description, $picturePath, $date) {
    $description = strTrim($description, $title); // Обрезка описания статьи
    return '
    <div class="card mb-3 article article_edit excursion" id="'.$id.'">
        <div class="row no-gutters">
            <div class="col-md-4 article__imgContainer">
                <img src="'.$picturePath.'" class="card-img article__img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="editPanel"> 
                    <i class="fas fa-edit editPanel__icon" onclick="editArticle('.$id.', `excursion`)"></i>
                    <i class="fas fa-trash editPanel__icon" onclick="deleteArticle('.$id.', `excursion`)"></i></div>
                    <h5 class="card-title article__title"><a href="./index.php?section=article&article='.base64_encode(openssl_encrypt($title, "AES-128-ECB", "some password")).'">'.$title.'</a></h5>
                    <span class="text-muted article__type">excursion</span>
                    <hr>
                    <p class="card-text article__text">'.$description.'</p>
                    <p class="card-text article__date article__text_muted"><small class="text-muted">'.date("d.m.Y", strtotime($date)).'</small></p>
                </div>
            </div>
        </div>
    </div>
    ';
}

function StandEdit($id, $title, $description, $picturePath, $date) {
    $description = strTrim($description, $title); // Обрезка описания статьи
    return '
    <div class="card mb-3 article article_edit stand" id="'.$id.'">
        <div class="row no-gutters">
            <div class="col-md-4 article__imgContainer">
                <img src="'.$picturePath.'" class="card-img article__img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="editPanel">
                    <i class="fas fa-edit editPanel__icon" onclick="editArticle('.$id.', `stand`)"></i>
                    <i class="fas fa-user-edit editPanel__icon" onclick="setAssistants('.$id.')"></i>
                    <i class="fas fa-trash editPanel__icon" onclick="deleteArticle('.$id.', `stand`)"></i>
                    </div>
                    <h5 class="card-title article__title"><a href="./index.php?section=article&article='.base64_encode(openssl_encrypt($title, "AES-128-ECB", "some password")).'">'.$title.'</a></h5>
                    <span class="text-muted article__type">stand</span>
                    <hr>
                    <p class="card-text article__text">'.$description.'</p>
                    <p class="card-text article__date article__text_muted"><small class="text-muted">'.date("d.m.Y", strtotime($date)).'</small></p>
                </div>
            </div>
        </div>
    </div>
    ';
}

// Обрезает текст статьи до 350 первых символов, если его длина больше 350 символов и добавляет ссылку Read more
function strTrim($str, $title) {
    if(strlen($str) > 350) {
        $substr = mb_substr($str, 0, 350, "UTF-8");
        $str = $substr.'...<br><a href="./index.php?section=article&article='.base64_encode(openssl_encrypt($title, "AES-128-ECB", "some password")).'" class="article__readMore" href="#">Read more</a>';
    }
    return $str;
}