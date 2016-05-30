<?php

class View
{
    protected $data;

    protected $path;

    protected static function getDefaultViewPath(){
        $router = App::getRouter();
        if (!$router) {
            return false;
        }
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction();
        return $controller_dir.DS.$template_name;
    }

    public function __construct($data = [], $path = null)
    {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }
        
        $path = VIEW_PATH.DS.$path . '.html';

        if (!file_exists($path)) {
            throw new Exception('Template not found in path ' . $path );
        }
        $this->path = $path;
        $this->data = $data;
    }

    public function render()
    {
        $data = $this->data;

        ob_start();
        include $this->path;
        $content = ob_get_clean();
        return $content;
    }
}