<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <title>Hell session | <?= htmlspecialchars($Title ?? 'Default Title') ?></title>

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
                    <a href="/?route=site/products" class="nav-a m-3">shop</a>
                </li>
            </ul>
        </navbar>
        <div class="header-logo">
            <a href="/"><img src="/static/img/qwewwq.png" alt="logo" class="heavy-logo"></a>
        </div>
        <navbar class="header-nav pt-4">

            <?php if(!\models\User::isLoggedIn()) :?>
                <ul class="header-list d-flex">
                    <li>
                        <a href="/?route=cart/show"><img src="/static/img/grob.png" class="grob" alt="cart"></a>
                        <p class="cart-quantity" id="cart-count">
                            <?php
                            $cart = new \models\Cart();
                            $quantity = $cart->getTotalQuantity();
                            echo $quantity;
                            ?>
                        </p>
                    </li>
                    <li>
                        <a href="/?route=users/login" class="header-list m-3">login</a>
                    </li>
                </ul>
            <?php endif;?>

            <?php if(\models\User::isLoggedIn()) :?>
                <ul class="header-list d-flex">
                    <?php
                    $currentUser = \models\User::getCurrentUser();
                    if ($currentUser && $currentUser->is_superuser):
                    ?>
                        <li>
                            <a href="/?route=admin/index" class="nav-a m-3">admin</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="/?route=cart/show"><img src="/static/img/grob.png" class="grob" alt="cart"></a>
                            <p class="cart-quantity" id="cart-count">
                                <?php
                                $cart = new \models\Cart();
                                $quantity = $cart->getTotalQuantity();
                                echo $quantity;
                                ?>
                            </p>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="/?route=users/profile" class="header-list m-3">profile</a>
                    </li>
                </ul>
            <?php endif;?>

        </navbar>
    </div>
</header>

<div class="container">
    <?=$Content ?>
</div>

<?php
$currentModule = \classes\Core::getInstance()->module;
$currentAction = \classes\Core::getInstance()->action;
$isAdminOrderPage = $currentModule === 'order' && in_array($currentAction, ['index', 'view', 'edit']);
if (($currentModule !== 'product' && $currentModule !== 'category' && !$isAdminOrderPage) || ($isErrorPage ?? false)):
    ?>
    <img src="/static/img/frame1.png" class="frame1" alt="">
    <img src="/static/img/frame2.png" class="frame2" alt="">
    <img src="/static/img/frame3.png" class="frame3" alt="">
    <img src="/static/img/frame4.png" class="frame4" alt="">
<?php endif; ?>

<script src="/static/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/static/js/cart.js"></script>
</body>
</html>