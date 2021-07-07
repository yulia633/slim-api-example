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

    public function create(array $userData): void
    {
        $user = User::fromArray($userData);
        $id = uniqid();

        $user->id = $id;
        $users = JsonStorage::readFile();
        $users[] = $user->toArray();
        $user = JsonStorage::writeFile($users);
    }

    public function update(array $userData): void
    {
        $users = $this->all();

        [$idUsers, $newUsers] = $userData;

        $updateUsers = array_map(function ($user) use ($newUsers, $idUsers) {
            if ($user['id'] === $idUsers) {
                $user['username'] = $newUsers['username'];
                $user['email'] = $newUsers['email'];
            }
            return $user;
        }, $users);

        $users[] = JsonStorage::writeFile($updateUsers);
    }

    public function delete(string $id): void
    {
        $users = $this->all();
        $userData = json_decode($id, JSON_OBJECT_AS_ARRAY);

        $deleteUsers = array_filter($users, function ($user) use ($userData) {
            if ($user['id'] !== $userData['id']) {
                return $user;
            }
        });

        JsonStorage::writeFile($deleteUsers);
    }
}
