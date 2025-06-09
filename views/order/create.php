<?php
/**
 * @var \models\Cart $cart
 * @var array $form_data
 * @var array $errors
 */
?>

<div class="forcreate">
    <div class="d-flex flex-wrap">

        <div class="windowp d-flex bg-white p-4 mb-4 mx-2 rounded flex-grow-1">
            <div class="row">
                <div class="col-md-7">
                    <form action="/?route=order/create" method="post" class="order-form">
                        <h2 class="mb-2">Create Order</h2>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control form-styleprofile" id="id_first_name"
                                name="first_name" placeholder="Your First Name" value="<?php echo htmlspecialchars($form_data['first_name'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_address" class="form-label">Address</label>
                                <input type="text" class="form-control form-styleprofile" id="id_address"
                                name="address" placeholder="Your Address" value="<?php echo htmlspecialchars($form_data['address'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control form-styleprofile" id="id_last_name"
                                name="last_name" placeholder="Your Last Name" value="<?php echo htmlspecialchars($form_data['last_name'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control form-styleprofile" id="id_postal_code"
                                name="postal_code" placeholder="Your Postal Code" value="<?php echo htmlspecialchars($form_data['postal_code'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_email" class="form-label">Email</label>
                                <input type="text" class="form-control form-styleprofile" id="id_email"
                                name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_city" class="form-label">City</label>
                                <input type="text" class="form-control form-styleprofile" id="id_city"
                                name="city" placeholder="Your City" value="<?php echo htmlspecialchars($form_data['city'] ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5>Total sum: $<?php echo number_format($cart->getTotalPrice(), 2); ?></h5><br>
                            <p><input type="submit" value="Proceed to Payment"></p>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="checkout">
                        <div class="cart-cards">
                            <?php if ($cart->getTotalQuantity() > 0):?>
                                <?php foreach ($cart->getItems() as $item): ?>
                                    <?php $product = \models\Product::getById($item['product_id']); ?>
                                    <?php if ($product && is_object($product)): ?>
                                        <div class="cart-card d-flex">
                                            <div class="cart-card-img">
                                                <img src="<?php echo $product->main_image ?: '/static/img/noimage.jpg'; ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                                            </div>
                                            <div class="cart-card-info">
                                                <div class="cart-card-name">
                                                    <p><strong><?php echo htmlspecialchars($product->name); ?></strong></p>
                                                </div>
                                                <div class="qform">
                                                    <p class="cart-form">Кількість: <?php echo $item['quantity']; ?></p>
                                                </div>

                                            </div>
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
                            <?php else: ?>
                                <h5>No products in cart</h5>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
