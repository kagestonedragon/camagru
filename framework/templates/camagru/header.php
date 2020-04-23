<?php
global $USER;
use Framework\Modules\Application;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/framework/templates/camagru/css/normalize.css">
    <link rel="stylesheet" href="/framework/templates/camagru/css/styles.css">
    <link rel="icon" href="/framework/templates/camagru/favicon.ico">
    <title>Camagru</title>
</head>
<body>
    <header>
        <?if ($USER->isAuthorized()):?>
            <?Application::loadView('Profile^header')?>
        <?else:?>
            <?Application::loadView('Auth^links')?>
        <?endif;?>
    </header>
    <main>