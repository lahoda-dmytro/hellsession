<h1><?= htmlspecialchars($data['Title'] ?? 'Редагувати категорію') ?></h1>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/?route=category/edit&id=<?= $data['category']->id ?>">
    <label for="name">Назва:</label><br>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($data['old']['name'] ?? '') ?>" required><br><br>
    <label for="description">Опис:</label><br>
    <textarea id="description" name="description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea><br><br>

    <button type="submit">Оновити категорію</button>
</form>
