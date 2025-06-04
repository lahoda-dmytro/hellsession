<?php
/**
 * @var \models\Category $category
 * @var array $errors
 * @var array $old
 * @var string $title
 */
?>

<h1><?= htmlspecialchars($title ?? 'Редагувати категорію') ?></h1>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/?route=category/edit/<?= $category->id ?>">
    <label for="name">Назва:</label><br>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? $category->name) ?>" required><br><br>

    <label for="description">Опис:</label><br>
    <textarea id="description" name="description"><?= htmlspecialchars($old['description'] ?? $category->description) ?></textarea>

    <button type="submit">Оновити категорію</button>
</form>
