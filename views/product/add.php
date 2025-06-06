<?php
/**
 * @var \models\Category $categories
 * @var array $errors
 * @var array $old
 * @var string $title
 */
?>

<div class="container mt-4">
    <h1>Додати товар</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="category_id" class="form-label">Категорія</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Виберіть категорію</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>" <?= isset($old['category_id']) && $old['category_id'] == $category->id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Назва товару</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="short_description" class="form-label">Короткий опис</label>
            <textarea class="form-control" id="short_description" name="short_description" rows="2"><?= htmlspecialchars($old['short_description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Повний опис</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Ціна</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($old['price'] ?? '') ?>" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="discount_percentage" class="form-label">Знижка (%)</label>
            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" value="<?= htmlspecialchars($old['discount_percentage'] ?? '0') ?>" step="0.01" min="0" max="100">
        </div>

        <div class="mb-3">
            <label for="main_image" class="form-label">Головне зображення</label>
            <input type="file" class="form-control" id="main_image" name="main_image" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Додаткові зображення</label>
            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
            <div class="form-text">Можна вибрати кілька зображень</div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="available" name="available" value="1" <?= (!isset($old['available']) || $old['available']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="available">Товар доступний</label>
        </div>
    </form>
    <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Додати товар</button><br>
</div>


