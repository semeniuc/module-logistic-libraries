<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Bitrix\GetItemsService;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportService
{
    private GetItemsService $getItemsService;

    public function __construct()
    {
        $this->getItemsService = new GetItemsService();
    }

    public function execute(string $categoryName, string $pathToFile)
    {
//        if (file_exists(APP_PATH . $pathToFile)) {
//            $this->read(APP_PATH . $pathToFile);
//        }

        $data = $this->getItemsService->execute($categoryName);
        dd($data);
    }

    private function read(string $pathToFile)
    {
        $spreadsheet = IOFactory::load($pathToFile);

        $sheets = $spreadsheet->getAllSheets();
        $activeSheet = $spreadsheet->getActiveSheet();

        dd($activeSheet->toArray());
    }

    private function delete()
    {
    }

    private function add()
    {
    }
}