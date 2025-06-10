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
        <?php if (count($items) === 0): ?>
            <h5 id="no-products-message">No products in cart</h5>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
                <?php
                $product = $item['product_data'];
                if ($product && is_object($product)):
                    ?>
                    <div class="cart-card d-flex" data-product-id="<?php echo $product->id; ?>">
                        <div class="cart-card-img">
                            <img src="<?php echo $product->main_image ?: '/static/img/noimage.jpg'; ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                        </div>
                        <div class="cart-card-info">
                            <div class="cart-card-name">
                                <p><?php echo htmlspecialchars($product->name); ?></p>
                            </div>
                            <div class="cart-card-q">
                                <div class="cart-form" style="display: flex; align-items: center; gap: 10px;">
                                    <label for="quantity_<?php echo $product->id; ?>">Quantity:</label>
                                    <select name="quantity" id="quantity_<?php echo $product->id; ?>" class="form-control" style="width: auto; border: none;">
                                        <?php for($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php if($item['quantity'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="remove-btn">Remove</button>
                        <div class="cart-card-price">
                            <?php
                            // Ціна товару з БД
                            $product_base_price = $product->price;
                            // Ціна товару зі знижкою з БД
                            $product_discounted_price = $product->price * (1 - $product->discount_percentage / 100);
                            ?>
                            <?php if ($product->discount_percentage > 0): ?>
                                <div class="cart-discount gap-2">
                                    <p class="line">$<?php echo number_format($product_base_price, 2); ?></p>
                                    <p class="price mt-3">$<span class="item-current-price-display"><?php echo number_format($product_discounted_price, 2); ?></span></p>
                                </div>
                            <?php else: ?>
                                <p class="price mt-3">$<span class="item-current-price-display"><?php echo number_format($product_base_price , 2); ?></span></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="total">
        <h5>Total sum: $<span id="cart-total-price"><?php echo number_format($total, 2); ?></span></h5>
    </div>
    <div class="cart-buttons d-flex gap-3">
        <a href="/?route=site/products" class="cart-btn">Continue shopping</a>
        <?php if (count($items) > 0): ?>
            <a href="/?route=order/create" class="cart-btn" id="checkout-btn">Checkout</a>
            <button type="button" class="cart-btn" id="clear-cart-btn">Clear Cart</button>
        <?php else: ?>
            <a href="/?route=order/create" class="cart-btn" id="checkout-btn" style="display: none;">Checkout</a>
            <button type="button" class="cart-btn" id="clear-cart-btn" style="display: none;">Clear Cart</button>
        <?php endif; ?>
    </div>
</section>