<?php

function MainInfo ($login = null, $name, $userType, $description, $pictureName) {
    echo '
    <div class="mainInfo">
        <img src="./assets/i/'.$userType.'/'.$pictureName.'" alt="" class="mainInfo__avatar">
        <div class="mainInfo__textSide">
            <span class="mainInfo__name">'.$name.'</span>
            <span>'.($login ? "login: $login" : "").'</span>
            <span class="mainInfo__type">'.$userType.'</span>
            <p class="mainInfo__description">'.$description.'</p>
        </div>
    </div>
    ';
}