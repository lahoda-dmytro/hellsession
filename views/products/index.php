<?php
/**
 * @var array $products
 * @var string $message
 */
?>
    <h1>list of items</h1>

<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php elseif (!empty($products)): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>category ID</th>
            <th>name</th>
            <th>price</th>
            <th>is available</th>
            <th>image</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product->id) ?></td>
                <td><?= htmlspecialchars($product->category_id) ?></td>
                <td><?= htmlspecialchars($product->name) ?></td>
                <td><?= htmlspecialchars($product->price) ?> $</td>
                <td><?= $product->available ? 'Так' : 'Ні' ?></td>
                <td>
                    <?php if (!empty($product->image)): ?>
                        <img src="<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>" width="50">
                    <?php else: ?>
                        haven`t
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>haven`t items at that moment</p>
<?php endif; ?>