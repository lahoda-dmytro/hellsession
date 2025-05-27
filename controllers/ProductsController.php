<?php

namespace controllers;

use classes\Controller;
use classes\Template;

class ProductsController extends Controller
{
    public function listAction(){
        $template = new Template('views/product/list.php');
        $products = ['test_item_1', 'test_item_2'];
        return $this->view('list of products', ['products' => $products]);
    }
    public function addAction(){
        $template = new Template('views/product/add.php');
        return $this->view('added product');

    }
}