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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="/?route=product/index" class="nav-a">← Назад до списку</a>
        </div>
    </div>

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
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3">Основна інформація</h3>
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

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="available" name="available" value="1" <?= (!isset($old['available']) || $old['available']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="available">Is available</label>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-3">Деталі товару</h3>
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
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3 class="mb-3">Зображення</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="main_image" class="form-label">Головне зображення</label>
                            <input type="file" class="form-control mt-2" id="main_image" name="main_image" accept="image/*" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Додаткові зображення</label>
                            <input type="file" class="form-control mt-2" id="images" name="images[]" accept="image/*" multiple>
                            <div class="form-text">Можна вибрати кілька зображень</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Додати товар</button>
        <br>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const gallery = document.getElementById('imageGallery');
    if (gallery) {
        new Sortable(gallery, {
            animation: 150,
            onEnd: function() {
                const imageIds = Array.from(gallery.children).map(item => item.dataset.imageId);
                fetch('/?route=product/reorderImages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=<?php if (isset($product_id)) echo $product_id; ?>&image_ids=' + JSON.stringify(imageIds)
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Помилка при збереженні порядку зображень');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Помилка при збереженні порядку зображень');
                });
            }
        });
    }
});
</script>


