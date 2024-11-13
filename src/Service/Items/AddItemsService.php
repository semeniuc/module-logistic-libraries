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
            foreach ($data as $sheetName => $rows) {
                $entityTypeId = $this->getEntityTypeId($categoryName, $sheetName);
                $result[$categoryName][$sheetName] = $this->entityRepository->createItems($entityTypeId, $rows);
            }
        }

        return $result ?? [];
    }

    private function prepareItems(string $categoryName, array $dataFromExcel): array
    {
        foreach ($dataFromExcel as $sheetName => $rows) {
            $result[$sheetName] = $this->prepareItemsByDefault($categoryName, $sheetName, $rows);
        }

        return $result ?? [];
    }

    private function prepareItemsByDefault(string $categoryName, string $sheetName, array $rows): array
    {
        $coordinates = (include APP_PATH . "/config/library/{$categoryName}/{$sheetName}.php")['columns'];

        if ($coordinates) {
            $coordinates = array_values($coordinates);
            foreach ($rows as $rowNum => $rowData) {


                for ($key = 0; $key < count($coordinates); $key++) {
                    if (array_key_exists($key, $rowData)) {
                        $result[$rowNum][$coordinates[$key]['id'][APP_ENV]] = $rowData[$key];
                    } else {
                        // Добавляем сервисную метку
                        $result[$rowNum][$coordinates[$key]['id'][APP_ENV]] = true; // true
                    }
                }
                $result[$rowNum]['ASSIGNED_BY_ID'] = $this->userId;
            }
        }

        return $result ?? [];
    }
}