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
        $newData = [];



        if ($user->getName() !== $_POST['name']) {
            $validate->isName();
            $newData['name'] = $_POST['name'];
        }

        if ($user->getEmail() !== $_POST['email']) {
            $validate->isEmail();
            $newData['email'] = $_POST['email'];
        }

        if ($user->getPhone() !== $_POST['phone']) {
            $validate->isPhone();
            $newData['phone'] = $validate->getRequest()['phone'];
        }

        if (empty($newData)) {
            Redirect::to('profile');
            die();
        }

        if ($validate->getErrors()) {
            Session::flash('registerError', $validate->getErrors());
            Redirect::to('profile');
            die();
        }

        $validateUserData = new UserValidateData($newData);

        $validData = $validateUserData->validateUpdateData();
        $validError = $validateUserData->getErrors();

        if (!empty($validError)) {
            Session::flash('registerError', $validError);
            Redirect::to('profile');
            die();
        }

        $userService = new UserService($user);

        $userService->updateProfile($validData);

        $messageCreate = $userService->getMessage();

        if (!empty($messageCreate['successCreateUser'])) {
            Session::flash('successCreateUser', $messageCreate);
            Redirect::to('profile');
            die();
        }

        if (!empty($messageCreate['errorCreateUser'])) {
            Session::flash('profile', $messageCreate);
            die();
        }
    }
    Redirect::to('registration');
}
Redirect::to('updateProfile');
