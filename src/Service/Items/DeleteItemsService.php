<?php

declare(strict_types=1);

namespace App\Service\Items;

class DeleteItemsService extends ItemsService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute(string $categoryName, array $sheetNames): void
    {
        $this->deleteItems($categoryName, $sheetNames);
    }

    private function deleteItems(string $categoryName, array $sheetNames): void
    {
        if (!empty($sheetNames)) {
            foreach ($sheetNames as $sheetName) {
                if ($entityTypeId = $this->getEntityTypeId($categoryName, $sheetName)) {
                    $this->entityRepository->deleteItems($entityTypeId);
                }
            }
        }
    }
}