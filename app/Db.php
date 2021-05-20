<?php

namespace App;

class Db
{
    private $path;

    public $data;

    public function __construct($path)
    {
        $this->path = "{$path}.json";
        if (!file_exists($this->path)) {
            file_put_contents($this->path, '[]');
            $this->data = [];
        } else {
            $this->readFile();
        }
    }

    private function readFile()
    {
        $this->data = json_decode(file_get_contents($this->path), true);
    }

    public function setContent($content)
    {
        $this->path = "{$path}.json";
        $result = file_put_contents($this->path, json_encode($content, JSON_UNESCAPED_UNICODE));

        return $result;
    }
}
