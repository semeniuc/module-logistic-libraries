<?php

namespace App\Listener;

use App\Service\LoggingService;

class MenuAdminTabListener
{
    public static $linkTitle = 'Logistic. Импорт справочников';

    public static function handler(&$aGlobalMenu, &$aModuleMenu)
    {
        LoggingService::save([
            '$aGlobalMenu' => $aGlobalMenu,
            '$aModuleMenu' => $aModuleMenu,
        ], 'MenuAdminTab');
        // пример формирования меню можно подсмотреть: /bitrix/modules/[module]/admin/menu.php
        // системные варианты parent_menu: global_menu_desktop, global_menu_content, global_menu_services,
        //global_menu_store, global_menu_statistics, global_menu_marketplace, global_menu_settings
        // это на случай добавления новых пунктов или секций с подпунктами
//        $aModuleMenu[] = array(
//            "parent_menu" => "global_menu_settings",
//            "icon" => "default_menu_icon",
//            "page_icon" => "default_page_icon",
//            "sort" => "900",
//            "text" => "Logistic Libraries",
//            "title" => "Logistic Libraries",
//            "url" => "/local/modules/logistic.libraries/public/index.php/admin",
//            "more_url" => array(),
//        );
        // а это на случай вклинивания в уже существующей секции
        foreach ($aModuleMenu as $key => $menu) :
            // наверно достаточно идентифицировать только по $menu["items_id"]
            if ($menu["parent_menu"] == "global_menu_settings" && $menu["section"] == "TOOLS" && $menu["items_id"] == "menu_util") :
                // пункт добавится в конец списка существующих пунктов в секции
                $aModuleMenu[$key]["items"][] = array(
                    "text" => self::$linkTitle,
                    "title" => self::$linkTitle,
                    "url" => "/local/modules/logistic.libraries/admin",
                    "more_url" => array(),
                );
            endif;

        endforeach;
        /*
        // пример своего глобального раздела меню
        // нужен хотя бы один пункт в глобальном разделе, иначе раздел не появится
        $aModuleMenu[] = array(
           "parent_menu" => "global_menu_custom",
           "icon" => "default_menu_icon",
           "page_icon" => "default_page_icon",
           "sort"=>"100",
           "text"=>"Custom Item Text",
           "title"=>"Custom Item Tille",
           "url"=>"/bitrix/admin/custom_item.php",
           "more_url"=>array(),
        );
        // если нужно добавить глобальный раздел меню, то его можно отдать тут или заранее выше добавить в $aGlobalMenu
        $arRes = array(
           "global_menu_custom" => array(
              "menu_id" => "custom",
              "page_icon" => "services_title_icon",
              "index_icon" => "services_page_icon",
              "text" => "Custom text",
              "title" => "Custom title",
              "sort" => 900,
              "items_id" => "global_menu_custom",
              "help_section" => "custom",
              "items" => array()
           ),
        );
        return $arRes;
        */
    } // function DoBuildGlobalMenu
}