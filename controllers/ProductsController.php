<?php

namespace controllers;

use classes\Controller;
use models\Product;

class ProductsController extends Controller
{
    public function indexAction(): array
    {
        $allProducts = Product::all();

        if (empty($allProducts)) {
            $this->addData(['message' => 'products not found']);
        } else {
            $this->addData(['products' => $allProducts]);
        }

        return $this->view('products', $this->data);
    }
}