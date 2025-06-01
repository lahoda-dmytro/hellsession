<?php
/**
 * @var string[] $errors
 * @var string $username
 */
?>
<h1>Логін</h1>
<?php if (isset($errors) && !empty($errors)):?>
    <div class="alert alert-danger" style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/?route=users/login"> <label>Username/Email: <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Увійти</button>
</form>
<p>Немає облікового запису? <a href="/?route=users/register">Зареєструватися</a></p>