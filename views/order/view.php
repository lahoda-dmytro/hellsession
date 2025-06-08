<?php
/**
 * @var \models\Order $order
 * @var \models\OrderItem[] $orderItems
 * @var \models\Product[] $products
 * @var bool $isAdmin
 */
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= htmlspecialchars($Title ?? 'Перегляд замовлення') ?></h1>
        <div>
            <a href="/?route=order/edit/<?= $order->id ?>" class="btn btn-secondary">Редагувати</a>
            <a href="/?route=order/index" class="btn btn-primary">Назад до списку</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Інформація про замовлення</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID замовлення:</strong> <?= $order->id ?></p>
                    <p><strong>Дата створення:</strong> <?= $order->created_at ?></p>
                    <p><strong>Статус оплати:</strong>
                        <?php if ($order->paid): ?>
                            <span class="badge bg-success">Оплачено</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Очікує оплати</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($order->stripe_id): ?>
                        <p><strong>Stripe ID:</strong> <?= htmlspecialchars($order->stripe_id) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Інформація про клієнта</h5>
                </div>
                <div class="card-body">
                    <p><strong>Ім'я:</strong> <?= htmlspecialchars($order->first_name) ?></p>
                    <p><strong>Прізвище:</strong> <?= htmlspecialchars($order->last_name) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order->email) ?></p>
                    <p><strong>Місто:</strong> <?= htmlspecialchars($order->city) ?></p>
                    <p><strong>Адреса:</strong> <?= htmlspecialchars($order->address) ?></p>
                    <p><strong>Поштовий індекс:</strong> <?= htmlspecialchars($order->postal_code) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Товари в замовленні</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Кількість</th>
                            <th>Ціна</th>
                            <th>Сума</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <?php $product = $products[$item->product_id] ?? null; ?>
                            <tr>
                                <td>
                                    <?php if ($product): ?>
                                        <a href="/?route=product/view/<?= $product->slug ?>">
                                            <?= htmlspecialchars($product->name) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Товар видалено</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $item->quantity ?></td>
                                <td>$<?= number_format($item->price, 2) ?></td>
                                <td>$<?= number_format($item->getCost(), 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Загальна сума:</th>
                            <th>$<?= number_format($order->getTotalCost(), 2) ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 