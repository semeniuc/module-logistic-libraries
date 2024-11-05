<?php

declare(strict_types=1);

namespace App\Listener;

use App\Service\Admin\AdminService;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__, 2) . '/.env');

define("APP_ENV", $_SERVER['APP_ENV']);
define("APP_URL", $_SERVER['APP_URL']);

class MenuTabListener
{
    public static function handler()
    {
        if (self::isAccess()) {
            global $APPLICATION;
            $APPLICATION->AddHeadScript('/local/modules/logistic.libraries/public/assets/js/view/menuTab.js');
        }
    }

    private static function isAccess(): bool
    {
        global $USER;
        $currentUser = 'user_' . $USER->getId();

        $adminService = new AdminService();
        $settings = $adminService->read();

        if (!empty($settings)) {
            if ($settings['all'] !== 'd') {
                return true;
            } else {
                foreach ($settings as $user => $access) {
                    if ($currentUser === $user) {
                        if ($access !== 'd') {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}