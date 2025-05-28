<?php

namespace classes;

class Controller {
    public Template $template;
    protected array $data = [];

    function __construct(){
        $module = Core::getInstance()->module;
        $action = Core::getInstance()->action;
        $this->template = new Template("views/{$module}/{$action}.php");

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