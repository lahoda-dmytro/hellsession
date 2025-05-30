<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $image
 */
class ProductImage extends Model {
    protected string $table = 'product_images';
    protected string $primaryKey = 'id';
    protected array $fillable = ['product_id', 'image'];
}