<header class="header">
    <div class="container">
    <div class="row justify-content-between align-items-center">
        <div class="logo">
            <span class="logo__name">PRISM</span>
            <span class="logo__subtitle">master of your eyes</span>
        </div>
        <nav class="nav">
            <a href="./index.php?section=articles&type=stand" class="nav__link">Stands</a>
            <a href="./index.php?section=people&type=assistant" class="nav__link">Stand assistants</a>
            <a href="./index.php?section=articles&type=excursion" class="nav__link">Excursions</a>
            <a href="./index.php?section=people&type=visitor" class="nav__link">Our visitors</a>
            <div class="nav-item dropdown">
                <?php
                if(isset($GLOBALS['user'])) { // Если есть пользовательские данные
                    $user = $GLOBALS['user']; // Получаем пользовательские данные и выводим в шапке
                    echo '
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$user['name'].' ('.$user['type'].')
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="./index.php?section=profile">My Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./auth/login/logout.php">Log out</a>
                </div>
                    ';
                }
                else {
                    echo '
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profile
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="./auth/auth.php">Login</a>
                    <!-- divider - разделитель, на случай дополнительных опций -->
                    <!-- <div class="dropdown-divider"></div> -->
                </div>
                    ';
                }
                ?>

            </div>
        </nav>
    </div>
    </div>
</header>