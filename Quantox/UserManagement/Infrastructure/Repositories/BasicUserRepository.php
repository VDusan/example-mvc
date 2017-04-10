<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:15 PM
 */

namespace Quantox\UserManagement\Infrastructure\Repositories;


use Framework\DB;
use Quantox\UserManagement\Domain\Entities\User;
use Quantox\UserManagement\Domain\Repositories\UserRepository;

class BasicUserRepository implements UserRepository
{
    public function getUserByEmail($email)
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $data[':email'] = $email;
        $users = DB::select($query, $data);
        if(empty($users))
            return null;
        $user = $this->fillUser($users[0]);

        return $user;
    }

    /**
     * @param $userData
     * @return User
     */
    private function fillUser($userData)
    {
        $user = new User();
        $user->setId($userData->id);
        $user->setName($userData->name);
        $user->setEmail($userData->email);
        $user->setPassword($userData->password);
        return $user;
    }

    public function searchUsersByEmailAndName($attr)
    {
        if(empty($attr)){
            $query = 'SELECT * FROM users';
            $data = [];
        }else{
            $query = 'SELECT * FROM users WHERE email LIKE :email OR name LIKE :name ';
            $data[':email'] = '%'.$attr.'%';
            $data[':name'] = '%'.$attr.'%';
        }

        $usersData = DB::select($query, $data);

        $users = [];
        foreach ($usersData as $userData)
            $users[] = $this->fillUser($userData);


        return $users;
    }

    public function saveUser(User $user)
    {
        $data[':email'] = $user->getEmail();
        $data[':password'] = $user->getPassword();
        $data[':name'] = $user->getName();
        $query = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";

        return DB::insert($query, $data);

    }
}