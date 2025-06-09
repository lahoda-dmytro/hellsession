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
                    $_SESSION['order_id'] = $order->id;

                    header('Location: /?route=payment/process');
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

    public function indexAction(): array
    {
        $this->checkAdminAccess();

        $orders = Order::findAllWhere([], ['created_at' => 'DESC']);

        $this->addData([
            'Title' => 'Управління замовленнями',
            'orders' => $orders,
            'isAdmin' => true
        ]);

        return $this->view('order/index', $this->data);
    }

    public function viewAction(int $id): array
    {
        $this->checkAdminAccess();

        $order = Order::find($id);
        if (!$order) {
            Core::getInstance()->error(404);
            exit();
        }

        $orderItems = $order->getOrderItems();
        $products = [];
        foreach ($orderItems as $item) {
            $products[$item->product_id] = Product::getById($item->product_id);
        }

        $this->addData([
            'Title' => 'Перегляд замовлення #' . $order->id,
            'order' => $order,
            'orderItems' => $orderItems,
            'products' => $products,
            'isAdmin' => true
        ]);

        return $this->view('order/view', $this->data);
    }

    public function editAction(int $id): array
    {
        $this->checkAdminAccess();

        $order = Order::find($id);
        if (!$order) {
            Core::getInstance()->error(404);
            exit();
        }

        $orderItems = $order->getOrderItems();
        $products = [];
        foreach ($orderItems as $item) {
            $products[$item->product_id] = \models\Product::getById($item->product_id);
        }

        $errors = [];
        $values = [
            'first_name' => $order->first_name,
            'last_name' => $order->last_name,
            'email' => $order->email,
            'city' => $order->city,
            'address' => $order->address,
            'postal_code' => $order->postal_code,
            'paid' => $order->paid
        ];

        if ($this->isPost) {
            $first_name = trim($this->post->first_name ?? '');
            $last_name = trim($this->post->last_name ?? '');
            $email = trim($this->post->email ?? '');
            $city = trim($this->post->city ?? '');
            $address = trim($this->post->address ?? '');
            $postal_code = trim($this->post->postal_code ?? '');
            $paid = (bool)($this->post->paid ?? false);

            $values = compact('first_name', 'last_name', 'email', 'city', 'address', 'postal_code', 'paid');

            if (empty($first_name)) $errors[] = 'Ім\'я є обов\'язковим.';
            if (empty($last_name)) $errors[] = 'Прізвище є обов\'язковим.';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Введіть коректну електронну пошту.';
            if (empty($city)) $errors[] = 'Місто є обов\'язковим.';
            if (empty($address)) $errors[] = 'Адреса є обов\'язковою.';
            if (empty($postal_code)) $errors[] = 'Поштовий індекс є обов\'язковим.';

            if (empty($errors)) {
                $order->first_name = $first_name;
                $order->last_name = $last_name;
                $order->email = $email;
                $order->city = $city;
                $order->address = $address;
                $order->postal_code = $postal_code;
                $order->paid = $paid;

                if ($order->save()) {
                    header('Location: /?route=order/view/' . $order->id);
                    exit();
                } else {
                    $errors[] = 'Не вдалося оновити замовлення.';
                }
            }
        }

        $this->addData([
            'Title' => 'Редагування замовлення #' . $order->id,
            'order' => $order,
            'orderItems' => $orderItems,
            'products' => $products,
            'errors' => $errors,
            'old' => $values,
            'isAdmin' => true
        ]);

        return $this->view('order/edit', $this->data);
    }

    public function deleteAction(int $id): void
    {
        $this->checkAdminAccess();

        $order = Order::find($id);
        if (!$order) {
            Core::getInstance()->error(404);
            exit();
        }

        OrderItem::delete(['order_id' => $order->id]);

        if (Order::delete($order->id)) {
            header('Location: /?route=order/index');
        } else {
            Core::getInstance()->error(500);
        }
    }

    private function checkAdminAccess(): void
    {
        $user = User::getCurrentUser();
        if (!$user || !$user->is_superuser) {
            Core::getInstance()->error(403);
            exit();
        }
    }

}