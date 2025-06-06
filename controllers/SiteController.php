<?php

namespace controllers;

use classes\Controller;
use classes\Core;

class SiteController extends Controller {
    public function indexAction(): array {
        //var_dump($_SESSION);

        $discountedProducts = \models\Product::getDiscountedProducts();

        $this->addData([
            'message' => 'welcome to main page',
            'title' => 'hell session',
            'discountedProducts' => $discountedProducts
        ]);

        return $this->view('Home', $this->data);
    }
    public function productsAction(): array {
        $categorySlug = $_GET['category'] ?? null;
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 10;

        $categories = \models\Category::getCategories();

        $category = null;
        if ($categorySlug) {
            foreach ($categories as $cat) {
                if ($cat->slug === $categorySlug) {
                    $category = $cat;
                    break;
                }
            }
        }

        $products = \models\Product::getProductsWithPagination(
            $page, 
            $perPage, 
            $category ? $category->id : null
        );

        $totalProducts = \models\Product::getTotalProducts($category ? $category->id : null);
        $totalPages = ceil($totalProducts / $perPage);

        return $this->view('Products', [
            'title' => $category ? $category->name : 'All Products',
            'categories' => $categories,
            'category' => $category,
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
    public function product_detailAction(string $slug): array {
        $product = \models\Product::getBySlug($slug);

        if (!$product) {
            Core::getInstance()->error(404);
            exit();
        }

        $category = \models\Category::find($product->category_id);
        
        $images = \models\ProductImage::where(['product_id' => $product->id]);

        $mainImage = $product->main_image;

        $this->addData([
            'Title' => $product->name,
            'product' => $product,
            'category' => $category,
            'images' => $images,
            'mainImage' => $mainImage
        ]);

        return $this->view('Product Detail', []);
    }
}