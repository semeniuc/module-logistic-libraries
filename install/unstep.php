<?php

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

if ($ex = $APPLICATION->GetException()) {
    echo CAdminMessage::ShowMessage([
        "TYPE" => "ERROR",
        "MESSAGE" => "Error removing module",
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ]);
} else {
    echo CAdminMessage::ShowNote("Module removed successfully");
}
?>

<form action="<?php echo $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?php echo LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?php echo Loc::getMessage("MOD_BACK"); ?>">
</form>