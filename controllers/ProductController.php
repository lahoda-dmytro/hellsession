<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\Product;
use models\Category;
use models\User;
use models\ProductImage;

class ProductController extends Controller
{
    private function checkAdminAccess(): void {
        $user = User::getCurrentUser();
        if (!$user || !$user->is_superuser) {
            Core::getInstance()->error(403);
            exit();
        }
    }

    public function indexAction(): array {
        $products = Product::getAll();
        $categories = Category::getCategories();

        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat->id] = $cat;
        }

        $this->addData([
            'Title' => 'Список товарів',
            'products' => $products,
            'categories' => $categories,
            'categoryMap' => $categoryMap,
            'isAdmin' => User::getCurrentUser()?->is_superuser ?? false
        ]);

        return $this->view('product/index', $this->data);
    }

    public function addAction(): array {
        $this->checkAdminAccess();

        $errors = [];
        $values = [
            'category_id' => '',
            'name' => '',
            'description' => '',
            'short_description' => '',
            'price' => '',
            'discount_percentage' => '',
            'available' => 1,
            'main_image' => ''
        ];

        $categories = Category::getCategories();

        if ($this->isPost) {
            $name = trim($this->post->name ?? '');
            $slug = strtolower(str_replace(' ', '-', $name));
            $data = [
                'category_id' => (int) ($this->post->category_id ?? 0),
                'name' => $name,
                'slug' => $slug,
                'description' => $this->post->description ?? '',
                'short_description' => $this->post->short_description ?? '',
                'price' => (float) ($this->post->price ?? 0),
                'discount_percentage' => (float) ($this->post->discount_percentage ?? 0),
                'available' => (int) ($this->post->available ?? 1),
                'main_image' => $this->post->main_image ?? '',
            ];
            $values = $data;

            if (empty($name)) {
                $errors[] = 'Назва товару є обов\'язковою.';
            }

            if (empty($errors)) {
                $product = Product::addProduct($data);
                if ($product) {
                    header('Location: /?route=product/index');
                    exit();
                } else {
                    $errors[] = 'Не вдалося додати товар.';
                }
            }
        }

        $this->addData([
            'Title' => 'Додати товар',
            'errors' => $errors,
            'old' => $values,
            'categories' => $categories
        ]);

        return $this->view('product/add', $this->data);
    }

    public function editAction(int $id): array {
        $this->checkAdminAccess();

        $product = Product::getProductById($id);
        if (!$product) {
            Core::getInstance()->error(404);
            exit();
        }

        $errors = [];
        $categories = Category::getCategories();
        $category = Category::find($product->category_id);

        $values = [
            'category_id' => $product->category_id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'short_description' => $product->short_description,
            'price' => $product->price,
            'discount_percentage' => $product->discount_percentage,
            'available' => $product->available,
            'main_image' => $product->main_image,
        ];

        if ($this->isPost) {
            $name = trim($this->post->name ?? '');
            $slug = strtolower(str_replace(' ', '-', $name));
            $data = [
                'category_id' => (int) ($this->post->category_id ?? 0),
                'name' => $name,
                'slug' => $slug,
                'description' => $this->post->description ?? '',
                'short_description' => $this->post->short_description ?? '',
                'price' => (float) ($this->post->price ?? 0),
                'discount_percentage' => (float) ($this->post->discount_percentage ?? 0),
                'available' => isset($this->post->available) ? 1 : 0,
                'main_image' => $product->main_image,
            ];

            $values = $data;

            if (empty($name)) {
                $errors[] = 'Назва товару є обов\'язковою.';
            }

            if (empty($errors)) {
                if (Product::updateProduct($id, $data)) {
                    header('Location: /?route=product/index');
                    exit();
                } else {
                    $errors[] = 'Не вдалося оновити товар.';
                }
            }
        }

        $this->addData([
            'Title' => 'Редагувати товар',
            'product_id' => $product->id,
            'old' => $values,
            'errors' => $errors,
            'categories' => $categories,
            'category' => $category,
        ]);

        return $this->view('product/edit', $this->data);
    }


    public function deleteAction(int $id): void {
        $this->checkAdminAccess();

        if (Product::deleteProduct($id)) {
            header('Location: /?route=product/index');
        } else {
            Core::getInstance()->error(500);
        }
    }

    public function viewAction(int $id): array {
        $product = Product::getById($id);

        if (!$product) {
            Core::getInstance()->error(404);
            exit();
        }

        $product = Product::find($id);
        $category = Category::find($product->category_id);
        $images = ProductImage::where(['product_id' => $id]);


        return $this->view('product/view', [
            'Title' => $product->name,
            'product' => $product,
            'category' => $category,
            'images' => $images,
            'isAdmin' => User::getCurrentUser()?->is_superuser ?? false
        ]);
    }
}