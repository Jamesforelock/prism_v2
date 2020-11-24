<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;
if($user['type'] === 'admin'){
    if(isset($_POST['articleType']) && isset($_POST['title']) && isset($_POST['text'])) {
        // Распаковка данных и экранирование mysql и html
        $articleType = mysqli_real_escape_string($conn, htmlspecialchars($_POST['articleType']));
        $title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['title']));
        $description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['text']));
        $imageName = null; // Имя файла изображения
        if(isset($_POST['imagePath'])) { // Если был также загружен путь к изображению
            // Текущий путь загруженного изображения
            $uploadedImagePath = $_SERVER['DOCUMENT_ROOT'] . '/vistavca' . $_POST['imagePath'];
            $imageName = basename($uploadedImagePath); // Получение имени файла изображения
            // Окончательный путь загруженного изображения
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/vistavca/assets/i/'.$articleType.'/'.$imageName;
            // Перемещение картинки
            rename($uploadedImagePath, $imagePath);
        }
        // Осуществляем запрос на добавление статьи
        $createArticle_query = "INSERT INTO `$articleType` (Name, Description, Picture) 
        VALUES ('$title', '$description', '$imageName')";
        if(mysqli_query($conn, $createArticle_query)) {
            echo 1;
        }
        else {
            echo 0;
        }
    }
}
