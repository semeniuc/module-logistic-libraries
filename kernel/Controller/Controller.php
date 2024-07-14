<?php

declare(strict_types=1);

namespace App\Kernel\Controller;

use App\Kernel\Http\Request;
use App\Kernel\View\View;

abstract class Controller
{
    private Request $request;
    private View $view;

    public function request(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function view(string $name, array $data = []): void
    {
        $this->view->page($name, $data);
    }

    public function setView(View $view): void
    {
        $this->view = $view;
    }
}