<?php
/**
 * @var array $items
 * @var float $total
 */
?>

<section class="cart d-flex">
    <div class="cart-title">
        <h2>Shopping cart</h2>
    </div>
    <div class="cart-cards">
        <?php foreach ($items as $item): ?>
            <?php $product = \models\Product::getById($item['product_id']); ?>
            <?php if ($product && is_object($product)): ?>
                <div class="cart-card d-flex">
                    <div class="cart-card-img">
                        <img src="<?php echo $product->main_image ?: '/static/img/noimage.jpg'; ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                    </div>
                    <div class="cart-card-info">
                        <div class="cart-card-name">
                            <p><?php echo htmlspecialchars($product->name); ?></p>
                        </div>
                        <div class="cart-card-q">
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                        </div>
                    </div>
                    <form action="/?route=cart/remove/<?php echo $product->slug; ?>" method="post">
                        <input type="submit" value="Remove" class="remove-btn">
                        <?php if (isset($_SESSION['csrf_token'])): ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <?php endif; ?>
                    </form>
                    <div class="cart-card-price">
                        <?php if ($product->discount_percentage > 0): ?>
                            <div class="cart-discount gap-2">
                                <p class="line">$<?php echo number_format($product->price, 2); ?></p>
                                <p class="price mt-3">$<?php echo number_format($product->price * (1 - $product->discount_percentage / 100), 2); ?></p>
                            </div>
                        <?php else: ?>
                            <p class="price mt-3">$<?php echo number_format($product->price, 2); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="total">
        <h5>Total sum: $<?php echo number_format($total, 2); ?></h5>
    </div>
    <div class="cart-buttons d-flex gap-3">
        <a href="/?route=site/products" class="cart-btn">Continue shopping</a>
        <?php if (count($items) > 0): ?>
            <a href="/?route=order/create" class="cart-btn">Checkout</a>
        <?php endif; ?>
    </div>
</section> 