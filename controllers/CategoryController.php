<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\Category;
use models\User;

class CategoryController extends Controller
{
    private function checkAdminAccess(): void
    {
        $user = User::getCurrentUser();
        if (!$user || !$user->is_superuser) {
            Core::getInstance()->error(403);
            exit();
        }
    }

    public function indexAction(): array
    {
        $this->checkAdminAccess();
        $categories = Category::getCategories();

        $this->addData([
            'Title' => 'Категорії товарів',
            'categories' => $categories,
            'isAdmin' => User::getCurrentUser()?->is_superuser ?? false
        ]);

        return $this->view('category/index', $this->data);
    }

    public function addAction(): array
    {
        $this->checkAdminAccess();

        $errors = [];
        $values = ['name' => '', 'description' => ''];

        if ($this->isPost) {
            $name = trim($this->post->name ?? '');
            $description = trim($this->post->description ?? '');
            $slug = strtolower(str_replace(' ', '-', $name));
            $values = compact('name', 'description', 'slug');

            if (empty($name)) {
                $errors[] = 'Назва категорії є обов\'язковою.';
            } elseif (Category::findOneWhere(['name' => $name])) {
                $errors[] = 'Категорія з такою назвою вже існує.';
            }

            if (empty($errors)) {
                $category = Category::addCategory($values);
                if ($category) {
                    header('Location: /?route=category/index');
                    exit();
                } else {
                    $errors[] = 'Не вдалося додати категорію.';
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

    public function editAction(string $slug): array
    {
        $this->checkAdminAccess();

        $category = Category::findOneWhere(['slug' => $slug]);
        if (!$category) {
            Core::getInstance()->error(404);
            exit();
        }

        $errors = [];
        $values = ['name' => $category->name, 'description' => $category->description];

        if ($this->isPost) {
            $name = trim($this->post->name ?? '');
            $description = trim($this->post->description ?? '');
            $slug = strtolower(str_replace(' ', '-', $name));
            $values = compact('name', 'description', 'slug');

            if (empty($name)) {
                $errors[] = 'Назва категорії є обов\'язковою.';
            } else {
                $existing = Category::findOneWhere(['name' => $name]);
                if ($existing && $existing->id != $category->id) {
                    $errors[] = 'Інша категорія з такою назвою вже існує.';
                }
            }

            if (empty($errors)) {
                if (Category::updateCategory($category->id, $values)) {
                    header('Location: /?route=category/index');
                    exit();
                } else {
                    $errors[] = 'Не вдалося оновити категорію.';
                }
            }
        }

        $this->addData([
            'category_id' => $category->id,
            'category' => $category,
            'errors' => $errors,
            'old' => $values
        ]);

        $viewData = $this->data;
        unset($viewData['Title']);

        return $this->view(
            'Редагувати категорію: ' . htmlspecialchars($category->name),
            $viewData
        );
    }

    public function deleteAction(string $slug): void
    {
        $this->checkAdminAccess();

        $category = Category::findOneWhere(['slug' => $slug]);
        if (!$category) {
            Core::getInstance()->error(404);
            exit();
        }

        if (Category::deleteCategory($category->id)) {
            header('Location: /?route=category/index');
        } else {
            Core::getInstance()->error(500);
        }
    }

}
