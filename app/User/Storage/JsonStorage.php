<?php

namespace App\User\Storage;

class JsonStorage
{
    private const USER_DATA_PATH = __DIR__ . '/../../../users.json';

    public static function writeFile($content): void
    {
        $encodedData = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

        file_put_contents(self::USER_DATA_PATH, $encodedData);
    }

    public static function readFile(): ?array
    {
        $fileContent = file_get_contents(self::USER_DATA_PATH);

        return json_decode($fileContent, true, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
