<?php
/**
 * @var string $Title
 * @var bool $isAdmin
 */
?>

<div class="forcreate py-5">
    <h1 class="text-center mb-5 "><?= htmlspecialchars($Title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="list-group">
                <a href="/?route=product/index" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Управління товарами
                    <span class="btn">Редагувати, додавати, видаляти</span>
                </a>
                <a href="/?route=category/index" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Управління категоріями
                    <span class="btn">Редагувати, додавати, видаляти</span>
                </a>
                <a href="/?route=order/index" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Управління замовленнями
                    <span class="btn">Переглядати, редагувати</span>
                </a>
            </div>
        </div>
    </div>
</div>
