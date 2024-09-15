<?php

use App\Kernel\View\View;
use Bitrix\Main\UI\Extension;

/**
 * @var View $view
 * @var $data = []
 * */

Extension::load([
    'ui.buttons',
    'ui.buttons.icons',
    'ui.forms',
    'ui.progressbar',
    'ui.dialogs.messagebox',
    'ui.hint',
    'ui.alerts',
    'ui.counter'
]);

$view->component('header', $data);

?>

<div class="container mt-5">
    <h2 class="">Справочники</h2>
    <div class="ui-progressbar ui-progressbar-lg ui-progressbar-success mb-3">
        <div class="ui-progressbar-track">
            <div id="progressBar" class="ui-progressbar-bar" style="width:30%;"></div>
        </div>
    </div>
    <div id="multiStepForm">
        <!-- Шаг 1: Выбор категории и действия -->
        <div class="step">
            <?php $view->component('step-first'); ?>
        </div>

        <!-- Шаг 2: Импорт -->
        <div class="step">
            <?php $view->component('step-two'); ?>
        </div>

        <!-- Шаг 3: Результат импорта -->
        <div class="step active">
            <?php $view->component('step-third'); ?>
        </div>

        <!-- Спиннер-->
        <div id="spinner" class="spinner" style="display: none;"></div>
    </div>
</div>
<?php

$view->component('footer'); ?>
