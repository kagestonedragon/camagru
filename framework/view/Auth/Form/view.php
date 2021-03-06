<?
use Framework\Modules\Application;

Application::setPageTitle('Авторизация');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<article class="content content__form">
    <div class="form">
        <h2 class="form__title">Авторизация</h2>
        <form class="form__main" id="js-form" method="post" action="/auth/">
            <label class="form__item">
                <div class="form__item-desc">Логин</div>
                <input class="form__item-text" id="js-login" type="text" name="username" value="">
            </label>
            <label class="form__item">
                <div class="form__item-desc">Пароль</div>
                <input class="form__item-text" id="js-password" type="password" name="password" value="">
            </label>
            <div class="loader" id='js-preloader' style="display: none;">Loading...</div>
            <p class="form__item-error" id="js-error" style="display: none;">Ошибка</p>
            <input class="form__item-submit" id="js-button" type="submit" value="Войти">
        </form>
    </div>
</article>