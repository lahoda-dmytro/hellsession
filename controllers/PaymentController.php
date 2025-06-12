<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\Order;

require_once 'vendor/autoload.php';

class PaymentController extends Controller
{
    private $stripeSecretKey = '';

    public function processAction(): array
    {
        if (!isset($_SESSION['order_id'])) {
            header('Location: /?route=cart/show');
            exit;
        }

        \Stripe\Stripe::setApiKey($this->stripeSecretKey);

        $orderId = $_SESSION['order_id'];
        $order = Order::find($orderId);

        if (!$order || $order->paid) {
            header('Location: /?route=order/created');
            exit;
        }

        $orderItems = $order->getOrderItems();
        $line_items = [];
        $total_amount = 0;

        foreach ($orderItems as $item) {
            $product = \models\Product::getById($item->product_id);
            if ($product) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                        ],
                        'unit_amount' => (int)($item->price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
                $total_amount += $item->price * $item->quantity;
            }
        }

        if (empty($line_items)) {
            Core::getInstance()->error(500);
            exit;
        }

        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => 'http://hellsession/?route=payment/success&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://hellsession/?route=payment/cancel',
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);
            exit;

        } catch (\Error $e) {
            error_log("Error creating checkout session: " . $e->getMessage());
            $this->addData([
                'Title' => 'Помилка оплати',
                'error' => $e->getMessage(),
            ]);
            return $this->view('payment/error', $this->data);
        }
    }

    public function successAction(): array
    {
        \Stripe\Stripe::setApiKey($this->stripeSecretKey);

        $sessionId = $this->get->session_id ?? null;

        if (!$sessionId) {
            header('Location: /?route=cart/show');
            exit;
        }

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && !$order->paid) {
                    $order->paid = true;
                    $order->save();
                    unset($_SESSION['order_id']);
                }
            }

            $this->addData([
                'Title' => 'Оплата успішна',
                'message' => 'Ваше замовлення успішно оплачено!',
                'orderId' => $orderId
            ]);

            return $this->view('payment/success', $this->data);

        } catch (\Exception $e) {
            error_log("Error retrieving checkout session or updating order: " . $e->getMessage());
            $this->addData([
                'Title' => 'Помилка оплати',
                'error' => 'Помилка обробки успішної оплати: ' . $e->getMessage(),
            ]);
            return $this->view('payment/error', $this->data);
        }
    }

    public function cancelAction(): array
    {
        $this->addData([
            'Title' => 'Оплата скасована',
            'message' => 'Оплату скасовано. Спробуйте ще раз або зверніться до підтримки.',
        ]);
        return $this->view('payment/cancel', $this->data);
    }
} 