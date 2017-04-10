<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:32 PM
 */

namespace Framework;


/**
 * Class App
 * @method static App make($name)
 * @package Framework
 */
class App
{
    /**
     * @var
     */
    private static $instance;


    /**
     *
     */
    private function handle()
    {
        $uri = Request::getUri();
        $method = Request::getMehod();
        $route = strtolower($method.'@'.$uri);
        $routes = Config::get('routes');

        if (isset($routes[$route]))
            return $this->handleController($routes[$route]);

        return View::make(view_path('404'), [], 404);

    }

    /**
     *
     */
    private function make_static($name)
    {
        if(class_exists($name))
            return new $name();

        $providers = Config::get('providers');
        if(isset($providers[$name]) and class_exists($providers[$name]))
            return new $providers[$name]();

        throw new \Exception('Implementation of '.$name.' not exists.');
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    static public function __callStatic($name, $arguments)
    {
        if ($name == 'handle') {
            if (isset(self::$instance))
                throw new \Exception('Method can\t be used.');
            self::$instance = new App();
            return call_user_func_array([self::$instance, $name], $arguments);
        }

        if (!isset(self::$instance))
            throw new \Exception('Application is not started.');

        if (method_exists(__CLASS__, $name.'_static')) {
            return call_user_func_array([self::$instance, $name.'_static'], $arguments);
        }
        throw new \Exception('Method ' . $name . ' not exists in ' . __CLASS__);
    }

    /**
     * @param $routeMethod
     * @return mixed
     * @throws \Exception
     */
    private function handleController($routeMethod)
    {
        $arrgs =  explode('@',$routeMethod,2);
        if(!isset($arrgs[0]))
            throw new \Exception('Route controller not exists.');

        $controller = App::make($arrgs[0]);

        if(!method_exists($arrgs[0],$arrgs[1]))
            throw new \Exception('Controller method not exists.');

        return call_user_func( [ $controller, $arrgs[1] ]);

    }

}