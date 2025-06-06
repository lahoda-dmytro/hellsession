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
                <p class="line">₴ <?= number_format($product->price, 2) ?></p>
                <p class="price">₴ <?= number_format($product->price * (1 - $product->discount_percentage / 100), 2) ?></p>
            </div>
        <?php else: ?>
            <p class="price">₴ <?= number_format($product->price, 2) ?></p>
        <?php endif; ?>
        
        <form action="/?route=cart/add/<?= $product->id ?>" class="qform" method="post">
            <div class="cart-form" style="display: flex; align-items: center; gap: 10px;">
                <label for="quantity">Кількість:</label> 
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product->available ?>" class="form-control" style="width: auto; border: none;">
                <?php if (isset($_SESSION['csrf_token'])): ?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php endif; ?>
            </div>
            <input type="submit" class="add-to-cart-btn" value="Додати в кошик">
        </form>
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