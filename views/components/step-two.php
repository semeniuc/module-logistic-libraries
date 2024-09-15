<?php

?>

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
