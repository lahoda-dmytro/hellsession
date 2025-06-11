<?php
/**
 * @var string $Title
 * @var bool $isAdmin
 */
?>

<div class="forcreate py-5">
    <h1 class=" mb-2 "><?= htmlspecialchars($Title) ?></h1>

    <div class="row justify-content-center">
        <div class="">
            <div class="list-group">
                <a href="/?route=product/index" class="login-btn  d-flex d-block form-control form-styleprofile">
                    products
                </a>
                <a href="/?route=category/index" class="login-btn  d-flex d-block form-control form-styleprofile">
                    categories
                </a>
                <a href="/?route=order/index" class="login-btn  d-flex d-block form-control form-styleprofile">
                    orders
                </a>
                <a href="/" class="btn justify-content-center d-flex d-block form-control form-styleprofile py-3">
                    Go to Homepage
                </a>
            </div>
        </div>
    </div>
</div>
