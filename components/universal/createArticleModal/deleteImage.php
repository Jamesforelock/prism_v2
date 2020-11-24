<?php
// Удаление изображения из файловой структуры
if(isset($_POST['imagePath'])) {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/vistavca' . $_POST['imagePath']);
}