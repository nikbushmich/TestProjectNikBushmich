<?php

declare(strict_types=1);

class UserService
{
    private array $message = [];
    private User $user;
    private UserRepository $userRepository;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->userRepository = new UserRepository();
    }

    public function createNewUser(): void
    {
         $fields['name'] = $this->user->getName();
         $fields['email'] = $this->user->getEmail();
         $fields['phone'] = $this->user->getPhone();
         $fields['password'] = $this->user->getHashPassword();
         $fields['created_at'] = $this->user->getCreatedAt()->format('Y-m-d H:i:s');

        try {
            $this->userRepository->insertUser($fields);
            $this->message['successCreateUser'] = 'Регистрация прошла успешно.';
        } catch (Exception) {
            $this->message['errorCreateUser'] = 'Произошла ошибка, пользователь не создан.';
        }
    }

    public function getMessage(): array
    {
        return $this->message;
    }

    public function updateProfile(array $data): void
    {
              
        try {
            $this->userRepository->updateUser($this->user->getId(), $data);
            $this->message['successCreateUser'] = 'Профиль обновлен';
        } catch (Exception) {
            $this->message['errorCreateUser'] = 'Ошибка при обновлении профиля';
        }
    }

}
