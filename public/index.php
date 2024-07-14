<?php

define('APP_PATH', dirname(__DIR__));

use App\Kernel\App;
use App\Service\LoggingService;
use Symfony\Component\Dotenv\Dotenv;

require_once APP_PATH . '/vendor/autoload.php';

try {
    $dotenv = new Dotenv();
    $dotenv->loadEnv(APP_PATH . '/.env');

    define("APP_ENV", $_SERVER['APP_ENV']);
    define("APP_URL", $_SERVER['APP_URL']);

    $app = new App();
    $app->run();
} catch (Throwable $th) {
    LoggingService::save([
        'code' => $th->getCode(),
        'message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
    ], 'error', 'errors');

    echo json_encode(['result' => 'error']);
}