<?php

class App
{
    protected static $router;

    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($url)
    {
        self::$router = new Router($url);

        $controller_class = ucfirst(self::$router->getController()) . 'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        // Calling controller's method
        $controller_obj = new $controller_class();
        if (method_exists($controller_obj, $controller_method)) {
            //Controllers action may return a view path
            $view_path = $controller_obj->$controller_method();
            $view_obj = new View($controller_obj->getData(), $view_path);
            $content = $view_obj->render();
        } else {
            throw new Exception('Method ' . $controller_method . ' of class ' . $controller_class . ' does not exist');
        }

        if ($controller_obj->useLayout() !== false) {
            // Select layout
            $layout = Config::get('routes')[self::$router->getRoute()] . "default"; // !!
            $layout_path = $layout;
            $layout_view_obj = new View(compact('content'), $layout_path);
            echo $layout_view_obj->render();
        } else {
            echo $content;
        }
    }

    
}