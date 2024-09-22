<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Controller\Controller;

class NewHomeController extends Controller
{
    public function index(): void
    {
        $this->view('new-home', [
            'title' => 'Импорт справочников',
            'import' => '/import',
            'export' => '/export',
        ]);
    }
}