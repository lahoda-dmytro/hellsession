<?php

namespace controllers;

use classes\Controller;

class UsersController extends Controller {
    public function loginAction(): array {

        return $this->view('login');
    }

}
