<?php

namespace models;

use classes\Model;

/**
 * @property int $id ID зображення продукту (Primary Key)
 * @property int $product_id ID продукту, до якого належить зображення (Foreign Key до products.id)
 * @property string $image Шлях до файлу зображення
 */
class ProductImage extends Model {

    protected string $table = 'product_images';
    protected string $primaryKey = 'id';
    protected array $fillable = ['product_id', 'image'];
}