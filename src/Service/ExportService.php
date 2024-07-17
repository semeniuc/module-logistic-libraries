<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Items\GetItemsService;
use App\Service\Spreadsheet\CreateSpreadsheetService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use XMLWriter;

class ExportService
{
    private GetItemsService $getItemsService;
    private CreateSpreadsheetService $createFileService;

    public function __construct()
    {
        $this->getItemsService = new GetItemsService();
        $this->createFileService = new CreateSpreadsheetService();
    }

    public function execute(string $categoryName): void
    {
        $data = $this->getItemsService->execute($categoryName);

        # test
        $class = new XMLWriter();
        dd([$class::class => '']);

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