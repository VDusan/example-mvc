<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:18 PM
 */

namespace Quantox\UserManagement\Domain\Services;


use Framework\App;
use Quantox\UserManagement\Domain\Repositories\UserRepository;

class Search
{
    public function __construct()
    {
        $this->userRepository = App::make(UserRepository::class);
    }

    public function handle($searchAttr)
    {
        return $this->userRepository->searchUsersByEmailAndName($searchAttr);
    }

}