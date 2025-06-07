<?php
/**
 * @var \models\User $user
 * @var \models\Order[] $orders
 * @var array $form_data
 * @var array $errors
 * @var string|null $message
 */
?>

<div class="container mt-4">
    <div class="d-flex flex-wrap">
        <div class="windowp d-flex bg-white p-4 mb-4 mx-2 rounded flex-grow-1">
            <form action="/?route=users/profile" method="post" enctype="multipart/form-data" class="flex-grow-1">
                <h2 class="mb-2">Profile</h2>
                <?php if (!empty($message)): ?>
                    <div class="alert" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <?php echo htmlspecialchars($error); ?><br>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex flex-wrap">
                    <div class="col-md-6 pe-md-2">
                        <div class="col-md-12 mb-3">
                            <label for="id_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control form-styleprofile" id="id_first_name"
                            name="first_name" placeholder="Your First Name" value="<?php echo htmlspecialchars($form_data['first_name'] ?? ''); ?>"
                            required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="id_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-styleprofile" id="id_last_name"
                            name="last_name" placeholder="Your Last Name" value="<?php echo htmlspecialchars($form_data['last_name'] ?? ''); ?>"
                            required>
                        </div>
                    </div>
                    <div class="col-md-6 ps-md-2">
                        <div class="col-md-12 mb-3">
                            <label for="id_username" class="form-label">Username</label>
                            <input type="text" class="form-control form-styleprofile" id="id_username"
                            name="username" placeholder="Your Username" value="<?php echo htmlspecialchars($form_data['username'] ?? ''); ?>"
                            required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="id_email" class="form-label">Email</label>
                            <input type="email" class="form-control form-styleprofile" id="id_email"
                            name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
                            required>
                        </div>
                    </div>
                </div>
                <div class="btns d-flex gap-4 mt-4">
                    <button type="submit" class="profile-btn">Save</button>
                    <a class="profile-btn" href="/?route=users/logout">Logout</a>
                </div>
            </form>
            <div class="orders flex-grow-1 ms-4">
                <h2 class="mb-2">Your Orders</h2>   
                <?php if (!empty($orders)): ?>
                    <div class="orderss">
                        <?php foreach ($orders as $order): ?>
                            <div class="order-cart border p-3 mb-3 rounded">
                                <h5 class="order-title">Order № <?php echo htmlspecialchars($order->id); ?></h5>
                                <p class="order-desc">
                                    <?php foreach ($order->getOrderItems() as $item): ?>
                                        <?php $product = \models\Product::getById($item->product_id); ?>
                                        <div class="orders-carts mb-2">
                                            <span class="dadad">Name: </span><?php echo htmlspecialchars($product->name ?? ''); ?>
                                            <br>
                                            <span class="dadad">Quantity:</span> <?php echo htmlspecialchars($item->quantity); ?>,
                                            <span class="dadad">Price: $<?php echo number_format(htmlspecialchars($item->price), 2); ?></span> <br>
                                            <span class="dadad">Date:</span>  <?php echo htmlspecialchars($order->created_at); ?>
                                            <br>
                                        </div>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <h4 class="notorders">You haven't ordered anything yet.</h4>
                <?php endif; ?>         
            </div>
        </div>
    </div>
</div>