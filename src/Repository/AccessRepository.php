<?php

namespace App\Repository;

class AccessRepository
{
    public function __construct(
        public readonly string $pathToFile = APP_PATH . '/var/options/access.json',
        public readonly string $pathToDefault = APP_PATH . '/config/app/access.php',
    )
    {
    }

    public function read(): array
    {
        if (file_exists($this->pathToFile)) {
            return json_decode(file_get_contents($this->pathToFile), true) ?? [];
        }

        return [];
    }

    public function save(array $data): void
    {
        file_put_contents($this->pathToFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function reset(): array
    {
        return (include $this->pathToDefault)[APP_ENV];
    }

    public function delete(): void
    {
        if (file_exists($this->pathToFile)) {
            unlink($this->pathToFile);
        }
    }
}