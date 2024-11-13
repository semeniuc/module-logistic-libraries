<?php

use App\Controller\AdminController;
use App\Controller\HomeController;
use App\Controller\LibraryDataController;
use App\Kernel\Router\Route;

return [
    Route::get(APP_URL, [HomeController::class, 'index']),
    Route::post(APP_URL . 'export', [LibraryDataController::class, 'export']),
    Route::post(APP_URL . 'import', [LibraryDataController::class, 'import']),

    Route::get(APP_URL . 'admin', [AdminController::class, 'read']),
    Route::post(APP_URL . 'admin', [AdminController::class, 'save']),

    # Test
//    Route::get(APP_URL . 'test/export', [LibraryDataController::class, 'exportTest']),
    Route::get(APP_URL . 'test/import', [LibraryDataController::class, 'importTest']),
];