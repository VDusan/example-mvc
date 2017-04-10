<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:45 PM
 */

return [

    'routes' => [
        'get@/' => \Quantox\Home\App\Http\Controllers\HomeController::class . '@index',
        'get@/login' => \Quantox\UserManagement\App\Http\Controllers\LoginController::class . '@index',
        'get@/registration' => \Quantox\UserManagement\App\Http\Controllers\RegistrationController::class . '@index',
        'post@/login' => \Quantox\UserManagement\App\Http\Controllers\LoginController::class . '@login',
        'post@/registration' => \Quantox\UserManagement\App\Http\Controllers\RegistrationController::class . '@registration',
        'get@/search' => \Quantox\UserManagement\App\Http\Controllers\SearchController::class.'@index',
        'get@/logout' => \Quantox\UserManagement\App\Http\Controllers\LoginController::class.'@logout',
    ],
    'providers' => [
        'DB' => \Framework\DB::class,
        'View' => \Framework\View::class,
        'Config' => \Framework\Config::class,
        'Request' => \Framework\Request::class,
        \Quantox\UserManagement\Domain\Repositories\UserRepository::class =>
            \Quantox\UserManagement\Infrastructure\Repositories\BasicUserRepository::class,
        "Auth" => \Quantox\UserManagement\Domain\Services\Auth::class,
    ],
    'database' => [
        'host' => '192.168.10.10',
        'user' => 'homestead',
        'pass' => 'secret',
        'db' => 'quantox',
    ],
    'app_salt' => "qwerty132",
];