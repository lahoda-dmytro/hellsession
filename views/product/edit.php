<?php
/**
 * @var \models\Category[] $categories
 * @var array $errors
 * @var array $old
 * @var string $Title
 */
?>

<h1><?= htmlspecialchars($Title ?? 'Редагування товару') ?></h1>

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
        <label for="name">Назва:</label>
        <input id="name" type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
    </div>

    <div>
        <label for="short_description">Короткий опис:</label>
        <input id="short_description" type="text" name="short_description" value="<?= htmlspecialchars($old['short_description'] ?? '') ?>">
    </div>

    <div>
        <label for="description">Опис:</label>
        <textarea id="description" name="description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </div>

    <div>
        <label for="price">Ціна (₴):</label>
        <input id="price" type="number" step="0.01" name="price" value="<?= htmlspecialchars($old['price'] ?? '') ?>" required>
    </div>

    <div>
        <label for="discount_percentage">Знижка (%):</label>
        <input id="discount_percentage" type="number" step="0.01" name="discount_percentage" value="<?= htmlspecialchars($old['discount_percentage'] ?? '0') ?>">
    </div>

    <div>
        <label for="category_id">Категорія:</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat->id ?>" <?= (isset($old['category_id']) && $old['category_id'] == $cat->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="available">Наявність:</label>
        <input id="available" type="checkbox" name="available" value="1" <?= (!isset($old['available']) || $old['available'] == 1) ? 'checked' : '' ?>>
    </div>

    <div>
        <label for="main_image">Головне зображення:</label>
        <input id="main_image" type="file" name="main_image" accept="image/*">
        <?php if (!empty($old['main_image'])): ?>
            <br>
            <img src="<?= htmlspecialchars($old['main_image']) ?>" alt="Головне зображення" width="150">
        <?php endif; ?>
    </div>

    <div>
        <label for="product_images">Додаткові зображення:</label>
        <input id="product_images" type="file" name="product_images[]" accept="image/*" multiple>
        <small>Можна вибрати кілька зображень, утримуючи Ctrl (Cmd на Mac)</small>
    </div>

    <button type="submit">Зберегти</button>
</form>
