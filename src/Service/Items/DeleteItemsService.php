<?php

declare(strict_types=1);

namespace App\Service\Items;

use Bitrix\Main\Engine\CurrentUser;

class DeleteItemsService extends ItemsService
{
    private int $userId = 0;

    public function __construct()
    {
        parent::__construct();
        $this->userId = (int)CurrentUser::get()->getId();
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
                    $this->entityRepository->deleteItems($entityTypeId, $this->userId);
                }
            }
        }
    }
}