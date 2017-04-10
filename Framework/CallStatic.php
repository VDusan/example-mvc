<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 2:34 PM
 */

namespace Framework;


/**
 * Class CallStatic
 * @package Framework
 */
trait CallStatic
{
    /**
     * @var mixed
     */
    private static $instance;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    static public function __callStatic($name, $arguments)
    {
        if(method_exists(__CLASS__,$name.'_static')){
            if(!isset(self::$instance)){
                $class = __CLASS__;
                self::$instance = new $class();
            }
            return call_user_func_array([self::$instance, $name.'_static'],$arguments);
        }
        throw new \Exception('Method '.$name.' not exists in '.__CLASS__);
    }
}