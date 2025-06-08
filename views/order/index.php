<?php
/**
 * @var \models\Order[] $orders
 * @var bool $isAdmin
 */
?>

<h1><?= htmlspecialchars($Title ?? 'Замовлення') ?></h1>

<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Клієнт</th>
        <th scope="col">Email</th>
        <th scope="col">Адреса</th>
        <th scope="col">Сума</th>
        <th scope="col">Статус</th>
        <th scope="col">Дата</th>
        <th scope="col">Дії</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order->id ?></td>
                <td><?= htmlspecialchars($order->first_name . ' ' . $order->last_name) ?></td>
                <td><?= htmlspecialchars($order->email) ?></td>
                <td><?= htmlspecialchars($order->city . ', ' . $order->address) ?></td>
                <td>$<?= number_format($order->getTotalCost(), 2) ?></td>
                <td>
                    <?php if ($order->paid): ?>
                        Paid
                    <?php else: ?>
                        Pending Payment
                    <?php endif; ?>
                </td>
                <td><?= $order->created_at ?></td>
                <td>
                    <a href="/?route=order/view/<?= $order->id ?>">Перегляд</a>
                    | <a href="/?route=order/edit/<?= $order->id ?>">Редагувати</a>
                    | <a href="/?route=order/delete/<?= $order->id ?>" onclick="return confirm('Видалити замовлення?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" class="text-center">Замовлень не знайдено</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table> 