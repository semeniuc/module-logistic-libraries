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
        <table class="table table-bordered mt-3" id="errorTable">
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
    </div>
    <div class="row" id="buttonRow">
        <div class="left-buttons">
            <button class="ui-btn" onclick="step(1)">Вернуться</button>
            <button class="ui-btn ui-btn-icon-angle-up"
                    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"></button>
        </div>
        <div id="pagination" class="right-buttons">
            <button id="prevBtn" class="ui-btn ui-btn-icon-back"></button>
            <button id="nextBtn" class="ui-btn ui-btn-icon-forward"></button>
        </div>
    </div>
</div>