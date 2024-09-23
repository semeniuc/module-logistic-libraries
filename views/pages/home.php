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
//    'ui.hint',
    'ui.alerts',
    'ui.counter'
]);

$view->component('header', $data);

?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h2 class="">Справочники</h2>
        </div>
    </div>

    <?php $view->component('progress'); ?>

    <div id="multiStepForm">
        <!-- Шаг 1: Выбор категории и действия -->
        <div class="step active">
            <?php $view->component('title-section', ['name' => 'Выбор справочника']); ?>
            <?php $view->component('step-first'); ?>
        </div>

        <!-- Шаг 2: Импорт -->
        <div class="step">
            <?php $view->component('title-section', ['name' => 'Импорт данных']); ?>
            <?php $view->component('step-two'); ?>
        </div>

        <!-- Шаг 3: Результат импорта -->
        <div class="step">
            <?php $view->component('title-section', ['name' => 'Результат импорта']); ?>
            <?php $view->component('step-third'); ?>
        </div>

        <!-- Спиннер-->
        <div id="spinner" class="spinner" style="display: none;"></div>
    </div>
</div>

<?php

$view->component('footer');
?>
