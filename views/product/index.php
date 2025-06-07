<?php
/**
 * @var \models\Product $products
 * @var \models\Category $category
 * @var \models\ProductImage $images
 * @var \models\Product $product
 * @var array $errors
 * @var array $old
 * @var string $title
 * @var \controllers\ProductController $categoryMap
 */
?>

<h1><?= htmlspecialchars($Title ?? 'Products') ?></h1>


<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Назва</th>
        <th scope="col">Ціна</th>
        <th scope="col">Наявність</th>
        <th scope="col">Категорія</th>
        <th scope="col">Дії</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product->name) ?></td>
            <td><?= number_format($product->price, 2) ?></td>
            <td><?= $product->available ? 'В наявності' : 'Немає' ?></td>
            <td><?= htmlspecialchars($categoryMap[$product->category_id]->name ?? 'Невідома категорія') ?></td>
            <td>
                <a href="/?route=product/view/<?= $product->slug ?>">Перегляд</a>
                <?php if ($isAdmin): ?>
                    | <a href="/?route=product/edit/<?= $product->slug ?>">Редагувати</a>
                    | <a href="/?route=product/delete/<?= $product->slug ?>" onclick="return confirm('Видалити товар?')">Видалити</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php if (!empty($isAdmin)): ?>
    <a href="/?route=product/add" class="btn-secondary form-stylereg d-flex ">+ Додати товар</a>
<?php endif; ?>

