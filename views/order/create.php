<?php
/**
 * @var \models\Cart $cart
 * @var array $form_data
 * @var array $errors
 */
?>

<div class="forcreate">
    <div class="profile bg-white p-4 mb-4 mx-2">
        <h2 class="mb-2">Create Order</h2>
        <form action="/?route=order/create" method="post" class="order-form">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="col-md-12 mb-3">
                <label for="id_first_name" class="form-label">First Name</label>
                <input type="text" class="form-control form-styleprofile" id="id_first_name"
                name="first_name" placeholder="Your First Name" value="<?php echo htmlspecialchars($form_data['first_name'] ?? ''); ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="id_last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control form-styleprofile" id="id_last_name"
                name="last_name" placeholder="Your Last Name" value="<?php echo htmlspecialchars($form_data['last_name'] ?? ''); ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="id_email" class="form-label">Email</label>
                <input type="text" class="form-control form-styleprofile" id="id_email"
                name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="id_address" class="form-label">Address</label>
                <input type="text" class="form-control form-styleprofile" id="id_address"
                name="address" placeholder="Your Address" value="<?php echo htmlspecialchars($form_data['address'] ?? ''); ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="id_postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control form-styleprofile" id="id_postal_code"
                name="postal_code" placeholder="Your Postal Code" value="<?php echo htmlspecialchars($form_data['postal_code'] ?? ''); ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="id_city" class="form-label">City</label>
                <input type="text" class="form-control form-styleprofile" id="id_city"
                name="city" placeholder="Your City" value="<?php echo htmlspecialchars($form_data['city'] ?? ''); ?>" required>
            </div>
            <p><input type="submit" value="Place Order"></p>
        </form>
    </div>
    <div class="checkout">
        <h1>Checkout</h1>
        <div class="order-info">
            <?php foreach ($cart->getItems() as $item): ?>
                <?php $product = \models\Product::getById($item['product_id']); ?>
                <?php if ($product && is_object($product)): ?>
                    <li>
                        <?php echo $item['quantity']; ?>x <?php echo htmlspecialchars($product->name); ?>
                        <p>$ <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            <p>Total: $ <?php echo number_format($cart->getTotalPrice(), 2); ?></p>
        </div>
    </div>
</div>
 