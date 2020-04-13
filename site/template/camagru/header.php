<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/markups/css/normalize.css">
    <link rel="stylesheet" href="/markups/vendor/dist/0.css">
    <title>Camagru</title>
</head>
<body>
    <header>
        <?if ($USER->isAuthorized()):?>
            <?$APPLICATION->loadView('Profile.header')?>
        <?else:?>
            <?$APPLICATION->loadView('Auth.links')?>
        <?endif;?>
    </header>
    <main>