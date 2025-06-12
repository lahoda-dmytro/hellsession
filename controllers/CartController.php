<?php

namespace controllers;

use models\Cart;
use models\Product;
use classes\Core;
use classes\Controller;
use classes\JsonResponse;

class CartController extends Controller {
    private $cart;

    public function __construct() {
        parent::__construct();
        $this->cart = new Cart();
    }
    public function addAjaxAction(): void {
        if (!isset($_SESSION['user_id'])) {
            JsonResponse::error('Будь ласка, увійдіть, щоб додати товари до кошика.', 401, ['redirect' => '/?route=users/login']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_contains($_SERVER['CONTENT_TYPE'], 'application/json')) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $productId = $data['productId'] ?? null;
            $quantity = $data['quantity'] ?? 1;

            if (!$productId || !is_numeric($productId) || $quantity < 1) {
                JsonResponse::error('Невірні дані товару або кількість.', 400);
            }

            $product = Product::getById($productId);
            if (!$product) {
                JsonResponse::error('Товар не знайдено.', 404);
            }

            $price_to_add = $product->price;
            if ($product->discount_percentage > 0) {
                $price_to_add = $product->price * (1 - $product->discount_percentage / 100);
            }

            $this->cart->add($product->id, $price_to_add, $quantity);

            $cartItems = $this->cart->getItems();
            $currentProductQuantityInCart = 0;
            $currentProductPriceInCart = 0;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $product->id) {
                    $currentProductQuantityInCart = $item['quantity'];
                    $currentProductPriceInCart = (float)$item['price'] * $item['quantity'];
                    break;
                }
            }

            JsonResponse::success('Товар успішно додано до кошика!', [
                'cartTotalQuantity' => $this->cart->getTotalQuantity(),
                'cartTotalPrice' => $this->cart->getTotalPrice(),
                'productId' => $product->id,
                'newProductQuantity' => $currentProductQuantityInCart,
                'newProductUnitPrice' => number_format($price_to_add, 2, '.', ''),
                'action' => 'updated'
            ]);

        } else {
            JsonResponse::error('Невірний метод запиту або тип вмісту.', 405);
        }
    }

    public function updateQuantityAjaxAction(): void {
        if (!isset($_SESSION['user_id'])) {
            JsonResponse::error('Будь ласка, увійдіть, щоб змінити кошик.', 401, ['redirect' => '/?route=users/login']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_contains($_SERVER['CONTENT_TYPE'], 'application/json')) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $productId = $data['productId'] ?? null;
            $quantity = $data['quantity'] ?? null;

            if (!$productId || !is_numeric($productId) || !is_numeric($quantity) || $quantity < 0) {
                JsonResponse::error('Невірні дані товару або кількість.', 400);
            }

            $product = Product::getById($productId);
            if (!$product) {
                JsonResponse::error('Товар не знайдено.', 404);
            }

            if ($quantity == 0) {
                $this->cart->remove($product->id);
                JsonResponse::success('Товар видалено з кошика.', [
                    'cartTotalQuantity' => $this->cart->getTotalQuantity(),
                    'cartTotalPrice' => $this->cart->getTotalPrice(),
                    'productId' => $product->id,
                    'action' => 'removed'
                ]);
            } else {
                $price_to_add = $product->price;
                if ($product->discount_percentage > 0) {
                    $price_to_add = $product->price * (1 - $product->discount_percentage / 100);
                }
                $this->cart->add($product->id, $price_to_add, $quantity, true);

                JsonResponse::success('Кількість товару оновлено.', [
                    'cartTotalQuantity' => $this->cart->getTotalQuantity(),
                    'cartTotalPrice' => $this->cart->getTotalPrice(),
                    'productId' => $product->id,
                    'newProductQuantity' => $quantity,
                    'newProductPrice' => number_format($price_to_add, 2, '.', ''),
                    'action' => 'updated'
                ]);
            }

        } else {
            JsonResponse::error('Невірний метод запиту або тип вмісту.', 405);
        }
    }

    public function removeAjaxAction(): void {
        if (!isset($_SESSION['user_id'])) {
            JsonResponse::error('Будь ласка, увійдіть, щоб змінити кошик.', 401, ['redirect' => '/?route=users/login']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_contains($_SERVER['CONTENT_TYPE'], 'application/json')) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $productId = $data['productId'] ?? null;

            if (!$productId || !is_numeric($productId)) {
                JsonResponse::error('Невірний ID товару.', 400);
            }

            $product = Product::getById($productId);

            $this->cart->remove($productId);

            JsonResponse::success('Товар успішно видалено з кошика.', [
                'cartTotalQuantity' => $this->cart->getTotalQuantity(),
                'cartTotalPrice' => $this->cart->getTotalPrice(),
                'productId' => $productId,
                'action' => 'removed'
            ]);

        } else {
            JsonResponse::error('Невірний метод запиту або тип вмісту.', 405);
        }
    }

    public function clearAjaxAction(): void {
        if (!isset($_SESSION['user_id'])) {
            JsonResponse::error('Будь ласка, увійдіть, щоб очистити кошик.', 401, ['redirect' => '/?route=users/login']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cart->clear();
            JsonResponse::success('Кошик успішно очищено.', [
                'cartTotalQuantity' => 0,
                'cartTotalPrice' => '0.00',
                'action' => 'cleared'
            ]);
        } else {
            JsonResponse::error('Невірний метод запиту.', 405);
        }
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

        return $this->view('cart/show', $this->data);
    }
}