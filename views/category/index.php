<h1><?= htmlspecialchars($Title ?? 'Категорії') ?></h1>

<?php if (!empty($categories)): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Опис</th>
            <th>Slug</th>
            <th>Дата створення</th>
            <th>Дата оновлення</th>
            <?php if (!empty($isAdmin)): ?>
                <th>Дії</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category->id ?></td>
                <td><?= htmlspecialchars($category->name ?? '') ?></td>
                <td><?= htmlspecialchars($category->description ?? '') ?></td>
                <td><?= htmlspecialchars($category->slug ?? '') ?></td>
                <td><?= $category->created_at ?></td>
                <td><?= $category->updated_at ?></td>
                <?php if (!empty($isAdmin)): ?>
                    <td>
                        <a href="/?route=category/edit/<?= $category->id ?>">Редагувати</a> |
                        <a href="/?route=category/delete/<?= $category->id ?>">Видалити</a>
                    </td>
                <?php endif; ?>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Категорій не знайдено.</p>
<?php endif; ?>

<?php if (!empty($isAdmin)): ?>
    <p>
        <a href="/?route=category/add">+ Додати категорію</a>
    </p>
<?php endif; ?>
