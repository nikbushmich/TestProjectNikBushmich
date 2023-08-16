<?php

if (!empty($_POST)) {
    if (isset($_SESSION['userSessionHash'])) {

        $security = new Security();

        $user = $security->authenticationUser();

        if (null === $user) {
            Redirect::to('registration');
            die;
        }

        $validate = new Validate($_POST);

        $request = $validate->isPassword()->getRequest();
        $errors = $validate->getErrors();

        if (!empty($errors)) {
            Session::flash('registerError', $errors);
            Redirect::to('updatePassword');
            die();
        }


        $validateUserData = new UserValidateData($request);

        if (!$validateUserData->passwordValidate($_POST['oldPassword'], $user->getPassword())) {
            Session::flash('registerError', ['password' => 'Не верный пароль']);
            Redirect::to('updatePassword');
            die();
        }

        $userService = new UserService($user);
        $user->setPassword( $request['password']);

        $userService->updateProfile(['password' => $user->getHashPassword()]);

        $messageCreate = $userService->getMessage();

        if (!empty($messageCreate['successCreateUser'])) {
            Session::flash('successCreateUser', $messageCreate);
            Redirect::to('updatePassword');
            die();
        }

        if (!empty($messageCreate['errorCreateUser'])) {
            Session::flash('updatePassword', $messageCreate);
            die();
        }
    }
    Redirect::to('registration');
}
Redirect::to('updatePassword');

