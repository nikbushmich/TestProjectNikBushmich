<?php

declare(strict_types=1);

use orm\Repository;

class UserRepository extends Repository
{
    private const TABLE = 'users';

    public function findUserById(int $id): User
    {
        $data = $this->findById(self::TABLE, ['user_id' => $id]);

        return User::make($data);
    }

    public function findByColumnUser(array $where): object|false
    {
        return $this->findByColumn(self::TABLE, $where);
    }

    public function insertUser(array $fields): void
    {
        $this->insert(self::TABLE, $fields);
    }

    public function updateUser(int $id, array $fields):void
    {
        $this->update(self::TABLE, $id, $fields);
    }
}
