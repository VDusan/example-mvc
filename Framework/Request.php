<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:49 PM
 */

namespace Framework;


/**
 * Class Request
 * @method static Request getUri()
 * @package Framework
 */
class Request
{
    use CallStatic;

    public static function getMehod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function redirect($string = '')
    {


        return header("Location: ".$string);
    }

    public static function isLogout()
    {
        return self::getUri()=='/logout';
    }

    /**
     * @return mixed
     */
    private function getUri_static()
    {
        return explode('?',$_SERVER['REQUEST_URI'],2)[0];
    }
}