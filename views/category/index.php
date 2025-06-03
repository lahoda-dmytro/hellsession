<?php
/**
 * @var array $this->data['categories'] Масив категорій
 * @var string $this->data['Title'] Заголовок сторінки
 * @var bool $this->data['isAdmin'] Чи є користувач адміном
 */
$categories = $this->data['categories'] ?? [];
$Title = $this->data['Title'] ?? 'Категорії';
$isAdmin = $this->data['isAdmin'] ?? false;
?>

    <h1><?= htmlspecialchars($Title) ?></h1>

<?php if (empty($categories)): ?>
    <p>Немає категорій для відображення.</p>
<?php else: ?>
    <table>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category->name) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>