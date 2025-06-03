<h1><?= htmlspecialchars($Title ?? 'Додати категорію') ?></h1>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/?route=category/add">
    <label for="name">Назва:</label><br>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required><br><br>

    <label for="description">Опис:</label><br>
    <textarea id="description" name="description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea><br><br>

    <button type="submit">Додати категорію</button>
</form>
