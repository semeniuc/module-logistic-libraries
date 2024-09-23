<?php

?>

<form id="importForm" enctype="multipart/form-data">
    <div class="form-group">
        <label class="ui-ctl ui-ctl-file-btn">
            <input type="file" class="ui-ctl-element" id="excelFile" name="excelFile" accept=".xlsx" required>
            <div class="ui-ctl-label-text">Прикрепить файл</div>
        </label>
        <span id="file-message" class="file-message" style="margin-left: 10px;">Файл не выбран</span>
    </div>
    <div class="form-group button-to-bottom">
        <button id="submitBtn" class="ui-btn btn-next" onclick="importData()" disabled>Отправить</button>
        <button class="ui-btn btn-default" onclick="step(1)">Вернуться</button>
    </div>
</form>
