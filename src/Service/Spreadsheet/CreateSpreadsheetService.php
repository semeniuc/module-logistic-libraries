<?php

declare(strict_types=1);

namespace App\Service\Spreadsheet;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CreateSpreadsheetService
{
    public function create(string $templateName, array $data): ?Spreadsheet
    {
        $spreadsheet = $this->getTemplate($templateName);

        if ($spreadsheet) {
            $listSheets = $this->getListSheets($templateName);

            foreach ($listSheets as $sheetId => $sheetName) {
                $coordinates = $this->getCoordinatesForSheet($templateName, $sheetId);
                $activeSheet = $spreadsheet->getSheetByName($sheetName);
                $this->addData($activeSheet, $coordinates, $data[$sheetId]);
            }
        }

        return $spreadsheet;
    }

    private function getTemplate(string $templateName): ?Spreadsheet
    {
        $path = (include APP_PATH . '/config/app/templates.php')[$templateName]['template'] ?? '';

        if ($path && file_exists(APP_PATH . '/public/templates/' . $path)) {
            return IOFactory::load(APP_PATH . '/public/templates/' . $path);
        }

        return null;
    }

    private function getListSheets(string $templateName): array
    {
        return (include APP_PATH . '/config/app/templates.php')[$templateName]['sheets'];
    }

    private function getCoordinatesForSheet(string $templateName, string $sheetId): array
    {
        $path = APP_PATH . "/config/{$templateName}/{$sheetId}.php";
        return file_exists($path) ? (include $path) : [];
    }

    private function addData(Worksheet &$worksheet, array $coordinates, array $data): void
    {
        if ($data) {
            $row = $coordinates['rows']['first'];

            foreach ($data as $item) {
                foreach ($coordinates['columns'] as $coordinate) {
                    if ($coordinate['column'] && $value = $item[$coordinate['id'][APP_ENV]]) {
                        $worksheet->setCellValue($coordinate['column'] . $row, $value);
                    }
                }

                $row++;
            }
        }
    }
}