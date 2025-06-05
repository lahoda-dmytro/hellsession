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
 * @property string $price
 * @property string $discount_percentage
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

    public function __construct(array $data = []) {
        parent::__construct($data);
        // Перетворюємо decimal поля в числа
        if (isset($this->fieldArray['price'])) {
            $this->fieldArray['price'] = (float)$this->fieldArray['price'];
        }
        if (isset($this->fieldArray['discount_percentage'])) {
            $this->fieldArray['discount_percentage'] = (float)$this->fieldArray['discount_percentage'];
        }
    }

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

    public static function getProductsWithPagination(int $page = 1, int $perPage = 12, ?int $categoryId = null): array {
        $offset = ($page - 1) * $perPage;
        
        $query = "SELECT * FROM products WHERE available = 1";
        $params = [];
        
        if ($categoryId !== null) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
        }
        
        $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        $results = self::query($query, $params);
        
        $products = [];
        foreach ($results as $data) {
            $products[] = new self($data);
        }
        
        return $products;
    }

    public static function getTotalProducts(?int $categoryId = null): int {
        $query = "SELECT COUNT(*) as total FROM products WHERE available = 1";
        $params = [];
        
        if ($categoryId !== null) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
        }
        
        $result = self::query($query, $params);
        return (int)($result[0]['total'] ?? 0);
    }
}
