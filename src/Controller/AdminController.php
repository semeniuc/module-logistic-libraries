<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Controller\Controller;
use App\Service\Admin\AdminService;

class AdminController extends Controller
{
    private AdminService $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    public function read(): void
    {
        $this->view('admin', [
            'title' => 'Настройки - Импорт справочников',
            'module_id' => 'logistic.libraries',
            'access' => $this->adminService->read(),
        ]);
    }

    public function save(): void
    {
        $this->adminService->save($this->request()->post);
        header('Location: ' . APP_URL . 'admin');
    }
}