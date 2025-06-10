<?php
/**
 * @var \models\Product $product
 * @var \models\Category $category
 * @var \models\ProductImage[] $images
 */
?>
<div class="detail-product d-flex">
    <div class="detail-img">
        <?php if ($product->main_image): ?>
            <img class="detail-image" src="<?= htmlspecialchars($product->main_image) ?>" alt="<?= htmlspecialchars($product->name) ?>" style="display: block;" data-index="0">
        <?php else: ?>
            <img class="detail-image" src="/static/img/noimage.jpg" alt="No image available" style="display: block;" data-index="0">
        <?php endif; ?>

        <?php foreach ($images as $index => $image): ?>
            <img class="detail-image" src="<?= htmlspecialchars($image->image_path) ?>" alt="<?= htmlspecialchars($product->name) ?>" style="display: none;" data-index="<?= $index + 1 ?>">
        <?php endforeach; ?>

        <div class="image-nav">
            <button class="prev-btn">&lsaquo;</button>
            <button class="next-btn">&rsaquo;</button>
        </div>
    </div>

    <div class="detail-description">
        <h2><?= htmlspecialchars($product->name) ?></h2>
        <h3>Категорія: <?= $category ? htmlspecialchars($category->name) : '—' ?></h3>
        <p>Опис: <?= nl2br(htmlspecialchars($product->description)) ?></p>

        <?php if ($product->discount_percentage > 0): ?>
            <div class="cart-discount d-flex gap-2">
                <p class="line">$ <?= number_format($product->price, 2) ?></p>
                <p class="price">$ <?= number_format($product->price * (1 - $product->discount_percentage / 100), 2) ?></p>
            </div>
        <?php else: ?>
            <p class="price">$ <?= number_format($product->price, 2) ?></p>
        <?php endif; ?>

        <div class="qform">
            <div class="cart-form" style="display: flex; align-items: center; gap: 10px;">
                <label for="quantity-<?= $product->id ?>">Кількість:</label>
                <select name="quantity" id="quantity-<?= $product->id ?>" class="form-control product-quantity-select" style="width: auto; border: none;">
                    <?php for($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <button type="button" class="add-to-cart-btn" data-product-id="<?= $product->id ?>">Додати в кошик</button>
        </div>
    </div>
</div>

<script>
    const images = document.querySelectorAll('.detail-image');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;

    if (images.length === 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    } else {
        prevBtn.addEventListener('click', () => {
            images[currentIndex].style.display = 'none';
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            images[currentIndex].style.display = 'block';
        });

        nextBtn.addEventListener('click', () => {
            images[currentIndex].style.display = 'none';
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].style.display = 'block';
        });
    }
</script>