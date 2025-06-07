<?php
/**
 * @var string[] $errors
 * @var string $username
 */
?>
<section class="login d-flex d-block mx-auto w-50">
    <div class="login-title">
        <h2>Login</h2>
        <form method="POST" action="/?route=users/login">
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label form-stylereg">Username:</label>
                <input type="text" id="username" name="username" class="form-control form-stylereg"
                       value="<?= htmlspecialchars($username ?? '') ?>"
                           required placeholder="Your Name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label form-stylereg">Password:</label>
                <input type="password" id="password" name="password" class="form-control form-stylereg"
                       required placeholder="Your Password">
            </div>
            <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Login</button>
            <div class="reset-pass">
                <hr>
                <div class="mt-3">
                    <a href="#">Reset Password</a> | <a href="/?route=users/register">Create Account</a>
                </div>
            </div>

            <?php if (isset($errors) && !empty($errors)):?>
                <div class="alert">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <img src="/static/img/castle.png" class="castlep" alt="">
        </form>
    </div>
</section>




