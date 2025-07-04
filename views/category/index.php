<h1><?= htmlspecialchars($Title ?? 'Категорії') ?></h1>
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <a href="/?route=admin/index" class="nav-a">← До адмін панелі</a>
    </div>
    <div>
        <a href="/?route=category/add" class="btn-secondary form-stylereg d-flex ">+ Додати категорію</a>
    </div>
</div>
<?php if (!empty($categories)): ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Назва</th>
            <th scope="col">Опис</th>
            <th scope="col">Slug</th>
            <th scope="col">Дата створення</th>
            <th scope="col">Дата оновлення</th>
            <?php if (!empty($isAdmin)): ?>
                <th scope="col">Дії</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <th scope="row"><?= $category->id ?></th>
                <td><?= htmlspecialchars($category->name ?? '') ?></td>
                <td><?= htmlspecialchars($category->description ?? '') ?></td>
                <td><?= htmlspecialchars($category->slug ?? '') ?></td>
                <td><?= $category->created_at ?></td>
                <td><?= $category->updated_at ?></td>
                <?php if (!empty($isAdmin)): ?>
                    <td>
                        <a href="/?route=category/edit/<?= $category->slug ?>" class="btn-secondary btn-sm ">Редагувати</a> |
                        <a href="/?route=category/delete/<?= $category->slug ?>" class="btn-secondary btn-sm">Видалити</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-warning">Категорій не знайдено.</div>
<?php endif; ?>

