<?php

namespace controllers;

use classes\Controller;
use models\User;

class UsersController extends Controller {
    public function loginAction(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // User::where повертає масив моделей, тому беремо перший елемент або null
            $users = User::where(['username' => $username]);
            $user = $users[0] ?? null;


            //password_verify($password, $user->password
            if ($user && $password === $user->password) {
                // Записуємо user_id в сесію (припустимо, сесія доступна через Core)
                \classes\Core::getInstance()->session->set('user_id', $user->id);

                return $this->view('Логін успішний', ['user' => $user]);
            } else {
                return $this->view('Логін', ['error' => 'Неправильний логін або пароль']);
            }
        }

        return $this->view('Логін');
    }
}
