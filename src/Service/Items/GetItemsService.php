<?php

declare(strict_types=1);

namespace App\Service\Items;

class GetItemsService extends ItemsService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function execute(string $categoryName): array
    {
        return $this->getItemsData($categoryName);
    }

    private function getItemsData(string $categoryName): array
    {
        $result = [];

        $entityTypeIds = $this->getEntityTypeIds($categoryName);

        if (!empty($entityTypeIds)) {
            foreach ($entityTypeIds as $entityType => $entityTypeId) {
                $result[$entityType] = $this->entityRepository->getItems($entityTypeId);
            }
        }

        return $result;
    }
}