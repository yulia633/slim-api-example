<?php

namespace App\User\Storage;

use App\User\Model\User;

class UserJsonStorage implements UserStorageInterface
{
    private const USER_DATA_PATH = __DIR__ . '/../../../users.json';

    public array $data = [];

    public function __construct()
    {
        $this->readFile();
    }

    public function all(): array
    {
        $users = $this->readFile();

        return $users;
    }

    public function getById(string $id): User
    {
        $users = $this->all();

        foreach($users as $userData) {
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

        $users = $this->readFile();
        $users[] = $user->toArray();
        $this->writeFile($users);

        return $user;
    }

    public function update(array $data): void
    {
        // todo
    }

    public function delete(string $id): void
    {
        //
    }

    public function writeFile($content): void
    {
        $encodedData = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

        file_put_contents(self::USER_DATA_PATH, $encodedData);
    }

    private function readFile(): ?array
    {
        $fileContent = file_get_contents(self::USER_DATA_PATH);

        return json_decode($fileContent, true, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
