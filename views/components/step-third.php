<?php

?>

<h4>Результат импорта</h4>
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
    <div>
        <button class="ui-btn" onclick="step(1)">Вернуться</button>
        <button class="ui-btn ui-btn-icon-angle-up"></button>
    </div>
    <div id="pagination" class="pagination">
        <button id="back" class="ui-btn ui-btn-icon-back"></button>
        <button id="next" class="ui-btn ui-btn-icon-forward"></button>
    </div>
</div>
