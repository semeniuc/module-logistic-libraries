<?php

use App\Kernel\View\View;
use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

/**
 * @var View $view
 * @var $data = []
 * */

global $USER;
global $APPLICATION;

// Проверка
$module_id = $data['module_id'];

if (!Loader::includeModule($module_id)) {
    echo 'Ошибка подключения модуля.';
}

if (!$USER->IsAdmin()) {
    echo 'Недостаточно прав для отображения админ меню.';
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php";

// Интерфейс
$view->component('admin/menu', $data['access']);

?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentUrl = window.location.href;
            const targetPath = "/local/modules/logistic.libraries/admin";
            const newPath = "/bitrix/admin/logistic.libraries";

            if (currentUrl.includes(targetPath)) {
                const newUrl = currentUrl.replace(targetPath, newPath);
                window.history.replaceState(null, '', newUrl);
            }
        });
    </script>

<?php

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";