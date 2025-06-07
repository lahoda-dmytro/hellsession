<?php
/**
 * @var array $data
 */
$title = $title ?? 'Products';
$categories = $categories ?? [];
$category = $category ?? null;
$products = $products ?? [];
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;

foreach ($products as $product) {
    error_log("Product ID: " . $product->id . ", Main Image: " . ($product->main_image ?? 'null'));
}
?>

<div class="llist d-flex">
    <div class="sidebar">
        <h3>Categories</h3>
        <ul>
            <li <?php echo !$category ? 'class="selected"' : ''; ?>>
                <a href="/?route=site/products">All</a>
            </li>
            <?php foreach ($categories as $cat): ?>
                <li <?php echo ($category && $category->slug === $cat->slug) ? 'class="selected"' : ''; ?>>
                    <a href="/?route=site/products&category=<?php echo $cat->slug; ?>">
                        <?php echo htmlspecialchars($cat->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="main">
        <div class="main-title">
            <?php echo htmlspecialchars($category ? $category->name : 'Products'); ?>
        </div>
        <div class="product-list">
            <div class="items">
                <?php foreach ($products as $product): ?>
                    <div class="item">
                        <a href="/?route=site/product_detail/<?php echo $product->slug; ?>" class="home-card d-flex flex-column align-items-center text-center qform">
                            <?php

                            if ($product->main_image): ?>
                                <img src="<?php echo htmlspecialchars($product->main_image); ?>" class="card-img" alt="<?php echo htmlspecialchars($product->name); ?>">
                            <?php else: ?>
                                <img src="/static/img/noimage.jpg" class="card-img" alt="No image available">
                            <?php endif; ?>
                            <h5 class="title-card"><?php echo htmlspecialchars($product->name); ?></h5>
                            <?php if ($product->discount_percentage > 0): ?>
                                <div class="cart-discount d-flex gap-2">
                                    <p class="line">$ <?php echo number_format($product->price, 2); ?></p>
                                    <p class="price pt-2">$ <?php echo number_format($product->price * (1 - $product->discount_percentage / 100), 2); ?></p>
                                </div>
                            <?php else: ?>
                                <p class="price">$ <?php echo number_format($product->price, 2); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if ($totalPages > 1): ?>
            <ul class="pagination">
                <li class="<?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                    <a href="<?php echo $currentPage > 1 ? '/?route=site/products&page=' . ($currentPage - 1) . ($category ? '&category=' . $category->slug : '') : '#'; ?>">Previous</a>
                </li>
                <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                    <li>
                        <a href="/?route=site/products&page=<?php echo $i; ?><?php echo $category ? '&category=' . $category->slug : ''; ?>" 
                           class="<?php echo $i === $currentPage ? 'disabled' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
                <li class="<?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                    <a href="<?php echo $currentPage < $totalPages ? '/?route=site/products&page=' . ($currentPage + 1) . ($category ? '&category=' . $category->slug : '') : '#'; ?>">Next</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
    <div class="mainvl"></div>
</div> 