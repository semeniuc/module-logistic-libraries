<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Repository\AccessRepository;

class AdminService
{
    private AccessRepository $accessRepository;

    public function __construct()
    {
        $this->accessRepository = new AccessRepository();
    }

    public function read(): array
    {
        $result = $this->accessRepository->read();

        if (empty($result)) {
            $result = $this->accessRepository->reset();
        }

        return $result;
    }

    public function save(array $data): void
    {
        $tmp = [];
        foreach ($data as $key => $value) {
            if ($key == 'default_for_all') {
                $tmp['all'] = $value;
            } elseif (str_contains($key, 'user_')) {
                $tmp[$key] = $value;
            }
        }
        
        $this->accessRepository->save($tmp);
    }
}