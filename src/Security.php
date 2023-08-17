<?php

declare(strict_types=1);

class Security
{
    private array $message = [];
    private ?User $user = null;
    private UserRepository $userRepository;

    public function __construct(User $user = null)
    {
        $this->user = $user;
        $this->userRepository = new UserRepository();
    }

    private function createSessionHash(): string
    {
        return uniqid('',true);
    }

    public function authorizationUser()
    {
        $session = $this->createSessionHash();

        $this->userRepository->updateUser($this->user->getId(), ['session_hash' => $session]);

        Session::put('userSessionHash', $session);
        return $session;
    }

    public function authenticationUser(): null|User
    {
        $sessionUser = Session::get('userSessionHash');

        $user = $this->userRepository->findByColumnUser(['session_hash' => $sessionUser]);

        if (false === $user) {
            return null;
        }

        return User::make($user);
    }
}
