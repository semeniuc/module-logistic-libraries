<?php

declare(strict_types=1);

namespace App\Service\Export;

use App\Repository\EntityRepository;

class PrepareDataService
{
    private EntityRepository $entityRepository;

    public function __construct()
    {
        $this->entityRepository = new EntityRepository();
    }

    public function getData(string $categoryName): array
    {
        $listLibraries = $this->getListLibraries($categoryName);

        $result = [];

        if (!empty($listLibraries)) {
            foreach ($listLibraries as $entityType => $entityId) {
                $result[$entityType] = $this->entityRepository->get($entityId);
            }
        }

        return $result;
    }

    private function getListLibraries(string $categoryName): array
    {
        return (include APP_PATH . '/config/app/entities.php');
    }
}