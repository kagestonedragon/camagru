<?
use Framework\Modules\Application;
global $REQUEST;

Application::setPageTitle('Восстановление пароля');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<div class="form">
    <div class="form__item">
        <div class="form__item-title">
            Camagru
        </div>
        <form action="<?=$_SERVER['REQUEST_URI']?>" method="post" style="margin-top: 20px;">
            <div  class="form__item-error" id="js-error-text" style="visibility: hidden;">error message</div>
            <div class="form__item-elem">
                <input type="text" name="text" disabled value="<?=$REQUEST->arGet['USERNAME']?>" id="js-username" placeholder=" ">
                <label class="form__item-elem__placeholder" for="js-username">Имя пользователя</label>
            </div>
            <div class="form__item-elem">
                <input type="password" name="text" value="" style="margin-top:45px;" id="js-password" placeholder=" ">
                <label class="form__item-elem__placeholder" style="margin-top: 45px" for="js-password">Новый пароль</label>
            </div>
            <div class="form__item-elem">
                <input type="password" name="text" value="" style="margin-top:90px;" id="js-password-confirm" placeholder=" ">
                <label class="form__item-elem__placeholder" style="margin-top: 90px" for="js-password-confirm">Подтвержение пароля</label>
            </div>
            <div class="form__item-elem">
                <div class="lds-dual-ring" style="display: none; position: absolute; margin-top: 145px; margin-left: 160px;" id="js-preloader"></div>
                <input class="form__item-elem__submit" id="js-submit-button" style="top: 145px;" type="submit" name="submit" value="Сбросить пароль">
            </div>
            <input type="hidden" value="<?=$REQUEST->arGet['TOKEN']?>">
        </form>
    </div>
    <div class="form__item" style="height: 64px; margin-top: 15px;">
        <div class="form__item-signup">Нет аккаунта? <a href="#">Зарегистрируйтесь</a></div>
    </div>
    <div class="form__item-github">
        <a href="https://github.com/kagestonedragon/camagru" target="_blank"><img src="/markups/images/github.png"></a>
    </div>
</div>
