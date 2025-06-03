<?php
/**
 * @var \models\Category $category Об'єкт категорії для редагування
 * @var string $Title Заголовок сторінки
 * @var array $errors Масив помилок (якщо є)
 * @var array $old Введені дані форми (для збереження стану після помилки)
 */

// Додаткова інформація з $this->data
$category = $data['category'] ?? null;
$Title = $data['Title'] ?? 'Редагувати категорію';
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? []; // Введені дані форми або початкові дані категорії

// Перевірка, чи передано об'єкт категорії
if (!$category) {
    echo '<div class="alert alert-danger" role="alert">Категорію не знайдено.</div>';
    echo '<p><a href="/?route=categories/index" class="btn btn-secondary">Повернутися до списку категорій</a></p>';
    return; // Зупиняємо виконання, якщо категорія не знайдена
}
?>

<h1><?= htmlspecialchars($Title) ?></h1>

<p><a href="/?route=category/index" class="btn btn-secondary">Повернутися до списку категорій</a></p>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/?route=category/edit/<?= htmlspecialchars($category->id) ?>" method="POST">
    <div class="form-group">
        <label for="name">Назва категорії:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? $category->name) ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Опис:</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($old['description'] ?? $category->description ?? '') ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Зберегти зміни</button>
</form>