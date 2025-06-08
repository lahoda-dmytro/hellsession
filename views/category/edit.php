<?php
/**
 * @var \models\Category $category
 * @var array $errors
 * @var array $old
 * @var string $title
 */
?>


<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <div class="login-title">
        <h2><?= htmlspecialchars($title ?? 'Редагувати категорію') ?></h2>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="/?route=category/index" class="nav-a">← Назад до списку</a>
            </div>
            <div>
                <a href="/?route=category/delete/<?= htmlspecialchars($category->slug) ?>" class="nav-a" onclick="return confirm('Видалити категорію?')">Видалити</a>
            </div>
        </div>
        <form method="post" action="/?route=category/edit/<?= $category->slug ?>">
            <label for="name" class="form-label form-stylereg">Назва:</label><br>
            <input type="text" id="name" name="name" class="form-control form-stylereg w-20" id="id_first_name"
                   value="<?= htmlspecialchars($old['name'] ?? $category->name) ?>" required><br>

            <label for="description" class="form-label form-stylereg">Опис:</label><br>
            <textarea id="description" class="form-control form-stylereg w-100"
                      name="description"><?= htmlspecialchars($old['description'] ?? $category->description) ?></textarea>
            <br>
            <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Оновити категорію</button>
        </form>
    </div>
