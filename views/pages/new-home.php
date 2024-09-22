<?php

use App\Kernel\View\View;
use Bitrix\Main\UI\Extension;

/**
 * @var View $view
 * @var $data = []
 * */

Extension::load([
//    'ui.stageflow',
    'ui.buttons',
//    'ui.buttons.icons',
//    'ui.forms',
//    'ui.progressbar',
//    'ui.dialogs.messagebox',
//    'ui.hint',
//    'ui.alerts',
//    'ui.counter'
]);

$view->component('new-header', $data);

?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h2 class="">Справочники</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div id="stage-1" class="stage ">
                Этап 1
            </div>
        </div>
        <div class="col-md-4">
            <div id="stage-2" class="stage active">
                Этап 2
            </div>
        </div>
        <div class="col-md-4">
            <div id="stage-3" class="stage ">
                Этап 3
            </div>
        </div>
    </div>

    <div id="multiStepForm">
        <!-- Шаг 1: Выбор категории и действия -->
        <div class="step active">
            <?php $view->component('step-first'); ?>
        </div>

        <!-- Шаг 2: Импорт -->
        <div class="step">
            <?php $view->component('step-two'); ?>
        </div>

        <!-- Шаг 3: Результат импорта -->
        <div class="step">
            <?php $view->component('step-third'); ?>
        </div>

        <!-- Спиннер-->
        <div id="spinner" class="spinner" style="display: none;"></div>
    </div>
</div>

<?php

$view->component('new-footer');
?>
