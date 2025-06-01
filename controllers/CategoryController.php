<?php

namespace controllers;

use classes\Controller;
use models\Category;

class CategoryController extends Controller
{
    public function indexAction(): array
    {
        $categories = Category::all();

        if (empty($categories)) {
            $this->addData(['message' => 'category not found']);
        } else {
            $this->addData(['categories' => $categories]);
        }

        return $this->view('categories', $this->data);
    }
}