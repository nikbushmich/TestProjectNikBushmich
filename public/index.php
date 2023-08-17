<?php
session_start();

require_once dirname(__DIR__).'/src/autoload.php';
include __DIR__.'/../src/start.php';

$routes = [
    '/profile' => '/templates/profile.view.php',
    '/updatePassword' => '/templates/updatePassword.view.php',
    '/login' => '/templates/login.view.php',
    '/registration' => '/templates/register.view.php',
    '/' => '/templates/register.view.php',

    '/logout' => '/src/Controller/logout.php',
    '/updatePass' => '/src/Controller/updatePassword.php',
    '/register' => '/src/Controller/register.php',
    '/updateProfile' => '/src/Controller/updateProfile.php',
    '/authorization' => '/src/Controller/authorization.php',

];

$route = $_SERVER['REQUEST_URI'];

if (array_key_exists($route, $routes)) {
    include __DIR__. '/..'.$routes[$route];
} else {
    include __DIR__. '/../templates/404.view.php';
}


