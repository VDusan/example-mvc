<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 2:39 PM
 */

function base_path(){
    return __DIR__.'/../..';
}

function view_path($file = null){
    if(empty($file))
        return base_path().'/Views';
    return base_path().'/Views'.'/'.$file.'.php';

}