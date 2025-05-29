<?php

namespace models;

use classes\Model;

/**
 * @property int $id  (Primary Key)
 * @property int $category_id (Foreign Key до categories.id)
 * @property string $name Назва товару
 * @property string $slug Slug товару (для використання в URL)
 * @property string $image Шлях до основного зображення товару
 * @property string $description Повний опис товару
 * @property float $price Ціна товару
 * @property bool $available Наявність товару (1 - в наявності, 0 - немає)
 * @property string $created Дата і час створення запису (автоматично оновлюється БД)
 * @property string $updated Дата і час останнього оновлення запису (автоматично оновлюється БД)
 * @property float $discount Знижка на товар у відсотках або фіксована сума
 */
class Product extends Model {
    protected string $table = 'products';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'category_id', 'name', 'slug', 'image', 'description', 'price',
        'available', 'discount'
    ];
}