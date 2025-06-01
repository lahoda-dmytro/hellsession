<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\User;

class UsersController extends Controller {

    public function loginAction(): array {
        $errors = [];
        $username_input = '';

        if(User::isLoggedIn())
            header('Location: /?route=site/index');

        if ($this->isPost) {
            $username_input = $this->post->username ?? '';
            $password_input = $this->post->password ?? '';


            if (empty($username_input) || empty($password_input)) {
                $errors[] = 'Enter the username and password';
            } else {
                $userModel = new User();
                if ($userModel->login($username_input, $password_input)) {
                    header('Location: /?route=site/index');
                    exit();
                } else {
                    $errors[] = 'Incorrect username or password.';
                }
            }
        }

        $this->addData([
            'Title' => 'Login',
            'errors' => $errors,
            'username' => $username_input,
        ]);
        return $this->view('Login', $this->data);
    }

    public function logoutAction(): void {
        User::logout();
        header('Location: /?route=site/index');
        exit();
    }

    // public function registerAction(): array { ... }
}