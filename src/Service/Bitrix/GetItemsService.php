<?php

declare(strict_types=1);

namespace App\Service\Bitrix;

use App\Repository\EntityRepository;

class GetItemsService
{
    private EntityRepository $crmEntityRepository;

    public function __construct()
    {
        $this->crmEntityRepository = new EntityRepository();
    }

    public function execute(string $categoryName): array
    {
        return $this->getData($categoryName);
    }

    private function getData(string $categoryName): array
    {
        $listLibraries = $this->getListLibraries($categoryName);

        $result = [];

        if (!empty($listLibraries)) {
            foreach ($listLibraries as $entityType => $entityTypeId) {
                $result[$entityType] = $this->crmEntityRepository->getItems($entityTypeId);
            }
        }

        return $result;
    }

    private function getListLibraries(string $categoryName): array
    {
        return (include APP_PATH . '/config/app/entities.php');
    }
}