<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Controller\Controller;
use App\Service\ExportService;
use App\Service\ImportService;

class LibraryDataController extends Controller
{
    private ExportService $exportService;
    private ImportService $importService;

    public function __construct()
    {
        $this->exportService = new ExportService();
        $this->importService = new ImportService();
    }

    public function export(): void
    {
        $categoryName = $this->request()->post['categoryName'] ?? 'tariff-library';
        $this->exportService->execute($categoryName);
    }

    public function import(): void
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

        $categoryName = $this->request()->post['directoryType'] ?? 'tariff-library';
        $pathToFile = $this->request()->files['excelFile']['tmp_name'] ?? APP_PATH . '/var/tmp/empty-rows.xlsx';
        $this->importService->execute($categoryName, $pathToFile);
    }
}