<?php

namespace App\User\Storage;

use App\User\Model\User;
use App\User\Storage\JsonStorage;

class UserJsonStorage implements UserStorageInterface
{
    public array $data = [];

    public function __construct()
    {
        $content = JsonStorage::readFile();
    }

    public function all(): array
    {
        $users = JsonStorage::readFile();

        return $users;
    }

    public function getById(string $id): User
    {
        $users = $this->all();

        foreach ($users as $userData) {
            if ((string)$userData['id'] === $id) {
                return User::fromArray($userData);
            }
        }

        throw new \DomainException('User not Found');
    }

    public function create(array $data): User
    {
        $user = User::fromArray($data);
        $id = uniqid();

        $user->id = $id;
        $users = JsonStorage::readFile();
        $users[] = $user->toArray();
        $user = JsonStorage::writeFile($users);

        return $user;
    }

    public function update(array $data): void
    {
        //
    }

    public function delete(string $id)
    {
        //
    }
}
