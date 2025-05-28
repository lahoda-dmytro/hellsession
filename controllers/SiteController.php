<?php

namespace controllers;

use classes\Controller;

class SiteController extends Controller {
    public function indexAction() {
        return $this->view('Home');
    }
}