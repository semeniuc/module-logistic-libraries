<?php

?>

<div id="importNotification">
    <div>
        <span>Добавлено записей: </span>
        <div class="ui-counter  ui-counter-lg ui-counter-success">
            <div id="successCount" class="ui-counter-inner">0</div>
        </div>
    </div>
    <div>
        <span>Кол-во ошибок: </span>
        <div class="ui-counter  ui-counter-lg">
            <div id="errorCount" class="ui-counter-inner">0</div>
        </div>
    </div>
</div>

<div id="importSummary">
    <div class="row">
        <div class="col">
            <table class="table table-bordered" id="errorTable">
                <thead>
                <tr>
                    <th>Лист</th>
                    <th class="narrow-column">№</th>
                    <th>Ошибка</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div id="btn-area">
                <button id="btn-close" class="ui-btn btn-default">Завершить</button>
                <button id="btn-to-up" class="ui-btn  btn-default ui-btn-icon-angle-up"
                        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"></button>
            </div>
        </div>
    </div>
</div>