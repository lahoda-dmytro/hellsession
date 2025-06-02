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

            $values = compact('firstName', 'lastName', 'username', 'email');

            // Перевірка обов'язкових полів
            if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password1) || empty($password2)) {
                $errors[] = 'All fields are required.';
            }

            // Перевірка збігу паролів
            if ($password1 !== $password2) {
                $errors[] = 'Passwords do not match.';
            }

            // Перевірка унікальності користувача
            if (User::findOneWhere(['username' => $username])) {
                $errors[] = 'Username already exists.';
            }
            if (User::findOneWhere(['email' => $email])) {
                $errors[] = 'Email already exists.';
            }

            if (User::isUsernameOrEmailTaken($username, $email)) {
                $errors[] = 'Username or email already taken.';
            }


            // Якщо немає помилок — створюємо користувача
            if (empty($errors)) {
                $user = new User();
                $user->first_name = $firstName;
                $user->last_name = $lastName;
                $user->username = $username;
                $user->email = $email;
                $user->password = password_hash($password1, PASSWORD_BCRYPT);
                $user->joined_date = date('Y-m-d H:i:s');
                $user->status = 'active';

                if ($user->save()) {
                    $user->loginUserIntoSession($user);
                    header('Location: /?route=site/index');
                    exit();
                } else {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }
        }

        $this->addData([
            'errors' => $errors,
            'username' => $values['username'],
        ]);

        return $this->view('Register', $this->data);
    }


}