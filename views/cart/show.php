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
                            <form action="/?route=cart/add/<?php echo $product->slug; ?>" method="post" class="qform">
                                <div class="cart-form" style="display: flex; align-items: center; gap: 10px;">
                                    <label for="quantity_<?php echo $product->id; ?>">Quantity:</label>
                                    <select name="quantity" id="quantity_<?php echo $product->id; ?>" onchange="this.form.submit()" class="form-control" style="width: auto; border: none;">
                                        <?php for($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php if($item['quantity'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <input type="hidden" name="override" value="true">
                                <?php if (isset($_SESSION['csrf_token'])): ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <?php endif; ?>
                            </form>
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
        <?php if (count($items) === 0): ?>
            <h5>No products in cart</h5>
        <?php else: ?>
            <h5>Total sum: $<?php echo number_format($total, 2); ?></h5>
        <?php endif; ?>
    </div>
    <div class="cart-buttons d-flex gap-3">
        <a href="/?route=site/products" class="cart-btn">Continue shopping</a>
        <?php if (count($items) > 0): ?>
            <a href="/?route=order/create" class="cart-btn">Checkout</a>
        <?php endif; ?>
    </div>
</section> 