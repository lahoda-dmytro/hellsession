<?php
/**
 * @var string $message
 * @var string $title
 * @var array $discountedProducts
 */
?>

<section class="home d-flex flex-column">
    <div class="home-title">
<!--        <a href="#" class="home-btn mt-4">ALL PRODUCTS</a>-->
    </div>
    <div class="home-recomendation">
        <div class="rec-title">
            <h3><span>Discounted Products</span></h3>
        </div>
    </div>
    <div class="home-cards d-flex gap-4" style="flex-wrap: wrap; overflow: hidden;">
        <?php foreach ($discountedProducts as $product): ?>
            <a href="/?route=site/product_detail/<?php echo $product->slug; ?>" class="home-card d-flex flex-column align-items-center text-center">
                <?php if ($product->main_image): ?>
                    <img src="<?php echo htmlspecialchars($product->main_image); ?>" class="card-img" alt="<?php echo htmlspecialchars($product->name); ?>">
                <?php else: ?>
                    <img src="/static/img/noimage.jpg" class="card-img" alt="No image available">
                <?php endif; ?>
                <h5 class="title-card"><?php echo htmlspecialchars($product->name); ?></h5>
                <div class="cart-discount d-flex gap-2">
                    <p class="line">$ <?php echo number_format($product->price, 2); ?></p>
                    <p class="price pt-2">$ <?php echo number_format($product->price * (1 - $product->discount_percentage / 100), 2); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<img src="/static/img/logogot.png" class="logogothic" alt="">
