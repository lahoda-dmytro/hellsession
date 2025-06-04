<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<section class="login-reg d-flex d-block mx-auto w-50">
    <div class="login-title">
        <h2><?= htmlspecialchars($Title ?? 'Додати категорію') ?></h2>

        <form method="post" action="/?route=category/add">
            <label for="name" class="form-label form-stylereg">Назва:</label><br>
            <input type="text" id="name" name="name" class="form-control form-stylereg w-20"
                   value="<?= htmlspecialchars($old['name'] ?? '') ?>" required><br><br>

            <label for="description" class="form-label form-stylereg">Опис:</label><br>
            <textarea id="description" name="description" class="form-control form-stylereg w-100"
            ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>

            <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Додати категорію</button>
        </form>
    </div>
</section>
