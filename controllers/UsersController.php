<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\User;
use models\Order;

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

    public function profileAction(): array
    {
        if (!User::isLoggedIn()) {
            header('Location: /?route=users/login');
            exit();
        }

        $user = User::getCurrentUser();
        $errors = [];
        $form_data = [];

        if ($this->isPost) {
            $post_data = $this->post;

            $form_data = [
                'first_name' => trim($post_data->first_name ?? ''),
                'last_name' => trim($post_data->last_name ?? ''),
                'username' => trim($post_data->username ?? ''),
                'email' => trim($post_data->email ?? ''),
            ];

            if (empty($form_data['first_name'])) {
                $errors[] = 'First Name is required.';
            }
            if (empty($form_data['last_name'])) {
                $errors[] = 'Last Name is required.';
            }
            if (empty($form_data['username'])) {
                $errors[] = 'Username is required.';
            }
            if (empty($form_data['email'])) {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format.';
            }

            if (empty($errors)) {
                $existingUserByUsername = User::findOneWhere(['username' => $form_data['username']]);
                if ($existingUserByUsername && $existingUserByUsername->id !== $user->id) {
                    $errors[] = 'This username is already taken.';
                }

                $existingUserByEmail = User::findOneWhere(['email' => $form_data['email']]);
                if ($existingUserByEmail && $existingUserByEmail->id !== $user->id) {
                    $errors[] = 'This email is already taken.';
                }
            }

            if (empty($errors)) {
                $user->first_name = $form_data['first_name'];
                $user->last_name = $form_data['last_name'];
                $user->username = $form_data['username'];
                $user->email = $form_data['email'];

                if ($user->save()) {
                    if ($user->username !== Core::getInstance()->session->get('username')) {
                        Core::getInstance()->session->set('username', $user->username);
                    }
                    header('Location: /?route=users/profile&message=Profile updated successfully!');
                    exit();
                } else {
                    $errors[] = 'Failed to save profile changes.';
                }
            }
        } else {
            $form_data = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
            ];
        }

        $orders = Order::findAllWhere(['user_id' => $user->id], ['created_at' => 'DESC']);

        $this->addData([
            'user' => $user,
            'orders' => $orders,
            'form_data' => $form_data,
            'errors' => $errors,
            'message' => $this->get->message
        ]);

        return $this->view('Profile', $this->data);
    }
}