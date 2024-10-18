<?php

namespace App\Listener;

class MenuAdminTabListener
{
    public static $linkTitle = 'Logistic. Импорт справочников';

    public static function handler(&$aGlobalMenu, &$aModuleMenu)
    {
        foreach ($aModuleMenu as $key => $menu) {
            if ($menu["parent_menu"] == "global_menu_settings"
                && $menu["section"] == "MAIN"
                && $menu["items_id"] == "menu_system"
            ) {
                $aModuleMenu[$key]["items"][] = array(
                    "text" => self::$linkTitle,
                    "title" => self::$linkTitle,
                    "url" => "/local/modules/logistic.libraries/admin",
                    "more_url" => array(),
                );
            }
        }
    }
}