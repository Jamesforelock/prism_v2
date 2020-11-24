<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/imagePathGetter.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/articleGetter.php';
$conn = connectToDb(); // Подключение к БД
session_start(); // Запуск сессии
getUserData(); // Загрузка данных пользователя в $GLOBALS
$user = isset($GLOBALS['user']) ? $GLOBALS['user'] : null;
if($user['type'] === 'admin'){
    if(isset($_POST['id'], $_POST['type'], $_POST['title'], $_POST['text'])) {
        // Распаковка данных и экранирование mysql и html
        $id = intval($_POST['id']);
        $type = mysqli_real_escape_string($conn, htmlspecialchars($_POST['type']));
        $title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['title']));
        $description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['text']));
        if(isset($_POST['imagePath'])) { // Если был также загружен путь к изображению
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/vistavca/'.getImagePath($conn, $id, $type);
            if($_POST['imagePath'] == "cleared") { // Если путь картинку следует удалить
                unlink($imagePath); // Удаляем картинку
                $imageName = ""; // Присваиваем названию картинки пустую строку и загружаем в БД
                // Осуществляем запрос на изменение статьи
                $editArticle_query = "UPDATE `$type` SET `Name` = '$title', `Description` = '$description', 
        `Picture` = '$imageName' WHERE `ID` = $id";
            }
            else { // Если картинку следует загрузить
                // Текущий путь загруженного изображения
                $uploadedImagePath = $_SERVER['DOCUMENT_ROOT'] . '/vistavca' . $_POST['imagePath'];
                if(!isset(pathinfo($imagePath)['extension'])) { // Если картинки изначально нет
                    $imageName = basename($uploadedImagePath); // Получение имени файла изображения
                    // Окончательный путь загруженного изображения
                    $imagePath .= $imageName; // К пути к папке с изображениями добавляем название новой картинки
                    // Перемещение картинки
                    rename($uploadedImagePath, $imagePath);
                    // Осуществляем запрос на изменение статьи
                    $editArticle_query = "UPDATE `$type` SET `Name` = '$title', `Description` = '$description', 
        `Picture` = '$imageName' WHERE `ID` = $id";
                }
                else {
                    // Перемещение картинки
                    rename($uploadedImagePath, $imagePath);
                    // Осуществляем запрос на изменение статьи
                    $editArticle_query = "UPDATE `$type` SET `Name` = '$title', `Description` = '$description'
            WHERE `ID` = $id";
                }
            }
        }
        else {
            // Осуществляем запрос на изменение статьи
            $editArticle_query = "UPDATE `$type` SET `Name` = '$title', `Description` = '$description'
            WHERE `ID` = $id";
        }
        if(mysqli_query($conn, $editArticle_query)) {
            $article = getArticle($conn, $id, $type);
            if($article['Picture'] === "") $articlePicture = 'noPhoto_a.png';
            else $articlePicture = $article['Picture'];
            switch ($type) {
                case "excursion":
                    $renderedArticle = ExcursionEdit($article['ID'], $article['Name'],
                        $article['Description'], 'assets/i/excursion/'.$articlePicture, $article['Date']);
                    break;
                case "stand":
                    $renderedArticle = StandEdit($article['ID'], $article['Name'],
                        $article['Description'], 'assets/i/stand/'.$articlePicture, $article['Date']);
                    break;
            }
            echo json_encode(array(
                "code" => 1,
                "renderedArticle" => $renderedArticle,
            ));
        }
        else {
            echo json_encode(array(
                "code" => 0
            ));
        }
    }
}