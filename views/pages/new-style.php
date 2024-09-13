<?php

use App\Kernel\View\View;
use Bitrix\Main\UI\Extension;

/**
 * @var View $view
 * @var $data = []
 * */

Extension::load(['ui.buttons', 'ui.buttons.icons', 'ui.forms', 'ui.progressbar', 'ui.dialogs.messagebox', 'ui.hint']);

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

        <div class="step active">
            <div class="form-group">
                <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown" style="display: inline-block;">
                    <div class="ui-ctl-after ui-ctl-icon-angle"></div>
                    <select class="ui-ctl-element" id="directoryType" name="directoryType">
                        <option value="tariff-library">Справочники тарификатора</option>
                    </select>
                </div>
                <span data-hint="Выберите категорию справочников которые Вы планируете экспортировать или импортировать."></span>
            </div>
            <div class="form-group">
                <button class="ui-btn ui-btn-icon-download" onclick="exportData()">Экспорт</button>
                <button class="ui-btn ui-btn-icon-add" onclick="step(2)">Импорт</button>
            </div>
        </div>

        <!-- Шаг 2: Импорт -->
        <div class="step" id="importStep">
            <h4>Импорт данных</h4>
            <form id="importForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="ui-ctl ui-ctl-file-drop" id="fileDropArea">
                        <div class="ui-ctl-label-text">
                            <span>Выберите и загрузите файл</span>
                            <small>Поддерживаются файлы с расширением ".xlsx"</small>
                        </div>
                        <input type="file" class="ui-ctl-element" id="excelFile" name="excelFile"
                               accept=".xlsx"
                               required>
                    </label>
                </div>
                <div class="form-group">
                    <button class="ui-btn" onclick="step(1)">Вернуться</button>
                    <button id="submitBtn" class="ui-btn ui-btn-success" onclick="importData()" disabled>Отправить
                    </button>
                </div>
            </form>
        </div>

        <!-- Шаг 3: Результат импорта -->
        <div class="step">
            <h4>Результат импорта</h4>
            <div id="importSummary">
                <p>Успешно добавлено записей: <span id="successCount">0</span></p>
                <p>Кол-во записей с ошибками: <span id="errorCount">0</span></p>
                <div id="errorDetails">
                    <table class="table table-bordered mt-3" id="errorTable">
                        <thead>
                        <tr>
                            <th>Лист</th>
                            <th class="narrow-column">№</th>
                            <th>Ошибка</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-secondary" onclick="step(1)">Вернуться</button>
            </div>
        </div>
        <div id="spinner" class="spinner" style="display: none;"></div>
    </div>
</div>
<?php

$view->component('footer'); ?>
