<?php

declare(strict_types=1);

namespace App\Service\Items;

use App\Repository\EntityRepository;

abstract class ItemsService
{
    protected EntityRepository $entityRepository;
    private array $entityTypeIds = [];

    public function __construct()
    {
        $this->entityRepository = new EntityRepository();
    }

    /**
     * @param string $categoryName
     * @return int []
     */
    protected function getEntityTypeIds(string $categoryName): array
    {
        if (empty($this->entityTypeIds)) {
            if ($list = (include APP_PATH . '/config/app/categories.php')[$categoryName]) {
                foreach ($list as $entityType => $libraries) {
                    $types[$entityType] = $libraries[mb_convert_case(APP_ENV, MB_CASE_LOWER)];
                }
                return $this->entityTypeIds = $types ?? [];
            }
        }

        return $this->entityTypeIds;
    }
}