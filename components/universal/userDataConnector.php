<?php
// При состоянии авторизованности загружает пользовательские данные в $GLOBALS
function getUserData() {
    $conn = $GLOBALS['conn'];
    if(isset($_SESSION['ID']) && isset($_SESSION['type'])) {
        $id = $_SESSION['ID'];
        $type = $_SESSION['type'];
        $getUserData_query = "SELECT * FROM `$type` WHERE ID = '$id'";
        $userData = mysqli_query($conn, $getUserData_query);
        if(mysqli_num_rows($userData) != 0) {
            $user = array();
            $user['ID'] = $id;
            $user['type'] = $type;
            while ($row = mysqli_fetch_array($userData)) {
                $user['login'] = $row['Login'];
                $user['name'] = $row['Name'];
                $user['description'] = $row['Description'];
                $user['picture'] = $row['Picture'];
            }
            $GLOBALS['user'] = $user;
        }
    }
}
