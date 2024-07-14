<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Bitrix24ConnectService;
use App\Service\LoggingService;

class EntityRepository
{
    public function get(int $entityTypeId): array
    {
        $method = 'crm.item.list';
        $request = Bitrix24ConnectService::call($method, ['entityTypeId' => $entityTypeId]);
        return $this->response($request)['items'] ?? [];
    }

    public function add(int $entityTypeId, array $dataBatch): array
    {
        $method = 'batch';
        $request = Bitrix24ConnectService::call($method, ['entityTypeId' => $entityTypeId, 'data' => $dataBatch]);
        return $this->response($request)['items'] ?? [];
    }

    public function delete(int $entityTypeId, array $dataBatch)
    {
        $method = 'crm.item.delete';
        $request = Bitrix24ConnectService::call($method, ['entityTypeId' => $entityTypeId, 'data' => $dataBatch]);
        return $this->response($request)['items'] ?? [];
    }

    private function response(array $response)
    {
        if (!isset($response['result'])) {
            LoggingService::save([
                'response' => $response,
            ], 'http', 'bitrix');
            return [];
        }

        return $response['result'];
    }
}