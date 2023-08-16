<?php

declare(strict_types=1);

class Validate
{
    private const RULE = [
        'lengthNameMin' => 3,
        'lengthNameMax' => 150,
        'lengthPasswordMin' => 5,
        'lengthPasswordMax' => 150,
        'phoneExample' => '+7123 45 67 890',
        'phonePattern' => '/^\d{10,15}$/',
    ];
    private ?array $request = null;
    private array $errors = [];

    public function __construct(array $request)
    {
        $this->request = $request;

    }
    public function isEmail(): Validate|false
    {
        if (filter_var($this->request['email'], FILTER_VALIDATE_EMAIL)) {
            return $this;
        }
        $this->errors['email'] = 'Введите Email';
        return false;
    }

    public function isName(): self
    {
        $lengthName = strlen($this->request['name']);
        if (($lengthName > self::RULE['lengthNameMin']) && ($lengthName < self::RULE['lengthNameMax'])) {
            return $this;
        }
        $this->errors['nameLength'] = "Имя должно быть длиннее ". self::RULE['lengthNameMin'] ." символов";
        return $this;
    }

    public function isPhone(): self
    {
        $phone = $this->request['phone'];

        if (!isset($this->request['phone'])) {
            $this->errors['phone'] = "Пустой номер телефона";
            return $this;
        }

        $this->request['phone'] = $this->phonePrepare($phone);

        if (preg_match((string) self::RULE['phonePattern'], $this->request['phone'])) {
            return $this;
        }

        $this->errors['phone'] = "Неправельный номер,<br> вводите формата " . self::RULE['phoneExample'];
        return $this;
    }

    public function isPassword(): self
    {
        $lengthName = strlen($this->request['password']);
        if (($lengthName > self::RULE['lengthPasswordMin']) && ($lengthName < self::RULE['lengthPasswordMax'])) {
            if ($this->request['password'] === $this->request['passwordRepeat']) {
                return $this;
            }
            $this->errors['passwordRepeat'] = "Пароли не совпадают";
            return $this;
        }
        $this->errors['passwordLength'] = "Пароль должно быть длиннее ". self::RULE['lengthPasswordMin'] ." символов";
        return $this;
    }

    public function registerValidate(): array
    {
        $this->isName()->isPhone()->isEmail()->isPassword();

        return $this->request;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function phonePrepare(string $phone): string
    {
        return str_replace(['+', '-', ' ', '(', ')', '_'], '', $phone);
    }

    public function getRequest(): ?array
    {
        return $this->request;
    }
}
