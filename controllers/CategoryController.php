<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\Category;
use models\User;

class CategoryController extends Controller {

    private function checkAdminAccess(): void {
        if (!User::isLoggedIn() || !User::getCurrentUser() || !User::getCurrentUser()->is_superuser) {
            Core::getInstance()->error(403);
            exit();
        }
    }

    public function indexAction(): array {
        $categories = Category::getAllCategories();
        error_log("Categories count: " . count($categories));


        $isAdmin = false;
        $currentUser = User::getCurrentUser();
        if ($currentUser && $currentUser->is_superuser) {
            $isAdmin = true;
        }

        $this->addData([
            'Title' => 'Категорії товарів',
            'categories' => $categories,
            'isAdmin' => $isAdmin
        ]);

        return $this->view('category/index', $this->data);
    }

    public function addAction(): array {
        $this->checkAdminAccess();

        $errors = [];
        $values = [
            'name' => '',
            'description' => ''
        ];

        if ($this->isPost) {
            $name = trim($this->post->name ?? '');
            $description = trim($this->post->description ?? '');

            $values = [
                'name' => $name,
                'description' => $description
            ];

            if (empty($name)) {
                $errors[] = 'Назва категорії є обов\'язковою.';
            } else {
                if (Category::findOneWhere(['name' => $name])) {
                    $errors[] = 'Категорія з такою назвою вже існує.';
                }
            }


            if (empty($errors)) {
                $category = new Category();
                if ($category->saveCategory($values)) {
                //    Core::getInstance()->session->setFlash('success', 'Категорія успішно додана!');
                    header('Location: /?route=category/index');
                    exit();
                } else {
                    $errors[] = 'Не вдалося додати категорію. Спробуйте ще раз.';
                }
            }
        }

        $this->addData([
            'Title' => 'Додати категорію',
            'errors' => $errors,
            'old' => $values
        ]);

        return $this->view('category/add', $this->data);
    }

    public function editAction(int $id): array {
        $this->checkAdminAccess();

        $category = Category::getCategoryById($id);

        if (!$category) {
            Core::getInstance()->error(404);
            exit();
        }

        $errors = [];
        $values = [
            'name' => $category->name,
            'description' => $category->description
        ];

        if ($this->isPost) {
            $name = trim($this->post->name ?? '');
            $description = trim($this->post->description ?? '');

            $values = [
                'name' => $name,
                'description' => $description
            ];

            if (empty($name)) {
                $errors[] = 'Назва категорії є обов\'язковою.';
            } else {
                $existingCategory = Category::findOneWhere(['name' => $name]);
                if ($existingCategory && $existingCategory->id !== $id) {
                    $errors[] = 'Категорія з такою назвою вже існує.';
                }
            }

            if (empty($errors)) {
                if ($category->saveCategory($values)) {
                  //  Core::getInstance()->session->setFlash('success', 'Категорія успішно оновлена!');
                    header('Location: /?route=category/index');
                    exit();
                } else {
                    $errors[] = 'Не вдалося оновити категорію. Спробуйте ще раз.';
                }
            }
        }

        $this->addData([
            'Title' => 'Редагувати категорію: ' . htmlspecialchars($category->name),
            'category' => $category,
            'errors' => $errors,
            'old' => $values
        ]);

        return $this->view('category/edit', $this->data);
    }

//    public function deleteAction(int $id): void {
//        $this->checkAdminAccess(); // Перевіряємо права адміністратора
//
//        $category = Category::getCategoryById($id);
//
//        if (!$category) {
//            Core::getInstance()->error(404); // Категорію не знайдено
//            exit();
//        }
//
//        // Тут відбувається логіка видалення
//        if ($category->deleteCategory()) {
//            Core::getInstance()->session->setFlash('success', 'Категорія успішно видалена!');
//        } else {
//            // Це може статися, якщо є прив'язані продукти через ON DELETE RESTRICT
//            Core::getInstance()->session->setFlash('error', 'Не вдалося видалити категорію. Можливо, до неї прив\'язані товари.');
//        }
//
//        header('Location: /?route=categories/index');
//        exit();
//    }
}