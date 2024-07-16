<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Items\DeleteItemsService;
use App\Service\Spreadsheet\ReadSpreadsheetService;

class ImportService
{
    private ReadSpreadsheetService $readSpreadsheetService;
    private DeleteItemsService $deleteItemsService;

    public function __construct()
    {
        $this->readSpreadsheetService = new ReadSpreadsheetService();
        $this->deleteItemsService = new DeleteItemsService();
    }

    public function execute(string $categoryName, string $pathToFile)
    {
        # Read
        $dataFromExcel = $this->read($categoryName, $pathToFile);

        # Delete
        if (!empty($dataFromExcel)) {
            $this->delete($categoryName, $dataFromExcel);

            # Add
//            dd($data);
        }
    }

    private function read(string $categoryName, string $pathToFile): array
    {
        return $this->readSpreadsheetService->execute($categoryName, $pathToFile);
    }

    private function delete(string $categoryName, array $dataFromExcel): void
    {
        $types = [];
        foreach ($dataFromExcel as $entityType => $items) {
            (empty($items)) ?: $types[] = $entityType;
        }

        $this->deleteItemsService->execute($categoryName, $types);
    }

    private function add(string $categoryName, array $data): array
    {
        return [];
    }
}