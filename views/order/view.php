<?php
/**
 * @var \models\Order $order
 * @var \models\OrderItem[] $orderItems
 * @var \models\Product[] $products
 * @var bool $isAdmin
 */

$totalItems = 0;
foreach ($orderItems as $item) {
    $totalItems += $item->quantity;
}

?>

<section class="order-view">
    <div class="order-title">
        <h2>Замовлення #<?= $order->id ?></h2>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="/?route=order/index" class="nav-a">← Назад до списку</a>
        </div>
        <div>
            <a href="/?route=order/edit/<?= $order->id ?>" class="nav-a">Редагувати</a>
            | <a href="/?route=order/delete/<?= $order->id ?>" class="nav-a" onclick="return confirm('Видалити замовлення?')">Видалити</a>
        </div>
    </div>

    <p class="mb-1">
        <?php if ($order->paid): ?>
            Paid
        <?php else: ?>
            Pending Payment
        <?php endif; ?>
    </p>
    <p class="mb-4">Дата створення: <?= date('F d, Y \a\t H:i', strtotime($order->created_at)) ?> | <?= $totalItems ?> item<?= ($totalItems > 1) ? 's' : '' ?></p>

    <div class="row mb-4">
        <div class="col-md-7">
            <div class="h-100 p-4" style="background-color: #fff; border: 1px solid #e0e0e0; border-radius: 5px;">
                <h3>Підсумок замовлення</h3>

                <div class="mt-3">
                    <?php foreach ($orderItems as $item): ?>
                        <?php $product = $products[$item->product_id] ?? null; ?>
                        <div class="d-flex align-items-center mb-3">
                            <div style="background-color: #f8f9fa; padding: 10px; margin-right: 15px;">
                                <?php if ($product): ?>
                                    <img src="<?= htmlspecialchars($product->main_image ?: '/static/img/noimage.jpg') ?>" alt="<?= htmlspecialchars($product->name) ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="/static/img/noimage.jpg" alt="Товар видалено" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <?php if ($product): ?>
                                    <p class="mb-0"><?= htmlspecialchars($product->name) ?></p>
                                    <p class="text-muted mb-0"><?= $item->quantity ?></p>
                                <?php else: ?>
                                    <p class="text-muted mb-0">Товар видалено</p>
                                <?php endif; ?>
                            </div>
                            <p class="mb-0">$<?= number_format($item->getCost(), 2) ?></p>
                        </div>
                    <?php endforeach; ?>

                    <hr class="my-3" style="border-top: 1px solid #ddd;">


                    <div class="d-flex justify-content-between mb-2">
                        <h3>Total:</h3>
                        <h3><strong>$<?= number_format($order->getTotalCost(), 2) ?></strong></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="h-100 p-4" style="background-color: #fff; border: 1px solid #e0e0e0; border-radius: 5px;">
                <h3>Контактна інформація</h3>
                <p class="mb-2">Ім'я: <?= htmlspecialchars($order->first_name) ?></p>
                <p class="mb-2">Прізвище: <?= htmlspecialchars($order->last_name) ?></p>
                <p class="mb-2">Email: <?= htmlspecialchars($order->email) ?></p>
                <h4 class="mt-4">Адреса доставки</h4>
                <p class="mb-2">Місто: <?= htmlspecialchars($order->city) ?></p>
                <p class="mb-2">Адреса: <?= htmlspecialchars($order->address) ?></p>
                <p class="mb-2">Поштовий індекс: <?= htmlspecialchars($order->postal_code) ?></p>
            </div>
        </div>
    </div>
</section> 