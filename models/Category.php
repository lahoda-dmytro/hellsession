<?php

namespace models;

use classes\Model;
use classes\Core;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends Model {
    protected string $table = 'categories';
    protected array $fillable = ['name', 'slug', 'description', 'created_at', 'updated_at'];

    public static function addCategory(array $data): ?Category {
        $category = new self($data);
        if ($category->save()) {
            return $category;
        }
        return null;
    }

    public static function getCategoryById(int $id): ?Category {
        return self::find($id);
    }

    public static function deleteCategory(int $id): bool {
        return self::delete($id) > 0;
    }

    public static function updateCategory(int $id, array $data): bool {
        $category = self::find($id);
        if ($category) {
            foreach ($data as $key => $value) {
                $category->$key = $value;
            }
            return $category->save();
        }
        return false;
    }

    public static function getCategories(): array {
        return self::all();
    }

}
