<?php

declare(strict_types=1);

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $phone;
    private string $password;
    private ?DateTimeImmutable $createdAt;
    private ?string $sessionHash;


    public function __construct(array $dataUser)
    {
        $this->name = $dataUser['name'];
        $this->email = $dataUser['email'];
        $this->phone = $dataUser['phone'];
        $this->password = $dataUser['password'];
        if (isset($dataUser['createdAt'])) {
            $this->createdAt =  new DateTimeImmutable($dataUser['createdAt']);
        } else {
            $this->createdAt =  new DateTimeImmutable();
        }
        $this->id = $dataUser['user_id']?? null;
        $this->sessionHash= $dataUser['session_hash']?? null;
    }

    public function createDateTime(string $dataTime = null)
    {
        if (empty($dataTime)) {
            return new DateTimeImmutable($dataTime);
        }
        return new DateTimeImmutable('Y-m-d H:i:s');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public static function make(object $args): User
    {
        return new self(
            (array) $args
        );
    }

    public function getHashPassword(): string
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function getSessionHash(): ?string
    {
        return $this->sessionHash;
    }

    public function setSessionHash(?string $sessionHash): void
    {
        $this->sessionHash = $sessionHash;
    }

}
