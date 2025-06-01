<?php

namespace classes;

class Controller {
    public Template $template;
    protected array $data = [];
    public bool $isGet = false;
    public bool $isPost = false;

    public Post $post;
    public Get $get;

    function __construct(){
        $module = Core::getInstance()->module;
        $action = Core::getInstance()->action;
        $this->template = new Template("views/{$module}/{$action}.php");

        switch ($_SERVER["REQUEST_METHOD"]) {
            case 'GET':
                $this->isGet = true;
                break;
            case 'POST':
                $this->isPost = true;
                break;
        }

        $this->post = new Post();
        $this->get = new Get();
    }

    protected function addData(array $params): void{
        $this->data = array_merge($this->data, $params);
    }

    public function view(string $title, array $extraData = []): array{
        $this->addData(['Title' => $title]);
        $this->addData($extraData);

        $this->template->addParams($this->data);

        return [
            "Title" => $title,
            "Content" => $this->template->render(),
        ];
    }
}