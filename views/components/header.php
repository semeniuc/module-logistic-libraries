<?php
/**
 * @var $title
 */
$publicDirectory = dirname($_SERVER['SCRIPT_NAME']);

global $APPLICATION;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <?php
    $APPLICATION->ShowCSS(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $publicDirectory ?>/assets/css/main.css?101" rel="stylesheet">
</head>
<body>
