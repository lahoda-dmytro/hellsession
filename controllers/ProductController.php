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

    private function handleImageUpload(array $files, string $productName, bool $isMain = false): ?string {
        if (!isset($files['tmp_name']) || !is_uploaded_file($files['tmp_name'])) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($files['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            return null;
        }

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/products/' . $productName . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($files['tmp_name'], $filePath)) {
            return '/uploads/products/' . $productName . '/' . $fileName;
        }

        return null;
    }

    private function handleMultipleImageUpload(array $files, int $productId, string $productName): void {
        if (!isset($files['tmp_name']) || !is_array($files['tmp_name'])) {
            return;
        }

        $sortOrder = 10;
        foreach ($files['tmp_name'] as $key => $tmpName) {
            if (!is_uploaded_file($tmpName)) {
                continue;
            }

            $file = [
                'name' => $files['name'][$key],
                'type' => $files['type'][$key],
                'tmp_name' => $tmpName,
                'error' => $files['error'][$key],
                'size' => $files['size'][$key]
            ];

            $imagePath = $this->handleImageUpload($file, $productName);
            if ($imagePath) {
                ProductImage::addImage([
                    'product_id' => $productId,
                    'image_path' => $imagePath,
                    'sort_order' => $sortOrder,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $sortOrder += 10;
            }
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
                'main_image' => '',
            ];

            if (isset($_FILES['main_image'])) {
                $mainImagePath = $this->handleImageUpload($_FILES['main_image'], $slug, true);
                if ($mainImagePath) {
                    $data['main_image'] = $mainImagePath;
                }
            }

            $values = $data;

            if (empty($name)) {
                $errors[] = 'Назва товару є обов\'язковою.';
            }

            if (empty($errors)) {
                $product = Product::addProduct($data);
                if ($product) {
                    if (isset($_FILES['images'])) {
                        $this->handleMultipleImageUpload($_FILES['images'], $product->id, $slug);
                    }
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

    public function editAction(string $slug): array {
        $this->checkAdminAccess();

        $product = Product::getBySlug($slug);
        if (!$product) {
            Core::getInstance()->error(404);
            exit();
        }

        $errors = [];
        $categories = Category::getCategories();
        $category = Category::find($product->category_id);
        $images = $product->getImages();

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
            $data = [
                'category_id' => $this->post->category_id,
                'name' => $this->post->name,
                'description' => $this->post->description,
                'short_description' => $this->post->short_description,
                'price' => $this->post->price,
                'discount_percentage' => $this->post->discount_percentage,
                'available' => $this->post->available == 1 ? 1 : 0,
                'main_image' => $product->main_image,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (isset($_FILES['main_image']) && is_uploaded_file($_FILES['main_image']['tmp_name'])) {
                $product->deleteMainImage();
                $mainImagePath = $this->handleImageUpload($_FILES['main_image'], $slug, true);
                if ($mainImagePath) {
                    $data['main_image'] = $mainImagePath;
                }
            }

            $values = $data;

            if (empty($name)) {
                $errors[] = 'Назва товару є обов\'язковою.';
            }

            if (empty($errors)) {
                if (Product::updateProduct($product->id, $data)) {
                    if (isset($_FILES['images'])) {
                        $this->handleMultipleImageUpload($_FILES['images'], $product->id, $slug);
                    }
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
            'images' => $images
        ]);

        return $this->view('product/edit', $this->data);
    }

    public function deleteAction(string $slug): void {
        $this->checkAdminAccess();

        $product = Product::getBySlug($slug);
        if (!$product) {
            Core::getInstance()->error(404);
            exit();
        }

        if (Product::deleteProduct($product->id)) {
            header('Location: /?route=product/index');
        } else {
            Core::getInstance()->error(500);
        }
    }

    public function viewAction(string $slug): array {
        $product = Product::getBySlug($slug);

        if (!$product) {
            Core::getInstance()->error(404);
            exit();
        }

        $category = Category::find($product->category_id);
        $images = ProductImage::where(['product_id' => $product->id]);

        return $this->view('product/view', [
            'Title' => $product->name,
            'product' => $product,
            'category' => $category,
            'images' => $images,
            'isAdmin' => User::getCurrentUser()?->is_superuser ?? false
        ]);
    }

    public function deleteImageAction(int $id): void {
        $this->checkAdminAccess();

        $image = ProductImage::find($id);
        if (!$image) {
            Core::getInstance()->error(404);
            exit();
        }

        $filePath = $_SERVER['DOCUMENT_ROOT'] . $image->image_path;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if (ProductImage::deleteImage($id)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            Core::getInstance()->error(500);
        }
    }
}