<?php
session_start();
$conn = $GLOBALS['conn'];

// Загружает данные о найденном в БД пользователе в сессию
function setSessionData ($userId, $userType) {
    $_SESSION['ID'] = $userId; // Запись в сессию ID пользователя
    $_SESSION['type'] = $userType; // Запись в сессию тип пользователя
}

if(!isset($_SESSION['ID'])) { // Если в сессии не устрановлен id (если пользователь не авторизован)
    if(isset($_COOKIE['hash'])) { // Если в куках есть hash
        $hash = mysqli_real_escape_string($conn, $_COOKIE['hash']); // Получение значения hash
        $getUser_query = 'SELECT * FROM hu WHERE hash = "'.$hash.'"';
        $user = mysqli_query($conn, $getUser_query); // Получение пользователя из таблицы hu
        if(mysqli_num_rows($user) != 0) { // Если количество найденных по хэшу строк с пользователями != 0
            while ($row = mysqli_fetch_assoc($user)) { // Представляет результат выборки в виде ассоциативного массива
                $userId = $row['user_ID']; // Пользовательский Id
                $userType = $row['userType']; // Тип пользователя
            }
            setSessionData($userId, $userType);
        }
    }
}