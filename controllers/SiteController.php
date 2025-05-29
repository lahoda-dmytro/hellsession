<?php

namespace controllers;

use classes\Controller;
use classes\Core;

class SiteController extends Controller {
    public function indexAction(): array {
        $core = Core::getInstance();
        $db = $core->db;

        //$categories = $db->insert('categories', ['name' => 'Necklaces', 'slug'=>'necklaces']);
        //$categories = $db->select('categories', ['id', 'name']);
        //$categories = $db->select('categories', ['id', 'name'], ['id' => 3]);
        $categories = $db->delete('categories', ['id' => 3]);

        if (empty($categories)) {
            $this->addData(['message' => 'Не знайдено жодної категорії.']);
        } else {
            $this->addData(['categories' => $categories]);
        }

        return $this->view('Список Категорій', $this->data);
    }

}