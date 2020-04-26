<?
use Framework\Modules\Application;

Application::setPageTitle('Восстановление пароля');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<div class="form">
    <div class="form__item">
        <div class="form__item-title">
            Camagru
        </div>
        <div class="form__item-success" id="js-success-text" style="display: none;">
            <div>
                Для восстановления пароля проверьте ваш почтовый адрес.
            </div>
            <div style="margin-top: 10px;">
                Письмо отправлено на <span id="js-email-text" style="color: #0095F6;">kagestonedragon@gmail.com</span>.
            </div>
        </div>
        <form id="js-form" action="/reset/" method="post" style="margin-top: 55px;">
            <div id="js-form-inner">
                <div class="form__item-error" id="js-error-text" style="visibility: hidden;">error message</div>
                <div class="form__item-elem">
                    <input type="text" name="text" value="" id="js-email" placeholder=" ">
                    <label class="form__item-elem__placeholder" for="js-email">Почтовый адрес</label>
                </div>
                <div class="form__item-elem">
                    <div class="lds-dual-ring" style="display: none; position: absolute; margin-top: 50px; margin-left: 160px;" id="js-preloader"></div>
                    <input class="form__item-elem__submit" id="js-submit-button" style="top: 53px;" type="submit" name="submit" value="Восстановить пароль">
                </div>
            </div>
        </form>
        <a class="form__item-fgtpw" id="js-auth-url" href="/auth/" style="margin-top: 105px; text-align: center; display: block;">Вспомнили пароль?</a>
    </div>
    <div class="form__item" style="height: 64px; margin-top: 15px;">
        <div class="form__item-signup">Нет аккаунта? <a href="/registration/">Зарегистрируйтесь</a></div>
    </div>
    <div class="form__item-github">
        <a href="https://github.com/kagestonedragon/camagru" target="_blank"><img src="/markups/images/github.png"></a>
    </div>
</div>
