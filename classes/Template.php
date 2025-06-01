<?php

namespace classes;

class Template {
    protected array $params = [];
    protected string $template_filepath;

    public function __construct(string $filepath) {
        $this->template_filepath = $filepath;
    }

    public function addParam(string $name, mixed $value): void {
        $this->params[$name] = $value;
    }

    public function addParams(array $params): void {
        $this->params = array_merge($this->params, $params);
    }

    public function getParams(): array {
        return $this->params;
    }

    public function getParam(string $name): mixed {
        return $this->params[$name] ?? null;
    }

    public function clearParams(): void {
        $this->params = [];
    }

    public function setTemplateFilePath(string $filepath): void {
        $this->template_filepath = $filepath;
    }

    public function render(): string {
        if (!file_exists($this->template_filepath)) {
            throw new \RuntimeException("Template file not found: {$this->template_filepath}");
        }

        extract($this->params);
        ob_start();
        include $this->template_filepath;
        return ob_get_clean();
    }

    public function display(): void {
        echo $this->render();
    }
}
