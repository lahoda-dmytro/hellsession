<?php
/**
 * @var array $products
 */
?>
<h1>Товари категорії</h1>
<ul>
    <?php foreach ($products as $product): ?>
        <li><?= htmlspecialchars($product->name) ?> — <?= number_format($product->price, 2) ?></li>
    <?php endforeach; ?>
</ul>
