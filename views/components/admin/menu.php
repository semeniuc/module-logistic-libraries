<?php

global $APPLICATION;

/**
 * @var array $data
 */

// Определение вкладок для панели администратора
$aTabs = [
    ["DIV" => "access", "TAB" => "Доступ", "ICON" => "main_user_edit", "TITLE" => "Уровень доступа к модулю"],
];

// Создание объекта панели вкладок
$tabControl = new CAdminTabControl("tabControl", $aTabs);

// Определение уровней доступа
$aAccess = [
    'd' => '[D] Запретить',
    'r' => '[R] Чтение',
    'u' => '[U] Изменение',
    'w' => '[W] Полный доступ',
];

// Получение списка активных пользователей
$aUsers = [];
$rsUsers = CUser::GetList("id", "asc", ["ACTIVE" => "Y"], ["SELECT" => ["ID", "NAME", "LAST_NAME"]]);
if ($rsUsers) {
    while ($rsUser = $rsUsers->Fetch()) {
        $aUsers[$rsUser['ID']] = $rsUser['NAME'] . ' ' . $rsUser['LAST_NAME'];
    }
}

//dd([
//    'data' => $data,
//    'users' => $aUsers,
//]);
?>

<form method="POST" action="<?= $APPLICATION->GetCurPage() ?>" enctype="multipart/form-data" name="post_form">
    <?php
    // Начало панели вкладок
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    ?>

    <!-- Установка доступа по умолчанию -->
    <tr>
        <td width="40%" class="adm-detail-content-cell-l"><b>По умолчанию:</b></td>
        <td width="60%" class="adm-detail-content-cell-r">
            <select name="default_for_all" id="default_for_all">
                <?php
                foreach ($aAccess as $k => $v) {
                    if ($data['all'] == $k) {
                        echo "<option value=\"$k\" selected>$v</option>";
                        unset($data['all']);
                    } else {
                        echo "<option value=\"$k\">$v</option>";
                    }
                }
                ?>
            </select>
        </td>
    </tr>

    <!-- Добавить текущие настройки -->
    <?php
    foreach ($data as $user => $access) {
        echo "<tr>";
        // Добавление пользователя
        echo "<td class=\"adm-detail-content-cell-l\">";
        echo "<select style=\"width:300px\">";
        foreach ($aUsers as $id => $name) {
            if ($user == 'user_' . $id) {
                echo "<option value=\"$id\" selected>$name</option>";
            } else {
                echo "<option value=\"$id\">$name</option>";
            }
        }
        echo "</select>";
        echo "</td>";

        // Добавление прав
        echo "<td class=\"adm-detail-content-cell-r\">";
        echo "<select name=\"$user\">";
        foreach ($aAccess as $k => $strName) {
            if ($access == $k) {
                echo "<option value=\"$k\" selected>$strName</option>";
            } else {
                echo "<option value=\"$k\">$strName</option>";
            }
        }
        echo "</select>";
        echo "</td>";

        // Кнопка "Удалить"
        echo "
         <td>
            <a href=\"javascript:void(0)\" onclick=\"removeRow(this)\" class=\"adm-btn adm-btn-remove\">
                <span class=\"adm-btn-icon\">удалить</span>
            </a>
        </td>";
        echo "</tr>";
    }

    ?>

    <!-- Выбор пользователя и уровня доступа -->
    <tr>
        <td class="adm-detail-content-cell-l">
            <select style="width:300px" onchange="settingsSetUserID(this)">
                <option value="">(выберите пользователя)</option>
                <?php foreach ($aUsers as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td class="adm-detail-content-cell-r">
            <select name="" id="">
                <option value="">&lt; по умолчанию &gt;</option>
                <?php foreach ($aAccess as $k => $v): ?>
                    <option value="<?= $k ?>"><?= $v ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <a href="javascript:void(0)" onclick="removeRow(this)" class="adm-btn adm-btn-remove">
                <span class="adm-btn-icon">удалить</span>
            </a>
        </td>
    </tr>

    <!-- Кнопка добавления права доступа -->
    <tr>
        <td class="adm-detail-content-cell-l">&nbsp;</td>
        <td style="padding-bottom:10px;" class="adm-detail-content-cell-r">
            <script>
                // Функция для установки имени поля с правами доступа
                function settingsSetUserID(el) {
                    var tr = jsUtils.FindParentObject(el, "tr");
                    var sel = jsUtils.FindChildObject(tr.cells[1], "select");
                    sel.name = "user_" + el.value;
                }

                // Функция для добавления нового права доступа
                function settingsAddRights(a) {
                    var row = jsUtils.FindParentObject(a, "tr");
                    var tbl = row.parentNode;

                    var tableRow = tbl.rows[row.rowIndex - 1].cloneNode(true);
                    tbl.insertBefore(tableRow, row);

                    var sel = jsUtils.FindChildObject(tableRow.cells[0], "select");
                    sel.selectedIndex = 0;
                }

                // Функция для удаления строки
                function removeRow(el) {
                    var tr = jsUtils.FindParentObject(el, "tr");
                    tr.parentNode.removeChild(tr);
                }
            </script>
            <a href="javascript:void(0)" onclick="settingsAddRights(this)" hidefocus="true" class="adm-btn">
                Добавить право доступа
            </a>
        </td>
    </tr>

    <!-- Кнопки сохранения -->
    <?php $tabControl->Buttons(); ?>

    <div class="adm-detail-content-btns-wrap" id="tabControl_buttons_div" style="left: 0px;">
        <div class="adm-detail-content-btns">
            <input type="submit" name="button" value="Сохранить" title="Сохранить изменения и вернуться"
                   class="adm-btn-save">
            <input type="submit" name="button" value="Применить" title="Сохранить изменения и остаться в форме">
            <input type="submit" name="button" title="Установить значения по умолчанию"
                   onclick="return confirm('Внимание! Все настройки будут перезаписаны значениями по умолчанию. Продолжить?')"
                   value="По умолчанию">
        </div>
    </div>

    <?php
    // Завершение панели вкладок
    $tabControl->End();
    ?>
</form>
