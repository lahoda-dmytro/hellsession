<?php
/**
 * @var \models\Category $categories
 * @var array $errors
 * @var array $old
 * @var string $title
 */
?>

<h1><?= htmlspecialchars($Title ?? 'edit') ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <div>
        <label>Назва:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
    </div>

    <div>
        <label>Короткий опис:</label>
        <input type="text" name="short_description" value="<?= htmlspecialchars($old['short_description'] ?? '') ?>">
    </div>

    <div>
        <label>Опис:</label>
        <textarea name="description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </div>

    <div>
        <label>Ціна (₴):</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($old['price'] ?? '') ?>" required>
    </div>

    <div>
        <label>Знижка (%):</label>
        <input type="number" step="0.01" name="discount_percentage" value="<?= htmlspecialchars($old['discount_percentage'] ?? '0') ?>">
    </div>

    <div>
        <label>Категорія:</label>
        <select name="category_id" required>
            <option value="">-- Оберіть категорію --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"
                    <?= isset($old['category_id']) && $old['category_id'] == $category->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label>Наявність:</label>
        <input type="checkbox" name="available" value="1"
            <?= (!isset($old['available']) || $old['available']) ? 'checked' : '' ?>>
    </div>

    <div>
        <label>Головне зображення:</label>
        <input type="file" name="main_image">
        <?php if (!empty($old['main_image'])): ?>
            <br><img src="<?= htmlspecialchars($old['main_image']) ?>" alt="Main Image" width="100">
        <?php endif; ?>
    </div>

    <button type="submit">Зберегти</button>
</form>
