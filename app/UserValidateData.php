<?php

declare(strict_types=1);

class UserValidateData
{
    private array $errors = [];
    private array $userData;
    private UserRepository $userRepository;

    public function __construct(array $userData)
    {
        $this->userData = $userData;
        $this->userRepository = new UserRepository();
    }

    private function isUniqEmail(): self
    {
        if ($this->userRepository->findByColumnUser(['email' => $this->userData['email']])) {
            $this->errors['uniqEmail'] = "Такое емаил уже используется";
            return $this;
        }

        return $this;
    }

    private function isUniqPhone(): self
    {
        if ($this->userRepository->findByColumnUser(['phone' => $this->userData['phone']])) {
            $this->errors['uniqPhone'] = "Этот телефон уже используется";
            return $this;
        }

        return $this;
    }

    private function isUniqName(): self
    {
        if ($this->userRepository->findByColumnUser(['name' => $this->userData['name']])) {
            $this->errors['uniqName'] = "Такое имя уже существует";
            return $this;
        }

        return $this;
    }

    public function isUniqUser(): array
    {
        $this->isUniqEmail()->isUniqPhone()->isUniqName();

        return $this->userData;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function isEmailOrPhone(): array
    {
        $emailOrPhone = $this->userData['emailOrPhone'];
        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            return ['email' => $emailOrPhone];
        }
        $phone = str_replace(['+', '-', ' ', '(', ')', '_'], '', $emailOrPhone);
        return ['phone' => $phone];
    }

    public function loginValidate(): bool|object
    {
        $field = $this->isEmailOrPhone();

        $user = $this->userRepository->findByColumnUser($field);

        if ( false === $user) {
            $this->errors['userNotFound'] = "Пользователь не найден";
            return false;
        }

        $password = $this->userData['password'];
        $userPassword = $user->password;

        if (!$this->passwordValidate($password, $userPassword)) {
            $this->errors['passwordError'] = "Неверный пароль";
            return false;
        }

        return $user;

    }

    public function passwordValidate(string $password,string $userPassword): bool
    {
        return password_verify($password, $userPassword);
    }

    public function validateUpdateData(): array
    {
        if (array_key_exists( 'name', $this->userData)) {
            $this->isUniqName();
        }

        if (array_key_exists( 'email', $this->userData)) {
            $this->isUniqEmail();
        }

        if (array_key_exists( 'phone', $this->userData)) {
            $this->isUniqPhone();
        }

        return $this->userData;
    }
}
