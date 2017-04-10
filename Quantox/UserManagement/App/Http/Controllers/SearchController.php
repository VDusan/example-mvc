<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:14 PM
 */

namespace Quantox\UserManagement\App\Http\Controllers;


use Framework\App;
use Framework\Request;
use Framework\View;
use Quantox\AppLayer\Http\Controllers\Controller;
use Quantox\UserManagement\Domain\Services\Search;

class SearchController extends Controller
{

    public function __construct()
    {
        $user = App::make('Auth')->getUser();
        if(empty($user))
            Request::redirect('/');
    }

    public function index(){

        $data = [];
        if(!empty($_GET['search'])){
            $data['search'] = $_GET['search'];
            $data['users'] = App::make(Search::class)->handle($data['search']);

        }

        return View::make(view_path('Modules/Search/page'), $data);
    }



}