<h1><?= $Title ?? 'Сторінка' ?></h1>

<?php if (!empty($categories) && is_array($categories)): ?>
    <h2>Категорії:</h2>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>ID: <?= htmlspecialchars($category['id']) ?>, Назва: <?= htmlspecialchars($category['name']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php elseif (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php else: ?>
    <p>Дані про категорії не були отримані або виникла помилка.</p>
<?php endif; ?>