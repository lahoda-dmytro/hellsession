<?php

namespace models;

use classes\Model;

/**
 * @property int $id ID категорії (Primary Key)
 * @property string $name Назва категорії
 * @property string $slug Slug категорії (для використання в URL)
 */
class Category extends Model {
    protected string $table = 'categories';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'slug'];
}