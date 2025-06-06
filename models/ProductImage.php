<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $image_path
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class ProductImage extends Model {
    protected string $table = 'product_images';

    protected array $fillable = ['product_id', 'image_path', 'sort_order', 'created_at', 'updated_at'];

    public static function addImage(array $data): ?ProductImage {
        $image = new self($data);
        return $image->save() ? $image : null;
    }
    public static function getImagesByProductId(int $productId): array {
        return self::where(['product_id' => $productId]);
    }
    public static function deleteImage(int $id): bool {
        return self::delete($id) > 0;
    }

    public static function updateSortOrder(int $id, int $newSortOrder): bool {
        $image = self::find($id);
        if (!$image) {
            return false;
        }
        $image->sort_order = $newSortOrder;
        return $image->save();
    }

    public static function reorderImages(int $productId, array $imageIds): bool {
        $sortOrder = 10;
        foreach ($imageIds as $id) {
            if (!self::updateSortOrder($id, $sortOrder)) {
                return false;
            }
            $sortOrder += 10;
        }
        return true;
    }
}
