<?php
// Компонент одного ассистена для модального окна
function AssistantModal($id, $name, $description, $picturePath, $isChecked, $login) {
    return '
    <div class="card mb-3 article article_mini" id="'.$id.'">
        <div class="row no-gutters">
            <div class="col-md-4 article__imgContainer">
                <img src="'.$picturePath.'" class="card-img article__img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title article__title"><a href="./index.php?section=profile&user='.base64_encode($login).'" class="titleBlock__title">'.$name.'</a> <input onchange="toggleAssistant(this, '.$id.')" type="checkbox" '.($isChecked ? 'checked': '').'></h5>
                    <hr>
                    <p class="card-text article__text">'.$description.'</p>
                </div>
            </div>
        </div>
    </div>
    ';
}