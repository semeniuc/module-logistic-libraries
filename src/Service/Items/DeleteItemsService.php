<?php

declare(strict_types=1);

namespace App\Service\Items;

class DeleteItemsService extends ItemsService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute(string $categoryName, array $entityTypes): void
    {
        $this->deleteItems($categoryName, $entityTypes);
    }

    private function deleteItems(string $categoryName, array $entityTypes): void
    {
        if (!empty($entityTypes)) {
            $entityTypeIds = $this->getEntityTypeIds($categoryName);
            
            if (!empty($entityTypeIds)) {
                foreach ($entityTypeIds as $entityType => $entityTypeId) {
                    if (in_array($entityType, $entityTypes)) {
                        $this->entityRepository->deleteItems($entityTypeId);
                    }
                }
            }
        }
    }
}