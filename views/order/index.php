<?php
/**
 * @var \models\Order[] $orders
 * @var bool $isAdmin
 */
?>

<div class="container mt-4">
    <h1><?= htmlspecialchars($Title ?? 'Управління замовленнями') ?></h1>

    <?php if (!empty($orders)): ?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Клієнт</th>
                <th scope="col">Email</th>
                <th scope="col">Адреса</th>
                <th scope="col">Сума</th>
                <th scope="col">Статус оплати</th>
                <th scope="col">Дата створення</th>
                <th scope="col">Дії</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <th scope="row"><?= $order->id ?></th>
                    <td><?= htmlspecialchars($order->first_name . ' ' . $order->last_name) ?></td>
                    <td><?= htmlspecialchars($order->email) ?></td>
                    <td>
                        <?= htmlspecialchars($order->city . ', ' . $order->address . ', ' . $order->postal_code) ?>
                    </td>
                    <td>$<?= number_format($order->getTotalCost(), 2) ?></td>
                    <td>
                        <?php if ($order->paid): ?>
                            <span class="badge bg-success">Оплачено</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Очікує оплати</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $order->created_at ?></td>
                    <td>
                        <a href="/?route=order/view/<?= $order->id ?>" class="btn btn-primary btn-sm">Перегляд</a>
                        <a href="/?route=order/edit/<?= $order->id ?>" class="btn btn-secondary btn-sm">Редагувати</a>
                        <a href="/?route=order/delete/<?= $order->id ?>" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Ви впевнені, що хочете видалити це замовлення?')">Видалити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Замовлень не знайдено.</div>
    <?php endif; ?>
</div> 