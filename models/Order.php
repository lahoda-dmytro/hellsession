<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $city
 * @property string $address
 * @property string $postal_code
 * @property string $created_at
 * @property string $updated_at
 * @property bool $paid
 * @property string|null $stripe_id
 */
class Order extends Model
{
    protected string $table = 'orders';
    protected array $fillable = [
        'user_id', 'first_name', 'last_name', 'email',
        'city', 'address', 'postal_code', 'paid', 'stripe_id'
    ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->fieldArray['paid'] = (bool)($this->fieldArray['paid'] ?? false);
    }

    public function getOrderItems(): array
    {
        return OrderItem::where(['order_id' => $this->id]);
    }

    public function getTotalCost(): float
    {
        $total_cost = 0.0;
        foreach ($this->getOrderItems() as $item) {
            $total_cost += $item->getCost();
        }
        return $total_cost;
    }
} 