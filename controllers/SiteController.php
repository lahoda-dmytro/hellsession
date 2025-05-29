<?php

namespace controllers;

use classes\Controller;
use classes\Core;

class SiteController extends Controller {
    public function indexAction(): array {
        $core = Core::getInstance();
        $db = $core->db;

        $categories = $db->select('categories', ['id', 'name']);

        if (empty($categories)) {
            $this->addData(['message' => 'Не знайдено жодної категорії.']);
        } else {
            $this->addData(['categories' => $categories]);
        }

        return $this->view('Список Категорій', $this->data);
    }
}