<!--Форма логинизации -->
<div class="formWrapper">
    <div class="container formContainer">
        <div class="row align-items-center formRow">
            <div class="col">
                <a href="../index.php" class="backLink">Back</a>
                <h1>Login</h1>
                <form method="POST">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/auth/login/login.php' ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Your login</label>
                        <input name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Your password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" autocomplete="off">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="rememberMe">
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    </div>
                    <button type="submit" name="signIn" class="btn btn-success mainBtn">Login</button>
                </form>
                <hr>
                <p>Is this your first time with us?</p>
                <a href="./auth.php?section=register" class="btn btn-primary secondaryBtn">Sign Up</a>
            </div>
        </div>
    </div>
</div>