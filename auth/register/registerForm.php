<!--Форма регистрации-->
<div class="formWrapper">
    <div class="container formContainer">
        <div class="row align-items-center formRow">
            <div class="col">
                <a href="../index.php" class="backLink">Back</a>
                <h1>Registration</h1>
                <form enctype="multipart/form-data" method="POST">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/auth/register/register.php' ?>
                    <div class="form-group">
                        <input name="login_reg" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your login" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_reg" class="form-control" id="exampleInputPassword1" placeholder="Your password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input name="name_reg" class="form-control" placeholder="Your name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input name="description_reg" class="form-control" placeholder="Briefly about you" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">Your avatar: </label>
                        <input name="picture" type="file" />
                    </div>
                    <div class="form-group form-check">
                        <input onchange="toggleSecretCodeInput()" type="checkbox" class="form-check-input" id="employeeCheckBox" name="isEmployee">
                        <label class="form-check-label" for="employeeCheckBox">Wanna become your employee</label>
                    </div>
                    <div class="form-group" id="secretCodeInput">
                        <label for="exampleInputEmail1">Please, enter the secret code to become our employee</label>
                        <input name="secretCode_reg" class="form-control" placeholder="SECRET CODE" autocomplete="off">
                    </div>
                    <button type="submit" name="signUp" class="btn btn-primary mainBtn">Sign Up</button>
                </form>
                <hr>
                <p>Already have an account?</p>
                <a href="../auth.php" class="btn btn-success secondaryBtn">Login</a>
            </div>
        </div>
    </div>
</div>
<script src="../scripts/registerForm.js"></script>