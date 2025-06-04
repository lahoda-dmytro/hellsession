<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $short_description
 * @property float $price
 * @property float $discount_percentage
 * @property int $available
 * @property string|null $main_image
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends Model {
    protected string $table = 'products';
    protected array $fillable = [
        'category_id', 'name', 'slug', 'description', 'short_description',
        'price', 'discount_percentage', 'available', 'main_image', 'created_at', 'updated_at'
    ];

    public static function addProduct(array $data): ?Product {
        $product = new self($data);
        return $product->save() ? $product : null;
    }
    public static function updateProduct(int $id, array $data): bool {
        $product = self::find($id);
        if ($product) {
            foreach ($data as $key => $value) {
                $product->$key = $value;
            }
            return $product->save();
        }
        return false;
    }
    public static function deleteProduct(int $id): bool {
        return self::delete($id) > 0;
    }
    public static function getProductById(int $id): ?Product {
        return self::find($id);
    }
    public static function getAll(): array {
        return self::all();
    }
    public static function getById(int $id): ?Product
    {
        return self::find($id);
    }
}
