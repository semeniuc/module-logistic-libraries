<?php

declare(strict_types=1);

namespace App\Listener;

class MenuTabListener
{
    public static function handler()
    {
        global $APPLICATION;
        $APPLICATION->AddHeadScript('/local/modules/logistic.libraries/public/assets/js/view/menuTab.js');
    }
}