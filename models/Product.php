<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property string $description
 * @property float $price
 * @property bool $available
 * @property string $created
 * @property string $updated
 * @property float $discount
 */
class Product extends Model {
    protected string $table = 'products';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'category_id', 'name', 'slug', 'image', 'description', 'price',
        'available', 'discount'
    ];
}