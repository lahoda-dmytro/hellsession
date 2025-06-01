<?php

namespace controllers;

use classes\Controller;
use classes\Core;

class SiteController extends Controller {
    public function indexAction(): array {
        //var_dump($_SESSION);


        $this->addData(['message' => 'welcome to main page']);
        $this->addData(['title' => 'hell session']);


        return $this->view('main page', $this->data);
    }

}