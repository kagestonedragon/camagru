<?
use Framework\Modules\Application;

Application::setPageTitle('Регистрация');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<div class="form">
    <div class="form__item">
        <div class="form__item-title" style="margin-top: 20px;">
            Camagru
        </div>
        <div class="form__item-success" id="js-success-text" style="display: none;">
            <div>
                Для завершения регистрации подтвердите почтовый адрес.
            </div>
            <div style="margin-top: 10px;">
                Письмо отправлено на <span id="js-email-text" style="color: #0095F6;">kagestonedragon@gmail.com</span>.
            </div>
        </div>
        <form id='js-form' action="/registration/" method="POST" style="margin-top: 5px;">
            <div id="js-form-inner">
                <div  class="form__item-error" id="js-error-text" style="visibility: hidden;">error message</div>
                <div class="form__item-elem">
                    <input type="text" name="text" value="" id="js-username" placeholder=" ">
                    <label class="form__item-elem__placeholder" for="js-username">Имя пользователя</label>
                </div>
                <div class="form__item-elem">
                    <input type="text" name="text" value="" style="margin-top:45px;" id="js-email" placeholder=" ">
                    <label class="form__item-elem__placeholder" style="margin-top:45px;" for="js-email">Почтовый адрес</label>
                </div>
                <div class="form__item-elem">
                    <input type="password" name="text" value="" style="margin-top:90px;" id="js-password" placeholder=" ">
                    <label class="form__item-elem__placeholder" style="margin-top:90px;" for="js-password">Пароль</label>
                </div>
                <div class="form__item-elem">
                    <input type="password" name="text" value="" style="margin-top:135px;" id="js-password-confirm" placeholder=" ">
                    <label class="form__item-elem__placeholder" style="margin-top:135px;" for="js-password-confirm">Подтверждение пароля</label>
                </div>
                <div class="form__item-elem">
                    <div class="lds-dual-ring" style="display: none; position: absolute; margin-top: 190px; margin-left: 160px;" id="js-preloader"></div>
                    <input class="form__item-elem__submit" id="js-submit-button" style="top: 190px;" type="submit" name="submit" value="Зарегистрироваться">
                </div>
            </div>
        </form>
    </div>
    <div class="form__item" style="height: 64px; margin-top: 15px;">
        <div class="form__item-signup">Есть аккаунт? <a href="/auth/">Войдите</a></div>
    </div>
    <div class="form__item-github">
        <a href="https://github.com/kagestonedragon/camagru" target="_blank">
            <img src="/markups/images/github.png">
        </a>
    </div>
</div>

