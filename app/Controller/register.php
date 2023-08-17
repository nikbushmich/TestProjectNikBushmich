<?php

if (!empty($_POST)) {
    $validate = new Validate($_POST);

    $request = $validate->registerValidate();
    $errors = $validate->getErrors();

    if (!empty($errors)) {
        Session::flash('registerError', $errors);
        Redirect::to('registration');
        die();
    }

    $uniqValidate = new UserValidateData($request);

    $userDate = $uniqValidate->isUniqUser();
    $errorsUniq = $uniqValidate->getErrors();

    if (!empty($errorsUniq)) {
        Session::flash('registerError', $errorsUniq);
        Redirect::to('registration');
        die();
    }

    $user = new User($userDate);

    $userService = new UserService($user);

    $userService->createNewUser();
    $messageCreate = $userService->getMessage();

    if (!empty($messageCreate['successCreateUser'])) {
        Session::flash('successCreateUser', $messageCreate);
        Redirect::to('login');
        die();
    }

    if (!empty($messageCreate['errorCreateUser'])) {
        Session::flash('registerError', $messageCreate);
        die();
    }
    Redirect::to('registration');
}
Redirect::to('registration');
