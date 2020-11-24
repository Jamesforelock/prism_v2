<?php
if(!isset($GLOBALS['user'])) { // Если данные пользователя не установлены
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/vistavca/auth/auth.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/profile/mainInfo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/profile/secInfo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';

$conn = $GLOBALS['conn'];

function getUserFromDB($conn, $table, $login) {
    $getUser_query = "
    SELECT * FROM `$table` WHERE login = '$login'";
    $foundUser = mysqli_query($conn, $getUser_query); // Поиск пользователя по логину
    if(!$foundUser) return false;
    $user = array();
    while($row = mysqli_fetch_array($foundUser)) {
        $user['ID'] = $row['ID'];
        $user['name'] = $row['Name'];
        $user['type'] = $table;
        $user['description'] = $row['Description'];
        $user['picture'] = $row['Picture'];
        // Если у пользователя нет фото
        $user['login'] = null;
    }

    return $user;
}

if(isset($_GET['user'])) {
    $userLogin = base64_decode($_GET['user']);
    $userFromDb = getUserFromDB($conn, 'visitor', $userLogin);
    $userFromDb = $userFromDb ? $userFromDb : getUserFromDB($conn, 'assistant', $userLogin);
    if(!$userFromDb) die("Sorry, but the user doesn't exist");
    if(isset($GLOBALS['user']) && $GLOBALS['user']['ID'] === $userFromDb['ID'] && $GLOBALS['user']['type'] === $userFromDb['type'])
        $user = $GLOBALS['user'];
    else
        $user = $userFromDb;
}
else {
    $user = $GLOBALS['user'];
}

$login = $user['login'];
$name = $user['name'];
$userType = $user['type'];
$description = $user['description'];
$pictureName = $user['picture'] ? $user['picture'] : 'noPhoto_u.jpg';


?>

<div class="profile container">
    <h1 class="profile__title">Profile</h1>
    <hr>
    <div class="profileInfo">
        <?php MainInfo($login, $name, $userType, $description, $pictureName);?>
        <hr class="profileInfo__divider">
        <div class="secInfo">
            <?php
            if(isset($GLOBALS['user']) && $GLOBALS['user']['ID'] === $user['ID'] && $GLOBALS['user']['type'] === $user['type']) {
                switch ($userType) {
                    case "visitor": // Если пользовательский тип = посетитель
                        SecVisitorInfo($conn, $login);
                        break;
                    case "assistant": // Если пользовательский тип = стендист
                        SecAssistantInfo($conn, $login);
                }
            }
            ?>
        </div>
    </div>
</div>
