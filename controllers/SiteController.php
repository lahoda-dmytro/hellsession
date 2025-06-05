<?php

namespace controllers;

use classes\Controller;
use classes\Core;

class SiteController extends Controller {
    public function indexAction(): array {
        //var_dump($_SESSION);


        $this->addData(['message' => 'welcome to main page']);
        $this->addData(['title' => 'hell session']);


        return $this->view('Home', $this->data);
    }

    public function productsAction(): array {
        $categorySlug = $_GET['category'] ?? null;
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 12;

        error_log("=== Products Page Debug ===");
        error_log("Request params: " . print_r($_GET, true));

        $categories = \models\Category::getCategories();
        error_log("Categories query result: " . print_r($categories, true));

        $category = null;
        if ($categorySlug) {
            foreach ($categories as $cat) {
                if ($cat->slug === $categorySlug) {
                    $category = $cat;
                    break;
                }
            }
        }
        error_log("Selected category: " . ($category ? print_r($category->toArray(), true) : 'null'));

        $products = \models\Product::getProductsWithPagination(
            $page, 
            $perPage, 
            $category ? $category->id : null
        );
        error_log("Products query result: " . print_r($products, true));
        
        $totalProducts = \models\Product::getTotalProducts($category ? $category->id : null);
        $totalPages = ceil($totalProducts / $perPage);

        error_log("Total Products: " . $totalProducts);
        error_log("Total Pages: " . $totalPages);

        $this->addData([
            'title' => $category ? $category->name : 'All Products',
            'categories' => $categories,
            'category' => $category,
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);

        return $this->view('Products', $this->data);
    }

}