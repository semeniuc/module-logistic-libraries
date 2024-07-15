<?php

declare(strict_types=1);

namespace App\Repository;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Service\Factory;
use Bitrix\Main\Loader;

class EntityRepository
{
    private Container $container;

    public function __construct()
    {
        (Loader::includeModule('crm')) ?: die();
        $this->container = Container::getInstance();
    }

    public function getItems(int $entityTypeId): array
    {
        $result = [];

        if ($items = $this->getObjects($entityTypeId)) {
            foreach ($items as $item) {
                $result[] = $item->getData();
            }
        }

        return $result;
    }

    public function deleteItems(int $entityTypeId)
    {
        if ($items = $this->getObjects($entityTypeId)) {
            foreach ($items as $item) {
                $item->delete();
            }
        }
    }

    public function createItems(int $entityTypeId, array $data)
    {
    }

    /**
     * @param int $entityTypeId
     * @return Item []
     */
    private function getObjects(int $entityTypeId): array
    {
        $factory = $this->container->getFactory($entityTypeId);
        return $factory->getItems();
    }
}