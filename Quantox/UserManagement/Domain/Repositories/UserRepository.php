<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:16 PM
 */

namespace Quantox\UserManagement\Domain\Repositories;


use Quantox\UserManagement\Domain\Entities\User;

interface UserRepository
{

    public function getUserByEmail($email);

    public function searchUsersByEmailAndName($attr);

    public function saveUser(User $user);

}