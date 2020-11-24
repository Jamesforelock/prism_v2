<?php
function connectToDb() {
    $servername = "localhost";
    $database = "vistavca";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, $database);
    if(!$conn) {
        return die("Connection failed: ".mysqli_connect_error());
    }
    return $conn;
}