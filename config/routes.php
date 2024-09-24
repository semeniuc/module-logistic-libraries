<?php

use App\Controller\HomeController;
use App\Controller\LibraryDataController;
use App\Kernel\Router\Route;

return [
    Route::get(APP_URL, [HomeController::class, 'index']),
    Route::post(APP_URL . 'export', [LibraryDataController::class, 'export']),
    Route::post(APP_URL . 'import', [LibraryDataController::class, 'import']),

    # Test
//    Route::get(APP_URL . 'export', [LibraryDataController::class, 'export']),
//    Route::get(APP_URL . 'import', [LibraryDataController::class, 'import']),
];