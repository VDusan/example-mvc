<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:17 PM
 */

namespace Quantox\UserManagement\Domain\Services;


use Framework\App;
use Framework\Config;
use Quantox\UserManagement\Domain\Entities\User;
use Quantox\UserManagement\Domain\Repositories\UserRepository;

class Auth
{
    private $user;
    private $error;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->userRepository = App::make(UserRepository::class);
    }

    /**
     * @param $email
     * @param $password
     */
    public function login($email, $password)
    {
        $password = crypt($password, Config::get('app_salt'));

        /** @var User $user */
        $user = $this->userRepository->getUserByEmail($email);

        if (empty($user) || $user->getPassword() != $password) {
            $this->error = 'Wrong credentials';
            return;
        }
        $this->setAuthenticateUser($user);

    }

    public function getUser()
    {
        if ($this->user)
            return $this->user;

        if (!isset($_SESSION)) {
            session_start();
        }

        if (empty($_SESSION["email"]))
            return null;

        $user = $this->userRepository->getUserByEmail($_SESSION["email"]);
        $this->user = $user;
        return $user;
    }

    public function getError()
    {
        return $this->error;
    }

    private function setAuthenticateUser(User $user)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["email"] = $user->getEmail();
    }

    public function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if(isset($_SESSION["email"]))
            unset($_SESSION["email"]);
    }

    public function registration($data)
    {
        $user = $this->userRepository->getUserByEmail($data['email']);
        if($user){
            $this->error = 'User exists.';
            return;
        }
        $password = crypt($data['pwd'], Config::get('app_salt'));

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($password);

        if($this->userRepository->saveUser($user) != true)
            $this->error = 'Something went wrong!';

    }

}