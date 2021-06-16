<?php

namespace App\User\Storage;

use App\User\Model\User;

interface UserStorageInterface
{
    public function all(): array;

    public function getById(string $id): User;

    public function create(array $data): User;

    public function update(array $data);

    public function delete(string $id);
}
