<?php

namespace App\User\Model;

class User
{
    public string $username;
    public ?string $id = null;
    public string $email;

    public function __construct(string $username, string $email)
    {
        $this->username = $username;
        $this->email = $email;
    }

    public static function fromArray(array $data): User
    {
        $user = new self($data['username'], $data['email']);
        $user->id = $data['id'] ?? null;

        return $user;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}
