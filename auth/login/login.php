<!--Скрипт логинизации-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/errorMessage.php';

$conn = connectToDb(); // Подключение к БД

// Загружает данные о найденном в БД пользователе в сессию и создает hash для автоматической авторизации (при отмеченном RememberMe)
function setSessionDataAndHash($conn, $userId, $userType, $rememberMe) {
    session_unset(); // Удаляем все данные из сессии на случай, если они были
    session_destroy(); // Удаляем сессию
    session_start(); // Запускаем новую сессию
    $_SESSION['ID'] = $userId; // Запись в сессию id пользователя
    $_SESSION['type'] = $userType; // Запись в сессию типа пользователя (название таблицы, откуда будут браться данные)

    if($rememberMe) {
        $hash = substr(md5(time()), 0, 16); // Генерация хеша
        $addHash_query = 'INSERT INTO hu VALUES ("'.$hash.'", '.$userId.', "'.$userType.'")';
        $addHash = mysqli_query($conn, $addHash_query);
        if($addHash) {
            setcookie("hash", $hash, time()+86400, "/", "", false, true); // Установка куки на 24 часа
        }
    }
}

function isUserInTable($conn, $table, $login, $enteredPassword, &$userId, &$userType) {
    $getUser_query = "
    SELECT * FROM `$table` WHERE login = '$login'";
    $foundUser = mysqli_query($conn, $getUser_query); // Поиск пользователя по логину
    if(mysqli_num_rows($foundUser) != 0) { // Если пользователь по логину найден
        $userArr = mysqli_fetch_array($foundUser); // Представляем пользователя в виде массива
        $hashedPassword = $userArr['Password']; // Получение захешированного пароля из БД
        // Если введенный пароль не совпадает с захешированным паролем
        if(!password_verify($enteredPassword, $hashedPassword)){
            return false;
        }
        $userId = $userArr['ID']; // Получение id пользователя
        $userType = $table; // Получение типа пользователя (assistant, visitor или admin)
        return true;
    }
    return false;
}

if(isset($_POST['signIn'])) {
    if(empty($_POST['login']) || empty($_POST['password'])) {
        ErrorMessage("Please fill in all text fields");
        return;
    }
    $enteredLogin = mysqli_real_escape_string($conn, $_POST['login']); // Введённый логин
    $enteredPassword = mysqli_real_escape_string($conn, $_POST['password']); // Введённый пароль
    if(!isCorrectSymbols(array($enteredLogin, $enteredPassword))) {
        ErrorMessage("Error! The entered data may contain invalid characters.");
        return;
    }
    if(!isset($_POST['rememberMe'])) $rememberMe = false; // Если checkbox rememberMe не выбран
    else $rememberMe = true; // Если rememberMe checkbox выбран
    $userId = null; // Пользовательский id
    $userType = null; // Пользовательский тип
    $isUserInDb = isUserInTable($conn, "visitor", $enteredLogin, $enteredPassword, $userId, $userType)
        || isUserInTable($conn, "assistant", $enteredLogin, $enteredPassword, $userId, $userType)
        || isUserInTable($conn, "admin", $enteredLogin, $enteredPassword, $userId, $userType);
    if(!$isUserInDb) {
        ErrorMessage("Incorrect login or password");
        return;
    }
    setSessionDataAndHash($conn, $userId, $userType, $rememberMe);
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/vistavca/index.php'); // Переадресация
    exit;
}
?>