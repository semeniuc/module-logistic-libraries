<?php

define('APP_PATH', dirname(__DIR__));

use App\Kernel\App;
use Symfony\Component\Dotenv\Dotenv;

try {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
    require_once APP_PATH . '/include.php';

    $dotenv = new Dotenv();
    $dotenv->loadEnv(APP_PATH . '/.env');

    define("APP_ENV", $_SERVER['APP_ENV']);
    define("APP_URL", $_SERVER['APP_URL']);

    $app = new App();
    $app->run();
} catch (Throwable $th) {
    echo json_encode([
        'code' => $th->getCode(),
        'message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
    ], JSON_PRETTY_PRINT);
}