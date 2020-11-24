<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vistavca/components/universal/pictureHandler.php';

class VisitorAdder {
    public $error;
    protected $db;
    protected $userData;
    protected $table;

    public function __construct($db, $userData) {
        $this->db = $db;
        $this->table = 'visitor';
        $this->userData = $userData;
    }

    public function addUser() {
        // Распаковка значений пользователя
        $login = $this->userData['login'];
        $password = $this->userData['password'];
        $name = $this->userData['name'];
        $description = $this->userData['description'];
        $picture = $this->userData['picture'];

        if($picture) {
            if (!isPictureValid($picture, $this->error)) {
                return false;
            }
            $pictureName = '"'.getPictureName($picture).'"';
        }
        else {
            $pictureName = "NULL";
        }

        $table = $this->table;

        // Добавление пользователя в БД
        $addUser_query = "INSERT INTO `$table` (`Login`, `Password`, `Name`, `Description`, `Picture`) 
                VALUES ('$login', '$password', '$name', '$description', $pictureName)";
        if(!mysqli_query($this->db, $addUser_query)) { // Попытка добавить посетителя в БД
            $this->error = "Error! You have not been registered.";
            return false;
        }
        // Добавление картинки
        uploadPicture($picture, $table);
        return true;
    }
}