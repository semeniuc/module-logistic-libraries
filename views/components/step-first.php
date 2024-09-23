<?php

?>

<div class="form-group">
    <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown" style="display: inline-block;">
        <div class="ui-ctl-after ui-ctl-icon-angle"></div>
        <select class="ui-ctl-element" id="directoryType" name="directoryType">
            <option value="tariff-library">Справочники тарификатора</option>
        </select>
    </div>
    <span data-hint="Выберите категорию справочников которые Вы планируете экспортировать или импортировать."></span>
</div>
<div id="exportMessage" class="ui-alert ui-alert-close-animate" hidden>
    <span class="ui-alert-message"><strong>Экспорт</strong> успешно завершён. Проверьте папку "Загрузки".</span>
    <span class="ui-alert-close-btn" onclick="this.parentNode.style.display = 'none';"></span>
</div>
<div class="form-group button-to-bottom">
    <button class="ui-btn btn-next" onclick="step(2)">Импорт</button>
    <button class="ui-btn btn-default" onclick="exportData()">Экспорт</button>
</div>
