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
                $result[$entityType] = $this->entityRepository->createItems($entityTypeIds[$entityType], $items);
            }
        }
        
        return $result ?? [];
    }

    private function prepareItems(string $categoryName, array $dataFromExcel): array
    {
        foreach ($dataFromExcel as $sheetId => $rows) {
            $coordinates = (include APP_PATH . '/config/' . $categoryName . '/' . $sheetId . '.php')['columns'];

            if ($coordinates) {
                # Exception
                if ($categoryName === 'tariff-library' && $sheetId === 'container') {
                    $result[$sheetId] = $this->prepareItemsByContainer($coordinates, $rows);
                } else {
                    $result[$sheetId] = $this->prepareItemsByDefault($coordinates, $rows);
                }
            }
        }

        return $result ?? [];
    }

    private function prepareItemsByDefault(array $coordinates, array $rows): array
    {
        $coordinates = array_values($coordinates);
        foreach ($rows as $rowNum => $rowData) {
            foreach ($rowData as $key => $value) {
                $result[$rowNum][$coordinates[$key]['id'][APP_ENV]] = $value;
            }
            $result[$rowNum]['ASSIGNED_BY_ID'] = $this->userId;
        }

        return $result ?? [];
    }

    private function prepareItemsByContainer(array $coordinates, array $rows): array
    {
        $rowsByCoc = array_map(function ($rows) {
            return array_slice($rows, 0, 7);
        }, $rows);

        $rowsByCoc = array_filter($rowsByCoc, function ($row) {
            return !empty(array_filter($row));
        });

        $rowsBySoc = array_map(function ($rows) {
            return array_slice($rows, 7, 8);
        }, $rows);

        $rowsBySoc = array_filter($rowsBySoc, function ($row) {
            return !empty(array_filter($row));
        });

        if (!empty($rowsByCoc)) {
            foreach ($rowsByCoc as $rowNum => $rowData) {
                $result['coc_row_' . $rowNum] = [
                    $coordinates['type']['id'][APP_ENV] => 'COC',
                    $coordinates['destination']['id'][APP_ENV] => $rowData[0],
                    $coordinates['contractor']['id'][APP_ENV] => $rowData[1],
                    $coordinates['cost20Dry']['id'][APP_ENV] => $rowData[2],
                    $coordinates['cost40Hc']['id'][APP_ENV] => $rowData[3],
                    $coordinates['priceValidFrom']['id'][APP_ENV] => $rowData[4],
                    $coordinates['priceValidTill']['id'][APP_ENV] => $rowData[5],
                    $coordinates['comment']['id'][APP_ENV] => $rowData[6],
                    'ASSIGNED_BY_ID' => $this->userId,
                ];
            }
        }

        if (!empty($rowsBySoc)) {
            foreach ($rowsBySoc as $rowNum => $rowData) {
                $result['soc_row_' . $rowNum] = [
                    $coordinates['type']['id'][APP_ENV] => 'SOC',
                    $coordinates['pol']['id'][APP_ENV] => $rowData[0],
                    $coordinates['destinationPart2']['id'][APP_ENV] => $rowData[1],
                    $coordinates['contractorPart2']['id'][APP_ENV] => $rowData[2],
                    $coordinates['cost20DryPart2']['id'][APP_ENV] => $rowData[3],
                    $coordinates['cost40HcPart2']['id'][APP_ENV] => $rowData[4],
                    $coordinates['priceValidFromPart2']['id'][APP_ENV] => $rowData[5],
                    $coordinates['priceValidTillPart2']['id'][APP_ENV] => $rowData[6],
                    $coordinates['commentPart2']['id'][APP_ENV] => $rowData[7],
                    'ASSIGNED_BY_ID' => $this->userId,
                ];
            }
        }

        return $result ?? [];
    }
}