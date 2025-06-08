<?php
/**
 * @var \models\Order $order
 * @var array $errors
 * @var array $old
 * @var bool $isAdmin
 */

$orderItems = $order->getOrderItems(); // Отримуємо елементи замовлення для розрахунку totalItems
$totalItems = 0;
foreach ($orderItems as $item) {
    $totalItems += $item->quantity;
}

?>

<section class="order-edit">
    <div class="order-title">
        <h2><?= htmlspecialchars($Title ?? 'Редагування замовлення') ?></h2>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="/?route=order/index" class="nav-a">← Назад до списку</a>
        </div>
        <div>
            <a href="/?route=order/view/<?= $order->id ?>" class="nav-a">Переглянути ордер</a>
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
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/?route=order/edit/<?= $order->id ?>" method="post">
        <div class="row mb-4">
            <div class="col-md-7">
                <div class="login-title form-stylereg p-4 mb-4" style="background-color: #fff; border: 1px solid #e0e0e0; border-radius: 5px;">
                    <h3>Інформація про клієнта</h3>
                    <div class="mb-3">
                        <label for="first_name" class="form-label form-stylereg">Ім'я *</label>
                        <input type="text" class="form-control form-styleprofile" id="first_name" name="first_name" 
                               value="<?= htmlspecialchars($old['first_name'] ?? $order->first_name) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label form-stylereg">Прізвище *</label>
                        <input type="text" class="form-control form-styleprofile" id="last_name" name="last_name" 
                               value="<?= htmlspecialchars($old['last_name'] ?? $order->last_name) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label form-stylereg">Email *</label>
                        <input type="email" class="form-control form-styleprofile" id="email" name="email" 
                               value="<?= htmlspecialchars($old['email'] ?? $order->email) ?>" required>
                    </div>
                </div>
                <div class="login-title form-stylereg p-4 mb-4" style="background-color: #fff; border: 1px solid #e0e0e0; border-radius: 5px;">
                    <h3>Адреса доставки</h3>
                    <div class="mb-3">
                        <label for="city" class="form-label form-stylereg">Місто *</label>
                        <input type="text" class="form-control form-styleprofile" id="city" name="city" 
                               value="<?= htmlspecialchars($old['city'] ?? $order->city) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label form-stylereg">Поштовий індекс *</label>
                        <input type="text" class="form-control form-styleprofile" id="postal_code" name="postal_code" 
                               value="<?= htmlspecialchars($old['postal_code'] ?? $order->postal_code) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label form-stylereg">Адреса *</label>
                        <input type="text" class="form-control form-styleprofile" id="address" name="address" 
                               value="<?= htmlspecialchars($old['address'] ?? $order->address) ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-4 mb-4" style="background-color: #fff; border: 1px solid #e0e0e0; border-radius: 5px;">
                    <h3>Підсумок замовлення</h3>

                    <div class="mt-3" style="max-height: 150px; overflow-y: auto;">
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
                <div class="p-4 mb-4 mt-4" style="background-color: #fff; border: 1px solid #e0e0e0; border-radius: 5px;">
                    <h3>Статус замовлення</h3>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="paid" name="paid" value="1" 
                               <?= ($old['paid'] ?? $order->paid) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="paid">Paid</label>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="login-btn">Зберегти зміни</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section> 