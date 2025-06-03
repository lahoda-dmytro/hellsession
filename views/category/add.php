<?php
/**
 * @var string $Title Заголовок сторінки
 * @var array $errors Масив помилок (якщо є)
 * @var array $old Введені дані форми (для збереження стану після помилки)
 */

// Додаткова інформація з $this->data
$Title = $data['Title'] ?? 'Додати категорію';
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? []; // Введені дані форми, щоб їх не втрачати при помилці
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

<form action="/?route=category/add" method="POST">
    <div class="form-group">
        <label for="name">Назва категорії:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Опис:</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Додати</button>
</form>