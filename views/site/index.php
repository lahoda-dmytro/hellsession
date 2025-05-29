<?php
/**
 * @var string $message
 * @var string $title
 * @var array $latestProducts
 */
?>
<h1><?= htmlspecialchars($message ?? 'welcome') ?></h1>
<p>Main page"<?= htmlspecialchars($title ?? 'Hell session') ?>".</p>

<?php /*
if (isset($latestProducts) && !empty($latestProducts)): ?>
    <h2>Останні товари:</h2>
    <ul>
        <?php foreach ($latestProducts as $product): ?>
            <li><?= htmlspecialchars($product->name) ?> - <?= htmlspecialchars($product->price) ?> $</li>
        <?php endforeach; ?>
    </ul>
<?php endif;
*/ ?>

<p>go to <a href="/?route=category/index">category</a> або <a href="/?route=products/index">products</a>.</p>