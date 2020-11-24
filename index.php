<?php
$timestamp = date("YmdHis"); // Для автоматического обновления стилей
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="./styles/fontawesome/css/all.css?v=<?php echo $timestamp;?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css?v=<?php echo $timestamp;?>" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css?v=<?php echo $timestamp;?>">
    <title>PRISM</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="./scripts/smoothAppear.js"></script>
    <script src="./scripts/excursionSignUpper.js"></script>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/dbConnector.php';
        $conn = connectToDb(); // Подключение к БД
        $GLOBALS['conn'] = $conn;
        require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/auth/login/autologin.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/userDataConnector.php';
        getUserData(); // Загрузка данных пользователя в $GLOBALS
    ?>
    <div class="wrapper">
        <div class="container-fluid">
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/header.php'
            ?>
        </div>
        <div class="imageRow"></div>
        <div class="container-fluid">
            <main class="content">
                <?php
                    include_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/content.php'
                ?>
            </main>
        </div>
    </div>
    <?php
        include_once $_SERVER['DOCUMENT_ROOT']."/vistavca/components/universal/footer.php";
    ?>
    <?php include "./components/universal/multiButtonConnector.php" ?>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>