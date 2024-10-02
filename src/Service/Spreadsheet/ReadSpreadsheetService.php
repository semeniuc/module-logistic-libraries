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
        if (!file_exists($pathToFile)) {
            return [];
        }

        $spreadsheet = $this->getSpreadsheet($pathToFile);
        return $this->getSheetsByCategoryName($spreadsheet->getAllSheets(), $categoryName);
    }

    private function getSpreadsheet(string $pathToFile): Spreadsheet
    {
        return IOFactory::load($pathToFile);
    }


    private function getSheetsByCategoryName(array $sheets, string $categoryName): array
    {
        $listSheets = (include APP_PATH . '/config/app/templates.php')[$categoryName]['sheets'];

        if ($sheets && $listSheets) {
            foreach ($listSheets as $sheetId => $sheetName) {
                foreach ($sheets as $sheet) {
                    /**
                     * @var Worksheet $sheet
                     */
                    if ($sheet->getTitle() === $sheetName) {
                        $result[$sheetId] = $this->getRowsBySheetId($categoryName, $sheetId, $sheet);
                        break;
                    }
                }
            }
        }

        return $result ?? [];
    }

    private function getRowsBySheetId(string $categoryName, string $sheetId, Worksheet $sheet): array
    {
        $firstRow = (include APP_PATH . '/config/' . $categoryName . '/' . $sheetId . '.php')['rows']['first'];

        if ($firstRow < $sheet->getHighestRow()) {
            $rows = array_slice($sheet->toArray(), $firstRow);

            if (!empty($rows)) {
                $rows = array_filter($rows, [$this, 'isNotEmptyRow']);
                $rows = array_map([$this, 'trimRowLength'], $rows);
                $rows = array_map([$this, 'trimSpaces'], $rows);
            }
        }

        return $rows ?? [];
    }

    private function isNotEmptyRow(array $row): bool
    {
        return !empty(array_filter($row));
    }

    private function trimRowLength(array $row): array
    {
        return array_slice($row, 0, 49);
    }

    private function trimSpaces(array $row): array
    {
        foreach ($row as &$value) {
            if (!empty($value)) {
                // Добавляем пробел перед скобкой, если его нет
                $value = preg_replace('/(?<!\s)\(/', ' (', $value);
                // Заменяем несколько пробелов одним
                $value = preg_replace('/\s+/', ' ', $value);
                // Удаляем начальные и конечные пробелы
                $value = trim($value);
            }
        }

        return $row;
    }
}