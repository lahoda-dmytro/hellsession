<?php
/**
 * @var \models\Product $products
 * @var \models\Category $category
 * @var \models\ProductImage $images
 * @var \models\Product $product
 * @var array $errors
 * @var array $old
 * @var string $title
 */
?>
<h1><?= htmlspecialchars($product->name) ?></h1>

<p><strong>Ціна:</strong> <?= number_format($product->price, 2) ?> ₴</p>
<p>Категорія: <?= $category ? $category->name : '—' ?></p>
<p><strong>Опис:</strong> <?= nl2br(htmlspecialchars($product->description)) ?></p>

<?php if ($product->main_image): ?>
    <p><img src="<?= htmlspecialchars($product->main_image) ?>" alt="<?= htmlspecialchars($product->name) ?>" width="200"></p>
<?php endif; ?>

<h2>Галерея</h2>

<?php if (!empty($images)): ?>
    <div class="gallery">
        <?php foreach ($images as $image): ?>
            <img src="<?= htmlspecialchars($image->image_path) ?>" width="200">
        <?php endforeach; ?>

    </div>
<?php else: ?>
    <p>Немає додаткових зображень.</p>
<?php endif; ?>


<?php if (!empty($isAdmin)): ?>
    <p><a href="/?route=product/edit/<?= $product->id ?>">Редагувати</a></p>
<?php endif; ?>
