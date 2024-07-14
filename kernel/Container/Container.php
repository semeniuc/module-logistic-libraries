<?php

declare(strict_types=1);

namespace App\Kernel\Container;

use App\Kernel\Http\Request;
use App\Kernel\Router\Router;
use App\Kernel\View\View;

class Container
{
    public function __construct(
        public Request $request,
        public Router $router,
        public View $view,
    ) {
    }

    public static function registerServices(): static
    {
        $request = Request::createFromGlobals();
        $view = new View();
        $router = new Router($request, $view);

        return new static(
            $request,
            $router,
            $view
        );
    }
}