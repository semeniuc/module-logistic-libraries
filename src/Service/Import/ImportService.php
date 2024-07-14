<?php

declare(strict_types=1);

namespace App\Service\Import;

use App\Service\Export\PrepareDataService;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportService
{
    private PrepareDataService $dataService;

    public function __construct()
    {
        $this->dataService = new PrepareDataService();
    }

    public function execute(string $categoryName, string $pathToFile)
    {
//        if (file_exists(APP_PATH . $pathToFile)) {
//            $this->read(APP_PATH . $pathToFile);
//        }

        $data = $this->dataService->getData($categoryName);
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