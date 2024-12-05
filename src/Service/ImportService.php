<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Items\AddItemsService;
use App\Service\Items\DeleteItemsService;
use App\Service\Spreadsheet\ReadSpreadsheetService;

class ImportService
{
    private ReadSpreadsheetService $readSpreadsheetService;
    private DeleteItemsService $deleteItemsService;
    private AddItemsService $addItemsService;

    public function __construct()
    {
        $this->readSpreadsheetService = new ReadSpreadsheetService();
        $this->deleteItemsService = new DeleteItemsService();
        $this->addItemsService = new AddItemsService();
    }

    public function execute(string $categoryName, string $pathToFile)
    {
        # Read
        $dataFromExcel = $this->read($categoryName, $pathToFile);
        
        # Delete
        if (!empty($dataFromExcel)) {
            $this->delete($categoryName, $dataFromExcel);

            # Add
            $resultAddItems = $this->add($categoryName, $dataFromExcel);

            dd($resultAddItems);
            $this->output($categoryName, $resultAddItems);
        }
    }

    private function read(string $categoryName, string $pathToFile): array
    {
        return $this->readSpreadsheetService->execute($categoryName, $pathToFile);
    }

    private function delete(string $categoryName, array $dataFromExcel): void
    {
        $sheetNames = [];
        foreach ($dataFromExcel as $sheetName => $rows) {
            (empty($rows)) ?: $sheetNames[] = $sheetName;
        }

        $this->deleteItemsService->execute($categoryName, $sheetNames);
    }

    private function add(string $categoryName, array $dataFromExcel): array
    {
        return $this->addItemsService->execute($categoryName, $dataFromExcel);
    }

    private function output(string $categoryName, array $resultAddItems): void
    {
        $sheets = (include APP_PATH . '/config/app/templates.php')[$categoryName]['sheets'];

        $result = [
            'success' => [
                'total' => 0,
            ],
            'errors' => [
                'total' => 0,
                'records' => [],
            ],
        ];

        foreach ($resultAddItems as $entityType => $items) {
            $firstRow = (include APP_PATH . '/config/' . $categoryName . '/' . $entityType . '.php')['rows']['first'];

            foreach ($items as $key => $item) {

                if (is_string($key) && str_contains($key, '_')) {
                    preg_match('/\d+$/', $key, $matches);
                    $key = $matches[0];
                }

                if ($item->isSuccess()) {
                    $result['success']['total'] += 1;
                } else {
                    $result['errors']['total'] += 1;
                    $result['errors']['records'][] = [
                        'sheet' => $sheets[$entityType],
                        'row' => (int)$firstRow + (int)$key + 1,
                        'description' => $item->getErrorMessages(),
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}