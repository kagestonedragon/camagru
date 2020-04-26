<?
use Framework\Modules\Application;

Application::setPageTitle('Авторизация');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<div class="form">
    <div class="form__item">
        <div class="form__item-title">
            Camagru
        </div>
        <form id="js-form" action="/auth/" method="post">
            <div  class="form__item-error" id="js-error-text" style="visibility: hidden;">error message</div>
            <div class="form__item-elem">
                <input type="text" name="text" value="" placeholder=" " id="js-username">
                <label class="form__item-elem__placeholder" for="js-username">Имя пользователя</label>
            </div>
            <div class="form__item-elem">
                <input type="password" name="text" value="" style="margin-top:45px;" id="js-password" placeholder=" ">
                <label class="form__item-elem__placeholder" style="margin-top: 45px" for="js-password">Пароль</label>
            </div>
            <div class="form__item-elem">
                <div class="lds-dual-ring" style="display: block; position: absolute; margin-top: 97px; margin-left: 160px;" id="js-preloader"></div>
                <input class="form__item-elem__submit" id="js-submit-button" style="top: 100px;" type="submit" name="submit" value="Войти">
            </div>
        </form>
        <a class="form__item-fgtpw" href="/reset/" style="margin-top: 150px; text-align: center; display: block;">Забыли пароль?</a>
    </div>
    <div class="form__item" style="height: 64px; margin-top: 15px;">
        <div class="form__item-signup">Нет аккаунта? <a href="/registration/">Зарегистрируйтесь</a></div>
    </div>
    <div class="form__item-github">
        <a href="https://github.com/kagestonedragon/camagru" target="_blank"><img src="/markups/images/github.png"></a>
    </div>
</div>