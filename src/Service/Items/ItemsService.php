<?php

declare(strict_types=1);

namespace App\Service\Items;

use App\Repository\EntityRepository;

abstract class ItemsService
{
    protected EntityRepository $entityRepository;

    public function __construct()
    {
        $this->entityRepository = new EntityRepository();
    }

    protected function getEntityTypeId(string $categoryName, string $sheetName): ?int
    {
        return (require APP_PATH . "/config/library/{$categoryName}/{$sheetName}.php")['entityType'][APP_ENV] ?? null;
    }
}