<?php

global $APPLICATION;

$aTabs = [
    ["DIV" => "access", "TAB" => "Доступ", "ICON" => "main_user_edit", "TITLE" => "Уровень доступа к модулю"],
];

$tabControl = new CAdminTabControl("tabControl", $aTabs);

$tabControl->Begin();
$tabControl->BeginNextTab();

$aAccess = [
    'd' => '[D] Запретить',
    'r' => '[R] Чтение',
    'u' => '[U] Изменение',
    'w' => '[W] Полный доступ',
];

$aUsers = [];
$rsUsers = CUser::GetList("id", "asc", ["ACTIVE" => "Y"], ["SELECT" => ["ID", "NAME", "LAST_NAME"]]);
if ($rsUsers) {
    while ($rsUser = $rsUsers->Fetch()) {
        $aUsers[$rsUser['ID']] = $rsUser['NAME'] . ' ' . $rsUser['LAST_NAME'];
    }
}

?>

    <form method="POST" Action="<?= $APPLICATION->GetCurPage() ?>" ENCTYPE="multipart/form-data" name="post_form">
        <table class="adm-detail-content-table edit-table" id="edit_table" style="opacity: 1;">
            <tbody>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l"><b>По умолчанию:</b></td>
                <td width="60%" class="adm-detail-content-cell-r">
                    <select class="typeselect" name="GROUP_DEFAULT_TASK" id="GROUP_DEFAULT_TASK">
                        <?php foreach ($aAccess as $k => $v): ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="adm-detail-content-cell-l">
                    <select style="width:300px" onchange="settingsSetGroupID(this)">
                        <option value="">(выберите пользователя)</option>
                        <?php foreach ($aUsers as $id => $name): ?>
                            <option value="<?= $id ?>"><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="adm-detail-content-cell-r">
                    <select class="typeselect" name="" id="">
                        <option value="">&lt; по умолчанию &gt;</option>
                        <?php foreach ($aAccess as $k => $v): ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="adm-detail-content-cell-l">&nbsp;</td>
                <td style="padding-bottom:10px;" class="adm-detail-content-cell-r">
                    <script>
                        function settingsSetGroupID(el) {
                            var tr = jsUtils.FindParentObject(el, "tr");
                            var sel = jsUtils.FindChildObject(tr.cells[1], "select");
                            sel.name = "TASKS_" + el.value;
                        }

                        function settingsAddRights(a) {
                            var row = jsUtils.FindParentObject(a, "tr");
                            var tbl = row.parentNode;

                            var tableRow = tbl.rows[row.rowIndex - 1].cloneNode(true);
                            tbl.insertBefore(tableRow, row);

                            var sel = jsUtils.FindChildObject(tableRow.cells[1], "select");
                            sel.name = "";
                            sel.selectedIndex = 0;

                            sel = jsUtils.FindChildObject(tableRow.cells[0], "select");
                            sel.selectedIndex = 0;
                        }
                    </script>
                    <a href="javascript:void(0)" onclick="settingsAddRights(this)" hidefocus="true" class="adm-btn">Добавить
                        право доступа</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>

<?php

$tabControl->Buttons();

$tabControl->End();

?>