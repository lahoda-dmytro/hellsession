<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use models\User;

class AdminController extends Controller
{

    private function checkAdminAccess(): void
    {
        $user = User::getCurrentUser();
        if (!$user || !$user->is_superuser) {
            Core::getInstance()->error(403);
            exit();
        }
    }


    public function indexAction(): array
    {
        $this->checkAdminAccess();

        $this->addData([
            'Title' => 'Admin-panel',
            'isAdmin' => true
        ]);

        return $this->view('admin/index', $this->data);
    }

}