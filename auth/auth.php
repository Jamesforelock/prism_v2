<!-- Авторизационная страница  -->
<?php
$timestamp = date("YmdHis"); // Для автоматического обновления стилей

session_start();
if(isset($_SESSION['ID'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/vistavca/index.php');
    end;
}

// Возвращает true, если в строке нет некорректных символов
function isCorrectSymbols($formData) {
    $incorrectSymbols = array(">", "<", "'", "&", "#",
        "^", "`", "~", "\\", "|", "/");
    foreach ($formData as $enteredText) {
        $arrEnteredText = str_split($enteredText);
        foreach ($incorrectSymbols as $symbol) {
            if(in_array($symbol, $arrEnteredText)) {
                return false;
            }
        }
    }
    return true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" href="../styles/fontawesome/css/all.css?v=<?php echo $timestamp;?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css?v=<?php echo $timestamp;?>" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/styles.css?v=<?php echo $timestamp;?>">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <title>Vistavca | Login</title>
</head>
<body>
<?php
if(isset($_GET['section']) && $_GET['section'] === 'register') {
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/auth/register/registerForm.php';
}
else {
    require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/auth/login/loginForm.php';
}
?>
<script src="../scripts/auth.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>