<?php
/**
 * @var string[] $errors
 * @var string $username
 */
?>
<section class="login d-flex">
    <div class="login-title">
        <h2>Login</h2>
        <?php if (isset($errors) && !empty($errors)):?>
            <div class="alert alert-danger" style="color: red;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="/?route=users/login">
            <div class="mb-3">
                <label for="username" class="form-label form-style">Username:</label>
                <input type="text" id="username" name="username" class="form-control form-style" value="<?= htmlspecialchars($username ?? '') ?>"
                           required placeholder="Your Name">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label form-style">Password:</label>
                <input type="password" id="password" name="password" class="form-control form-style" required placeholder="Your Password">
            </div>
            <button type="submit" class="login-btn form-style">Login</button>
        </form>
    </div>
</section>


