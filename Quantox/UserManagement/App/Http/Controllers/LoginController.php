<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:13 PM
 */

namespace Quantox\UserManagement\App\Http\Controllers;


use Framework\App;
use Framework\Request;
use Framework\View;
use Quantox\AppLayer\Http\Controllers\Controller;
use Quantox\UserManagement\Domain\Services\Auth;

class LoginController extends Controller
{

    private $error;

    public function __construct()
    {
        if(!Request::isLogout()){
            if(App::make('Auth')->getUser())
                return Request::redirect('/search');
        }

    }

    public function index()
    {
        return View::make(view_path('Modules/UserManagement/login/page'));
    }

    public function login()
    {

        if (!$this->isEmailCorrect() || !$this->isPasswordCorrect())
            return View::make(view_path('Modules/UserManagement/login/page'), ['error' => $this->error], 400);


        $email = $_POST['email'];
        $pwd = $_POST['pwd'];

        /** @var Auth $authService */
        $authService = App::make(Auth::class);
        $authService->login($email, $pwd);
        if ($user = $authService->getUser()) {
            return Request::redirect('/search');
        }

        return View::make(view_path('Modules/UserManagement/login/page'),
            ['error' => $authService->getError()], 400);

    }

    private function isEmailCorrect()
    {

        if (empty($_POST['email']))
            $this->error = 'Email not exists.';

        if ($this->error)
            return false;

        if (!preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email']))
            $this->error = 'Wrong email format.';
        if ($this->error)
            return false;

        return true;
    }

    private function isPasswordCorrect()
    {
        if (!empty($_POST['pwd']))
            return true;

        $this->error = 'Password not exists.';
        return false;
    }

    public function logout(){
        App::make(Auth::class)->logout();
        Request::redirect('/');
    }


}