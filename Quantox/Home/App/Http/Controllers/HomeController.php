<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:20 PM
 */

namespace Quantox\Home\App\Http\Controllers;


use Framework\View;
use Quantox\AppLayer\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return View::make(view_path('Modules/Home/page'));
    }

}