<?php
/**
 * @var \models\Order $order
 * @var array $errors
 * @var array $old
 * @var bool $isAdmin
 */
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= htmlspecialchars($Title ?? 'Редагування замовлення') ?></h1>
        <div>
            <a href="/?route=order/view/<?= $order->id ?>" class="btn btn-primary">Назад до перегляду</a>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="post" action="/?route=order/edit/<?= $order->id ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">Ім'я</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="<?= htmlspecialchars($old['first_name']) ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Прізвище</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="<?= htmlspecialchars($old['last_name']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?= htmlspecialchars($old['email']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">Місто</label>
                        <input type="text" class="form-control" id="city" name="city"
                               value="<?= htmlspecialchars($old['city']) ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="postal_code" class="form-label">Поштовий індекс</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code"
                               value="<?= htmlspecialchars($old['postal_code']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Адреса</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="<?= htmlspecialchars($old['address']) ?>" required>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="paid" name="paid" value="1"
                               <?= $old['paid'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="paid">Оплачено</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                    <a href="/?route=order/delete/<?= $order->id ?>" class="btn btn-danger"
                       onclick="return confirm('Ви впевнені, що хочете видалити це замовлення?')">Видалити замовлення</a>
                </div>
            </form>
        </div>
    </div>
</div> 