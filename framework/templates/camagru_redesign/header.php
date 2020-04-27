<?
global $USER;

$userLink = '/u/' . $USER->getUsername() . '/';
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/markups/css/normalize.css">
    <link rel="stylesheet" href="/markups/vendor/dist/0.css">
    <link rel="icon" href="/markups/images/favicon.ico">
    <title>Camagru</title>
</head>
<body>
<header>
    <nav class="nav">
        <div class="nav__item-logo">
            <a href="/">Camagru</a>
        </div>
        <div class="nav__item-menu">
            <div id="icon-add-desktop">
                <a href="/add/"><i class="fas fa-plus icons"></i></a>
            </div>
            <!--<div id="icon-notifications-new">
                <a href="#"><i class="fas fa-bell icons"></i></a>
            </div>-->
            <div id="icon-notifications-desktop">
                <a href="/notifications/"><i class="far fa-bell icons"></i></a>
            </div>
            <div class="nav__item-user" id="icon-user-desktop">
                <a href="<?=$userLink?>"><img src="/markups/images/photo.jpg"></a>
            </div>
            <div id="icon-sign-out-desktop">
                <a href="/logout/"><i class="fas fa-sign-out-alt icons"></i></a>
            </div>
        </div>
    </nav>
</header>
<main>