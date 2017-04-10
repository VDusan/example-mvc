<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:33 PM
 */

namespace Framework;


/**
 * Class View
 * @method static View make($view, $data=[], $status = 200)
 * @package Framework
 */
class View
{
    use CallStatic;

    private function make_static($view, $data = [], $status = 200)
    {
        extract($data);
        http_response_code($status);
        if(file_exists($view))
            return require $view;

        throw new \Exception('View not exists');
    }



}