<?php
// Компонент одного человека
function Human($name, $description, $picturePath, $login) {
    return '
        <div class="col human">
            <div class="human__photoContainer">
                <img src="'.$picturePath.'" alt="" class="human__photo">
            </div>
            <div class="titleBlock">
                <a href="./index.php?section=profile&user='.base64_encode($login).'" class="titleBlock__title">'.$name.'</a>
            </div>
            <p class="human__desc">'.$description.'</p>
        </div>
    ';
}