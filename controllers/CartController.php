<?php

namespace controllers;

use models\Cart;
use models\Product;
use classes\Core;
use classes\Controller;

class CartController extends Controller {
    private $cart;

    public function __construct() {
        parent::__construct();
        $this->cart = new Cart();
    }

    public function addAction(string $slug): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=users/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'] ?? 1;
            $override = $_POST['override'] ?? false;

            $product = Product::getBySlug($slug);
            if ($product) {
                $price_to_add = $product->price;
                if ($product->discount_percentage > 0) {
                    $price_to_add = $product->price * (1 - $product->discount_percentage / 100);
                }
                $this->cart->add($product->id, $price_to_add, $quantity, $override);
            }
        }
        
        header('Location: /?route=cart/show');
        exit;
    }

    public function removeAction(string $slug): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=users/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = Product::getBySlug($slug);
            if ($product) {
                $this->cart->remove($product->id);
            }
        }
        
        header('Location: /?route=cart/show');
        exit;
    }

    public function showAction(): array {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=users/login');
            exit;
        }

        $items = $this->cart->getItems();
        $total = $this->cart->getTotalPrice();
        
        $this->addData([
            'Title' => 'Кошик',
            'items' => $items,
            'total' => $total
        ]);

        return $this->view('cart/index', $this->data);
    }

    public function clearAction(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=users/login');
            exit;
        }

        $this->cart->clear();
        header('Location: /?route=cart/show');
        exit;
    }
} 