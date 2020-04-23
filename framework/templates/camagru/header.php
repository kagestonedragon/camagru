<?php
global $USER;
use Framework\Modules\Application;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/markups/css/normalize.css">
    <link rel="stylesheet" href="/markups/vendor/dist/0.css">
    <link rel="icon" href="/markups/favicon.ico">
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