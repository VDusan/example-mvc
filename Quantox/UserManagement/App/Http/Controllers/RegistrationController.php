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

class RegistrationController extends Controller
{
    private $error;

    public function index(){
        return View::make(view_path('Modules/UserManagement/registration/page'));
    }

    /**
     * @return View
     */
    public function registration(){

        $data = $_POST;
        if (!$this->isEmailCorrect() || !$this->isPasswordCorrect()){
            $data['error'] = $this->error;
            return View::make(view_path('Modules/UserManagement/registration/page'), $data, 400);
        }

        /** @var Auth $authService */
        $authService = App::make(Auth::class);
        $authService->registration($data);

        if($error = $authService->getError()){
            $data['error'] = $error;
            return View::make(view_path('Modules/UserManagement/registration/page'), $data, 400);
        }


        return Request::redirect('/login');
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
        if (!empty($_POST['pwd']) && !empty($_POST['pwdCnf']) && $_POST['pwd'] == $_POST['pwdCnf']){
            return true;
        }

        $this->error = 'Problem with password.';
        return false;
    }


}