<?php

namespace controllers;

use classes\Controller;

class ProductsController extends Controller {
    public function indexAction(): array {
        $products = ['Item 1', 'Item 2', 'Item 3'];
        return $this->view('Products Page', ['products' => $products]);
    }

    public function addAction(): array {
        return $this->view('Add New Product');
    }

}