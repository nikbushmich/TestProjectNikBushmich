<?php

if (!empty($_POST)) {

    $reCaptcha = new ReCaptcha($_POST, $_SERVER);

    if (!$reCaptcha->checkReCaptcha()) {
        Session::flash('registerError', ['reCaptcha' => 'Не пройдена каптча']);
        Redirect::to('login');
        die();
    }

    $dataValidate = new UserValidateData($_POST);

    $userData = $dataValidate->loginValidate();
    $loginError = $dataValidate->getErrors();

    if (!empty($loginError)) {
        Session::flash('registerError', $loginError);
        Redirect::to('login');
        die();
    }

    $user = User::make($userData);

    $authorization = new Security($user);

    $authorization->authorizationUser();

    Redirect::to('profile');
}
Redirect::to('profile');
