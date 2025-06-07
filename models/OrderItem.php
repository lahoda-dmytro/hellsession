<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $price
 * @property int $quantity
 */
class OrderItem extends Model
{
    protected string $table = 'order_items';
    protected array $fillable = [
        'order_id', 'product_id', 'price', 'quantity'
    ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->fieldArray['price'] = (float)($this->fieldArray['price'] ?? 0.0);
        $this->fieldArray['quantity'] = (int)($this->fieldArray['quantity'] ?? 1);
    }

    public function getCost(): float
    {
        return $this->price * $this->quantity;
    }

    public function getProduct(): ?Product
    {
        return Product::getById($this->product_id);
    }
} 