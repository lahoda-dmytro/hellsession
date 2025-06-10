<?php
/**
 * @var \models\Order $order
 * @var array $errors
 * @var array $old
 * @var bool $isAdmin
 */

$orderItems = $order->getOrderItems();
$totalItems = 0;
foreach ($orderItems as $item) {
    $totalItems += $item->quantity;
}

?>

<div class="container mt-4">
    <h1>Редагувати замовлення</h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="/?route=order/index" class="nav-a">← Назад до списку</a>
        </div>
        <div>
            <a href="/?route=order/view/<?= $order->id ?>" class="nav-a">Переглянути замовлення</a>
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

    <?php if (!empty($errors)): ?>
        <div class="alert ">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3">Інформація про клієнта</h3>
                <div class="mb-3">
                    <label for="first_name" class="form-label">Ім'я *</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" 
                           value="<?= htmlspecialchars($old['first_name'] ?? $order->first_name) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Прізвище *</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" 
                           value="<?= htmlspecialchars($old['last_name'] ?? $order->last_name) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($old['email'] ?? $order->email) ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-3">Адреса доставки</h3>
                <div class="mb-3">
                    <label for="city" class="form-label">Місто *</label>
                    <input type="text" class="form-control" id="city" name="city" 
                           value="<?= htmlspecialchars($old['city'] ?? $order->city) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="postal_code" class="form-label">Поштовий індекс *</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" 
                           value="<?= htmlspecialchars($old['postal_code'] ?? $order->postal_code) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Адреса *</label>
                    <input type="text" class="form-control" id="address" name="address" 
                           value="<?= htmlspecialchars($old['address'] ?? $order->address) ?>" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Товари в замовленні</label>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Кількість</th>
                            <th>Ціна</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <?php $product = $products[$item->product_id] ?? null; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 50px; height: 50px; margin-right: 10px;">
                                            <?php if ($product): ?>
                                                <img src="<?= htmlspecialchars($product->main_image ?: '/static/img/noimage.jpg') ?>" 
                                                     alt="<?= htmlspecialchars($product->name) ?>" 
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <img src="/static/img/noimage.jpg" alt="Товар видалено" 
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if ($product): ?>
                                                <?= htmlspecialchars($product->name) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Товар видалено</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?= $item->quantity ?></td>
                                <td>$<?= number_format($item->getCost(), 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Загальна сума:</strong></td>
                            <td><strong>$<?= number_format($order->getTotalCost(), 2) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="paid" name="paid" value="1" 
                   <?= ($old['paid'] ?? $order->paid) ? 'checked' : '' ?>>
            <label class="form-check-label" for="paid">Paid</label>
        </div>

        <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Зберегти зміни</button>
        <br>
    </form>
</div>
