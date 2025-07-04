<?php

namespace models;

class Cart {
    private $session;
    private $cart;

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->session = &$_SESSION;
        if (!isset($this->session['cart'])) {
            $this->session['cart'] = [];
        }
        $this->cart = &$this->session['cart'];
    }

    public function add($product_id, $price, $quantity = 1, $override_quantity = false) {
        $product_id_key = (string)$product_id;

        if (!isset($this->cart[$product_id_key])) {
            $this->cart[$product_id_key] = [
                'quantity' => 0,
                'price' => (float)$price
            ];
        }

        if ($override_quantity) {
            $this->cart[$product_id_key]['quantity'] = (int)$quantity;
        } else {
            $this->cart[$product_id_key]['quantity'] += (int)$quantity;
        }

        if ($this->cart[$product_id_key]['quantity'] < 0) {
            $this->cart[$product_id_key]['quantity'] = 0;
        }
        $this->save();
    }

    public function save() {
        $this->session['cart'] = $this->cart;
    }

    public function remove($product_id) {
        $product_id_key = (string)$product_id;
        if (isset($this->cart[$product_id_key])) {
            unset($this->cart[$product_id_key]);
            $this->save();
        }
    }

    public function getItems() {
        $items_with_product_data = [];
        foreach ($this->cart as $product_id_str => $item) {
            $product = Product::getById((int)$product_id_str);
            if ($product) {
                $items_with_product_data[] = [
                    'product_id' => (int)$product_id_str,
                    'quantity' => (int)$item['quantity'],
                    'price' => (float)$item['price'],
                    'product_data' => $product
                ];
            } else {
                $this->remove((int)$product_id_str);
            }
        }
        return $items_with_product_data;
    }

    public function getTotalQuantity() {
        $total = 0;
        if (isset($this->cart) && is_array($this->cart)) {
            $total = array_sum(array_column($this->cart, 'quantity'));
        }
        return $total > 0 ? $total : 0;
    }

    public function clear() {
        $this->cart = [];
        $this->save();
    }

    public function getTotalPrice() {
        $total = 0;
        if (isset($this->cart) && is_array($this->cart)) {
            foreach ($this->cart as $item) {
                $total += (float)$item['price'] * (int)$item['quantity'];
            }
        }
        return number_format($total, 2, '.', '');
    }
}