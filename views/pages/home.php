<?php

use App\Kernel\View\View;

/**
 * @var View $view
 * @var $data = []
 * */

$view->component('header', $data);

?>

<div class="container mt-5">
    <h2 class="text-center">Справочники</h2>
    <div class="progress mb-4">
        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50"
             aria-valuemin="0" aria-valuemax="100">Этап 1
        </div>
    </div>
    <div id="multiStepForm">
        <!-- Шаг 1: Выбор категории и действия -->

        <div class="step active">
            <div class="col-md-4 text-center">
                <div class="form-group">
                    <select class="form-control" id="directoryType" name="directoryType">
                        <option value="tariff-library">Справочники тарификатора</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="form-group">
                    <button type="button" class="btn btn-secondary w-100" onclick="exportData()">Экспорт</button>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <button type="button" class="btn btn-primary w-100" onclick="showImport()">Импорт</button>
            </div>
        </div>

        <!-- Шаг 2: Импорт -->
        <div class="step" id="importStep">
            <h4>Импорт данных</h4>
            <form id="importForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="excelFile">Выберите файл:</label>
                    <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".xlsx"
                           required>
                </div>
                <button type="button" class="btn btn-secondary mt-3" onclick="step(1)">Вернуться</button>
                <button type="button" class="btn btn-primary" onclick="importData()">Отправить</button>
            </form>
        </div>

        <!-- Шаг 3: Результат импорта -->
        <div class="step">
            <h4>Результат импорта</h4>
            <div id="importSummary">
                <p>Успешно добавлено записей: <span id="successCount">0</span></p>
                <p>Кол-во записей с ошибками: <span id="errorCount">0</span></p>
                <div id="errorDetails"></div>
                <table class="table table-bordered mt-3" id="errorTable" style="display: none;">
                    <thead>
                    <tr>
                        <th>№ строки</th>
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

<?php

$view->component('footer'); ?>
