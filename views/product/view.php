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
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($product->main_image)): ?>
                <img src="/<?= htmlspecialchars($product->main_image) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product->name) ?>">
            <?php endif; ?>

            <?php if (!empty($images)): ?>
                <div class="row mt-3">
                    <?php foreach ($images as $image): ?>
                        <div class="col-4 mb-3">
                            <img src="/<?= htmlspecialchars($image->image_path) ?>" class="img-fluid rounded" alt="Додаткове зображення">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1><?= htmlspecialchars($product->name) ?></h1>
            
            <?php if ($product->discount_percentage > 0): ?>
                <div class="mb-3">
                    <span class="text-decoration-line-through text-muted">
                        <?= number_format($product->price, 2) ?> ₴
                    </span>
                    <span class="text-danger ms-2">
                        <?= number_format($product->price * (1 - $product->discount_percentage / 100), 2) ?> ₴
                    </span>
                    <span class="badge bg-danger ms-2">-<?= $product->discount_percentage ?>%</span>
                </div>
            <?php else: ?>
                <div class="mb-3">
                    <span class="h4"><?= number_format($product->price, 2) ?> ₴</span>
                </div>
            <?php endif; ?>

            <?php if (!empty($product->short_description)): ?>
                <div class="mb-3">
                    <p class="lead"><?= htmlspecialchars($product->short_description) ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($product->description)): ?>
                <div class="mb-3">
                    <?= nl2br(htmlspecialchars($product->description)) ?>
                </div>
            <?php endif; ?>

            <?php if ($product->available): ?>
                <div class="mb-3">
                    <span class="badge bg-success">В наявності</span>
                </div>
            <?php else: ?>
                <div class="mb-3">
                    <span class="badge bg-danger">Немає в наявності</span>
                </div>
            <?php endif; ?>

            <?php if (!empty($isAdmin)): ?>
                <div class="mt-4">
                    <a href="/?route=product/edit/<?= $product->slug ?>" class="btn btn-primary">Редагувати</a>
                    <a href="/?route=product/delete/<?= $product->slug ?>" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити цей товар?')">Видалити</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
