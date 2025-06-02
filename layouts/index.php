<?php
/** @var string $Title */
/** @var string $Content */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($Title ?? 'Default Title') ?></title>

    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/base.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="header sticky-top flex-shrink-0">
        <div class="header-container d-flex">
            <navbar class="header-nav pt-4">
                <ul class="header-list d-flex">
                    <li>
                        <a href="/" class="nav-a m-3">home</a>
                    </li>
                    <li>
                        <a href="#" class="nav-a m-3">shop</a>
                    </li>
                </ul>
            </navbar>
            <div class="header-logo">
                <a href="/"><img src="/static/img/qwewwq.png" alt="" class="heavy-logo"></a>
            </div>
            <navbar class="header-nav pt-4">

                <?php if(!\models\User::isLoggedIn()) :?>
                <ul class="header-list d-flex">
                    <li>
                        <a href="/?route=users/login" class="header-list m-3">login</a>
                    </li>
                    <li>
                        <a href="/?route=users/register" class="header-list m-3">register</a>
                    </li>
                </ul>
                <?php endif;?>

                <?php if(\models\User::isLoggedIn()) :?>
                <ul class="header-list d-flex">
                    <li>
                        <a href="/users/logout" class="header-list m-3">logout</a>
                    </li>
                    <li>
                        <a href="/users/profile" class="header-list m-3">profile</a>
                    </li>
                </ul>
                <?php endif;?>
            </navbar>
        </div>
    </header>

<!--    <main class="flex-grow-1 d-flex align-items-center justify-content-center">-->
<!--        <div class="container">-->
<!--            --><?php //=$Content ?>
<!--        </div>-->
<!--    </main>-->
    <div class="container">
        <?=$Content ?>
    </div>

    <img src="/static/img/frame1.png" class="frame1" alt="">
    <img src="/static/img/frame2.png" class="frame2" alt="">
    <img src="/static/img/frame3.png" class="frame3" alt="">
    <img src="/static/img/frame4.png" class="frame4" alt="">

<!--    <footer class="mt-auto flex-shrink-0">-->
<!--        <div class="container nav justify-content-center border-top pb-3 mb-3">-->
<!--            2025 Hell Session Store-->
<!--        </div>-->
<!--    </footer>-->

    <script src="/static/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
