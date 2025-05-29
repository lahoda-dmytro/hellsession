<?php
/**
 * @var array $categories
 * @var string $message
 */
?>
    <h1>category list</h1>

<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php elseif (!empty($categories)): ?>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>ID: <?= htmlspecialchars($category->id) ?>, name: <?= htmlspecialchars($category->name) ?> (Slug: <?= htmlspecialchars($category->slug) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>haven`t category at that moment</p>
<?php endif; ?>