<?php
/**
 * @var string[] $errors
 * @var string $username
 */
?>
<section class="login-reg d-flex d-block mx-auto w-50">
    <div class="login-title">
        <h2>Registration</h2>
        <form method="POST" action="/?route=users/register">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id_first_name" class="form-label form-stylereg">First Name</label>
                    <input type="text" class="form-control form-stylereg" id="id_first_name"
                           value="<?= htmlspecialchars($old['first_name']  ?? '') ?>"
                           name="first_name" placeholder="Your First Name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_last_name" class="form-label form-stylereg">Last Name</label>
                    <input type="text" class="form-control form-stylereg" id="id_last_name"
                           value="<?= htmlspecialchars($old['last_name']  ?? '') ?>"
                           name="last_name" placeholder="Your Last Name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_username" class="form-label form-stylereg">Username</label>
                    <input type="text" class="form-control form-stylereg" id="id_username"
                           value="<?= htmlspecialchars($old['username']  ?? '') ?>"
                           name="username" placeholder="Your Username" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_email" class="form-label form-stylereg">Email</label>
                    <input type="email" class="form-control form-stylereg" id="id_email"
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                           name="email" placeholder="Your Email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_password1" class="form-label form-stylereg">Password</label>
                    <input type="password" class="form-control form-stylereg" id="id_password1"
                           value="<?= htmlspecialchars($password ?? '') ?>"
                           name="password1" placeholder="Your Password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_password2" class="form-label form-stylereg">Confirm Password</label>
                    <input type="password" class="form-control form-stylereg" id="id_password2"
                           value=""
                           name="password2" placeholder="Your Password" required>
                </div>
            </div>
            <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Register</button>

            <?php if (isset($errors) && !empty($errors)):?>
                <div class="alert">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </form>
    </div>
</section>


