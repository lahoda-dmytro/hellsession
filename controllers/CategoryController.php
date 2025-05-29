<?php

namespace controllers;

use classes\Controller;
use models\Category;

class CategoryController extends Controller
{
    public function indexAction(): array
    {
        $allCategories = Category::all();

        if (empty($allCategories)) {
            $this->addData(['message' => 'category not found']);
        } else {
            $this->addData(['categories' => $allCategories]);
        }

        return $this->view('categories', $this->data);
    }
}