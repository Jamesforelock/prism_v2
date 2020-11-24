<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vistavca/components/universal/pictureHandler.php';

if(isset($_POST['image_uploaded'])) { // Если есть идентификатор факта загрузки картинки
    $image = $_FILES['image']; // Получение картинки из $_FILES
    $folderName = "uploads"; // Название папки для загрузки в неё изображения
    $error = null;
    if(!isPictureValid($image, $error)) { // Если картинка не является валидной
        $data = array("error" => $error);
    }
    else { // Если картинка валидна
        if(uploadPicture($image, $folderName)) { // Загрузка картинки
            $imageName = getPictureName($image); // Имя файла с картинкой
            $imagePath = '/assets/i/'.$folderName.'/'.$imageName; // Путь для тега img
            $data = array("imagePath" => $imagePath);
        }
        else {
            $data = array("error" => "Error: the picture hasn't been added");
        }
    }
    echo json_encode($data); // Вывод ответа в виде пути к картинке, либо в виде ошибки
}