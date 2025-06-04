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

<section class="login-reg d-flex d-block mx-auto w-50">
    <div class="login-title">
        <h2><?= htmlspecialchars($title ?? 'Редагувати категорію') ?></h2>
        <form method="post" action="/?route=category/edit/<?= $category->id ?>">
            <label for="name" class="form-label form-stylereg">Назва:</label><br>
            <input type="text" id="name" name="name" class="form-control form-stylereg w-20" id="id_first_name"
                   value="<?= htmlspecialchars($old['name'] ?? $category->name) ?>" required><br><br>

            <label for="description" class="form-label form-stylereg">Опис:</label><br>
            <textarea id="description" class="form-control form-stylereg w-100"
                      name="description"><?= htmlspecialchars($old['description'] ?? $category->description) ?></textarea>

            <button type="submit" class="login-btn form-stylereg d-flex d-block w-20">Оновити категорію</button>
        </form>
    </div>
</section>