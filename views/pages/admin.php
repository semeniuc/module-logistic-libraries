<?php

use App\Kernel\View\View;
use Bitrix\Main\UI\Extension;

/**
 * @var View $view
 * @var $data = []
 * */

//Extension::load([
//    'ui.buttons',
//    'ui.buttons.icons',
//    'ui.forms',
//    'ui.alerts',
//    'ui.counter',
//    'sidepanel',
//]);

$view->component('header', $data);

?>

    <p>Adminpanel</p>

<?php

$view->component('footer');

