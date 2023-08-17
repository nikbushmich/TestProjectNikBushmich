<?php
session_start();
//var_dump($_POST);die;
require_once dirname(__DIR__).'/app/autoload.php';
include __DIR__.'/../app/start.php';

$routes = [
    '/profile' => '/templates/profile.view.php',
    '/updatePassword' => '/templates/updatePassword.view.php',
    '/login' => '/templates/login.view.php',
    '/registration' => '/templates/register.view.php',
    '/' => '/templates/register.view.php',

    '/logout' => '/app/Controller/logout.php',
    '/updatePass' => '/app/Controller/updatePassword.php',
    '/register' => '/app/Controller/register.php',
    '/updateProfile' => '/app/Controller/updateProfile.php',
    '/authorization' => '/app/Controller/authorization.php',

];

$route = $_SERVER['REQUEST_URI'];
//var_dump($route);die;
if (array_key_exists($route, $routes)) {
    include __DIR__. '/..'.$routes[$route];
} else {
    include __DIR__. '/../templates/404.view.php';
}
//var_dump($_POST); die;
//echo 'qweqwe';

