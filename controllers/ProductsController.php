<?php

namespace controllers;

use classes\Controller;
use models\Product;
use models\Category;
class ProductsController extends Controller
{
    public function indexAction(): array
    {
        $products = Product::all();

        if (empty($products)) {
            $this->addData(['message' => 'products not found']);
        } else {
            $this->addData(['products' => $products]);
        }

        return $this->view('products', $this->data);
    }

    public function by_categoryAction(int $categoryId): array {
        $products = Product::where(['category_id' => $categoryId]);
        return $this->view("Товари категорії #$categoryId", ['products' => $products]);
    }

}