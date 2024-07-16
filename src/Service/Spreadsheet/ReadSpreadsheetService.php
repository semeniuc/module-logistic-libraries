<?php

declare(strict_types=1);

namespace App\Service\Spreadsheet;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReadSpreadsheetService
{
    public function execute(string $categoryName, string $pathToFile): array
    {
        if (!file_exists(APP_PATH . $pathToFile)) {
            return [];
        }

        $spreadsheet = $this->getSpreadsheet($pathToFile);
        return $this->getSheetsByCategoryName($spreadsheet->getAllSheets(), $categoryName);
    }

    private function getSpreadsheet(string $pathToFile): Spreadsheet
    {
        return IOFactory::load(APP_PATH . $pathToFile);
    }


    private function getSheetsByCategoryName(array $sheets, string $categoryName): array
    {
        $result = [];

        $listSheets = (include APP_PATH . '/config/app/templates.php')[$categoryName]['sheets'];

        if ($sheets && $listSheets) {
            foreach ($listSheets as $sheetId => $sheetName) {
                foreach ($sheets as $sheet) {
                    /**
                     * @var Worksheet $sheet
                     */
                    if ($sheet->getTitle() === $sheetName) {
                        $result[$sheetId] = $sheet->toArray();
                        break;
                    }
                }
            }
        }

        return $result;
    }
}