<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\Cart;
use models\Order;
use models\OrderItem;
use models\User;
use models\Product;

class OrderController extends Controller
{
    public function createAction(): array
    {
        if (!User::isLoggedIn()) {
            header('Location: /?route=users/login');
            exit;
        }

        $cart = new Cart();

        if ($cart->getTotalQuantity() === 0) {
            header('Location: /?route=cart/show');
            exit;
        }

        $errors = [];
        $old_data = [];
        $user = User::getCurrentUser();

        if ($this->isPost) {
            $first_name = trim($this->post->first_name ?? '');
            $last_name = trim($this->post->last_name ?? '');
            $email = trim($this->post->email ?? '');
            $address = trim($this->post->address ?? '');
            $postal_code = trim($this->post->postal_code ?? '');
            $city = trim($this->post->city ?? '');

            $old_data = compact('first_name', 'last_name', 'email', 'address', 'postal_code', 'city');

            if (empty($first_name)) $errors[] = 'Ім\'я є обов\'язковим.';
            if (empty($last_name)) $errors[] = 'Прізвище є обов\'язковим.';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Введіть коректну електронну пошту.';
            if (empty($address)) $errors[] = 'Адреса є обов\'язковою.';
            if (empty($postal_code)) $errors[] = 'Поштовий індекс є обов\'язковим.';
            if (empty($city)) $errors[] = 'Місто є обов\'язковим.';

            if (empty($errors)) {
                // Створення замовлення
                $order_data = [
                    'user_id' => $user ? $user->id : null,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'address' => $address,
                    'postal_code' => $postal_code,
                    'city' => $city,
                    'paid' => false,
                ];

                $order = new Order($order_data);
                if ($order->save()) {
                    // Збереження товарів замовлення
                    foreach ($cart->getItems() as $item_data) {
                        $product = Product::getById($item_data['product_id']);
                        if ($product) {
                            $price_to_save = $item_data['price'];
                            (new OrderItem([
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'price' => $price_to_save,
                                'quantity' => $item_data['quantity'],
                            ]))->save();
                        }
                    }
                    $cart->clear();

                    header('Location: /?route=order/created');
                    exit;
                } else {
                    $errors[] = 'Не вдалося створити замовлення.';
                }
            }
        } else {

            if ($user) {
                $old_data['first_name'] = $user->first_name;
                $old_data['last_name'] = $user->last_name;
                $old_data['email'] = $user->email;
            }
        }

        $this->addData([
            'Title' => 'Оформити замовлення',
            'cart' => $cart,
            'form_data' => $old_data,
            'errors' => $errors,
        ]);

        return $this->view('order/create', $this->data);
    }

    public function createdAction(): array
    {
        $this->addData([
            'Title' => 'Замовлення створено',
        ]);

        return $this->view('order/created', $this->data);
    }

    // public function indexAction(): array { ... }
    // public function viewAction(int $id): array { ... }
    // public function editAction(int $id): array { ... }
    // public function deleteAction(int $id): void { ... }
} 