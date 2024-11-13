<?php

declare(strict_types=1);

namespace App\Service;

class LoggingService
{
    public static function save(mixed $arData, string $type = '', string $category = ''): bool
    {
        $path = (!empty($category)) ? APP_PATH . '/var/log/' . $category . '/' : APP_PATH . '/var/log/';
        file_exists($path) || mkdir($path, 0775, true);

        $dataToJson = [
            date('H:i:s') => [
                'type' => $type,
                'data' => $arData,
            ],
        ];

        $file = date('Y-m-d') . '.json';

        if (file_exists($path . $file)) {
            $oldJsonLog = json_decode(file_get_contents($path . $file), true);
            $jsonLog = json_encode(array_merge($dataToJson, $oldJsonLog), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            $jsonLog = json_encode($dataToJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return (bool)file_put_contents($path . $file, $jsonLog);
    }
}