<?php

declare(strict_types=1);

namespace App\Service\Export;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportService
{
    private PrepareDataService $dataService;
    private CreateSpreadsheetService $createFileService;

    public function __construct()
    {
        $this->dataService = new PrepareDataService();
        $this->createFileService = new CreateSpreadsheetService();
    }

    public function execute(string $categoryName): void
    {
        $data = $this->dataService->getData($categoryName);
        $spreadsheet = $this->createFileService->create($categoryName, $data);

        $this->output($spreadsheet);
    }

    private function output(Spreadsheet $spreadsheet): void
    {
        $filename = 'export_' . time() . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}