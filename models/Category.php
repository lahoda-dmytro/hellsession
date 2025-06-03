<?php

namespace models;

use classes\Model;

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
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'name',
        'slug',
        'description',
        'created_at',
        'updated_at'
    ];


    public static function getAllCategories(): array {
        return static::all();
    }

    public static function getCategoryById(int $id): ?Category {
        return static::find($id);
    }


    public static function getCategoryBySlug(string $slug): ?Category {
        return static::findOneWhere(['slug' => $slug]);
    }

    public function saveCategory(array $data): bool {
        $this->name = trim($data['name'] ?? '');
        $this->description = trim($data['description'] ?? '');

        $baseSlug = $this->generateSlug($this->name);
        $this->slug = $this->ensureUniqueSlug($baseSlug, $this->id);

        return $this->save();
    }


//    public function deleteCategory(): bool {
//        // Перевірка на наявність прив'язаних продуктів
//        // В моделі Product потрібно буде реалізувати Product::countWhere(['category_id' => $this->id])
//        // Щоб уникнути циклічної залежності, краще викликати в контролері або через загальний метод.
//        // Наразі залишаємо перевірку на рівні бази даних через ON DELETE RESTRICT.
//        // Якщо база даних не дозволить видалити (через RESTRICT), метод save() поверне false,
//        // а помилка буде в логах БД/PHP.
//
//        // Можна додати явну перевірку, якщо у вас є Product модель:
//        // if (\models\Product::countWhere(['category_id' => $this->id]) > 0) {
//        //     // throw new \Exception("Cannot delete category: products are linked to it.");
//        //     return false; // Або поверніть помилку для відображення
//        // }
//
//        return $this->delete();
//    }


    protected function generateSlug(string $text): string {
        $text = mb_strtolower($text, 'UTF-8');
        $text = str_replace(
            ['а', 'б', 'в', 'г', 'д', 'е', 'є', 'ж', 'з', 'и', 'і', 'ї', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я'],
            ['a', 'b', 'v', 'h', 'd', 'e', 'ye', 'zh', 'z', 'y', 'i', 'yi', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', '', 'yu', 'ya'],
            $text
        );
        $text = preg_replace('/[^a-z0-9-]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }

    protected function ensureUniqueSlug(string $baseSlug, ?int $excludeId = null): string {
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $conditions = ['slug' => $slug];
            if ($excludeId !== null) {
                $conditions[] = ['id', '!=', $excludeId];
            }

            $existing = static::findOneWhere($conditions);

            if (!$existing) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $counter++;
        }
    }
}