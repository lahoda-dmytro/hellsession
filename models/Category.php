<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class Category extends Model
{
    protected string $table = 'categories';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'slug'];
}