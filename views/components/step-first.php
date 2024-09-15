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
<div class="ui-alert ui-alert-close-animate">
    <span class="ui-alert-message"><strong>Внимание!</strong> Текст предупреждения находится здесь.</span>
    <span class="ui-alert-close-btn" onclick="this.parentNode.style.display = 'none';"></span>
</div>
<div class="form-group">
    <button class="ui-btn ui-btn-icon-download" onclick="exportData()">Экспорт</button>
    <button class="ui-btn ui-btn-icon-add" onclick="step(2)">Импорт</button>
</div>
