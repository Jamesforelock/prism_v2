<?php

// Генерирует название изображения
// preg_replace используется для устранения в имени картинки символов,
// которые могут повлиять на путь назначения файла
function getPictureName($picture) {
    $pictureName = $picture['name'];
    if(strlen($pictureName) > 10)
        $pictureName = substr($pictureName, strlen($pictureName) - 10);
    return preg_replace("/[^A-Z0-9._-]/i", "_",
        substr(md5(time()), 0, 25).'_'.$pictureName);
}

// Проверяет изображение на валидность
function isPictureValid($picture, &$error) {
    $types = array('image/gif', 'image/png', 'image/jpeg'); // Типы допустимых файлов для загрузки
    if(!in_array($picture['type'], $types)) { // Если файл не является картинкой
        $error = "Error! You can only upload images with the extensions png, jpg and gif.";
        return false;
    }
    if($picture['size'] > 1000000) { // Если файл весит больше 1000000 байт (1 МБ)
        $error = "Error! The uploaded image should not weigh more than 1 mb.";
        return false;
    }
    return true;
}

// Загрузка картинки в файловую структуру
// В случае успеха возвращает true
function uploadPicture($picture, $folderName) {
    $path = $_SERVER['DOCUMENT_ROOT'].'/vistavca/assets/i/'.$folderName.'/' . getPictureName($picture);
    return move_uploaded_file ($picture['tmp_name'], $path);;
}