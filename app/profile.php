<?php

if (!isset($_SESSION['userSessionHash'])) {
    Redirect::to('registration');
}
$security = new Security();

$user = $security->authenticationUser();

if (null === $user) {
    Redirect::to('registration');
    die;
}



