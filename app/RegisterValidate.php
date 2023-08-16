<?php

declare(strict_types=1);

class RegisterValidate extends Validate
{
    private ?array $request = null;

    private UserRepository $userRepository;
    public function __construct(array $request, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
    }

//    public function isEmail(string $email = null): UserValidate|false
//    {
//        $email = $this->request['email'];
//        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            return $this;
//        }
//        return false;
//    }

    public function isUniqEmail(string $email)
    {
        var_dump($this->userRepository->findByEmail($email));die;
        if ($this->userRepository->findByColumn($email)) {

        }
    }

    public function emailValidate(string $email = null)
    {
        $email = $this->isEmail($this->request['email']);
    }

    public function isValid()
    {

    }

}
