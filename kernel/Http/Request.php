<?php

declare(strict_types=1);

namespace App\Kernel\Http;

class Request
{
    public function __construct(
        public array $get,
        public array $post,
        public array $files,
        public array $cookies,
        public array $server
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, static::getPost(), $_FILES, $_COOKIE, $_SERVER);
    }

    public function uri(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    private static function getPost(): array
    {
        return (!empty($_POST)) ? $_POST : json_decode(file_get_contents('php://input'), true) ?? [];
    }
}