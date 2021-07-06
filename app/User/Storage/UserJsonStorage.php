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

    public function create(array $data): void
    {
        $user = User::fromArray($data);
        $id = uniqid();

        $user->id = $id;
        $users = JsonStorage::readFile();
        $users[] = $user->toArray();
        $user = JsonStorage::writeFile($users);
    }

    public function update(array $data)
    {
        $users = $this->all();
        [$idUsers, $newUsers] = $data;
        $updateUsers = array_map(function ($user) use ($newUsers, $idUsers) {
            if ($user['id'] === $idUsers['id']) {
                $user['username'] = $newUsers['username'];
                $user['email'] = $newUsers['email'];
            }
            return $user;
        }, $users);

        $users[] = JsonStorage::writeFile($updateUsers);
    }

    public function delete(string $id)
    {
        $users = $this->all();

        $deleteUsers = array_filter($users, function ($user) use ($id) {
            if ($user['id'] !== $id) {
                return $user;
            }
        });

        JsonStorage::writeFile($deleteUsers);
    }
}
