<?php

declare(strict_types=1);

namespace App\Service\Items;

use Bitrix\Main\Engine\CurrentUser;

class AddItemsService extends ItemsService
{
    private int $userId = 0;

    public function __construct()
    {
        parent::__construct();
        $this->userId = (int)CurrentUser::get()->getId();
    }

    public function execute(string $categoryName, array $dataFromExcel): array
    {
        $data = $this->prepareItems($categoryName, $dataFromExcel);
        return $this->addItems($categoryName, $data);
    }

    private function addItems(string $categoryName, array $data): array
    {
        if ($data) {
            $entityTypeIds = $this->getEntityTypeIds($categoryName);

            foreach ($data as $entityType => $items) {
                $result[$entityType][] = $this->entityRepository->createItems($entityTypeIds[$entityType], $items);
            }
        }
        return $result ?? [];
    }

    private function prepareItems(string $categoryName, array $dataFromExcel): array
    {
        foreach ($dataFromExcel as $sheetId => $rows) {
            $coordinates = (include APP_PATH . '/config/' . $categoryName . '/' . $sheetId . '.php')['columns'];

            if ($coordinates) {
                $coordinates = array_values($coordinates);
                foreach ($rows as $rowNum => $rowData) {
                    foreach ($rowData as $key => $value) {
                        $result[$sheetId][$rowNum][$coordinates[$key]['id'][APP_ENV]] = $value;
                    }

                    $result[$sheetId][$rowNum]['ASSIGNED_BY_ID'] = $this->userId;
                }
            }
        }

        return $result ?? [];
    }
}