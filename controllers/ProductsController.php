<?php

namespace controllers;

use classes\Template;

class ProductsController
{
    public function listAction(){
        $tpl = new Template("views/products/list.php");
        return [
            'Title'=>'Products list',
            'Content'=>$tpl->render()
        ];
    }
    public function addAction(){

    }

}