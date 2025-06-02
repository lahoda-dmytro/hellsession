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

    public function registerAction(): array {
        if (User::isLoggedIn()) {
            header('Location: /?route=site/index');
            exit();
        }

        $errors = [];
        $values = [
            'first_name' => '',
            'last_name' => '',
            'username' => '',
            'email' => '',
        ];

        if ($this->isPost) {
            $firstName = trim($this->post->first_name ?? '');
            $lastName = trim($this->post->last_name ?? '');
            $username = trim($this->post->username ?? '');
            $email = trim($this->post->email ?? '');
            $password1 = $this->post->password1 ?? '';
            $password2 = $this->post->password2 ?? '';

            $values = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'email' => $email,
            ];

            if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password1) || empty($password2)) {
                $errors[] = 'All fields are required.';
            }

            if ($password1 !== $password2) {
                $errors[] = 'Passwords do not match.';
            }

            if (User::isUsernameOrEmailTaken($username, $email)) {
                $errors[] = 'Username or email already taken.';
            }

            if (empty($errors)) {
                $user = new User();
                if ($user->register([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password1
                ])) {
                    header('Location: /?route=site/index');
                    exit();
                } else {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }
        }

        $this->addData([
            'errors' => $errors,
            'old' => $values
        ]);

        return $this->view('Register', $this->data);
    }
}