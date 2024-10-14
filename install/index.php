<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class logistic_libraries extends CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'logistic.libraries';
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '2024-07-15';
        $this->MODULE_NAME = "Import and export libraries from Excel";
        $this->MODULE_DESCRIPTION = "Import and export libraries from Excel to Smart-processes";
        $this->PARTNER_NAME = "Legende Logistic";
        $this->PARTNER_URI = "http://legende-log.ru/";
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);

        $this->InstallEvents();

        global $APPLICATION;

        $APPLICATION->IncludeAdminFile(
            "Module installed",
            __DIR__ . '/step.php'
        );
    }

    public function DoUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->UnInstallEvents();

        global $APPLICATION;

        $APPLICATION->IncludeAdminFile(
            "Module removed",
            __DIR__ . '/unstep.php'
        );
    }

    public function InstallEvents(): void
    {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandler('main', 'onProlog', $this->MODULE_ID, '\App\Listener\MenuTabListener', 'handler');
        $eventManager->registerEventHandler('main', 'OnBuildGlobalMenu', $this->MODULE_ID, '\App\Listener\MenuAdminTabListener', 'handler');
    }

    public function UnInstallEvents(): void
    {
        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main', 'onProlog', $this->MODULE_ID, '\App\Listener\MenuTabListener', 'handler');
        $eventManager->unRegisterEventHandler('main', 'OnBuildGlobalMenu', $this->MODULE_ID, '\App\Listener\MenuAdminTabListener', 'handler');
    }
}