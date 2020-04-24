<?
use Framework\Modules\Application;

Application::setPageTitle('Регистрация');
Application::attachJsScript(__DIR__ . '/script.js');
?>
<article class="content content__form">
    <div class="form">
        <h2 class="form__title">Регистрация</h2>
        <form class="form__main" method="post" action="/registration/new/" id="js-form">
            <label class="form__item">
                <div></div>
                <input class="form__item-text" type="text" id="js-username" name="username" value="" placeholder="Логин">
                <div></div>
            </label>
            <label class="form__item">
                <div></div>
                <input class="form__item-text" type="email" id="js-email" name="email" value="" placeholder="Почтовый адрес">
                <div></div>
            </label>
            <label class="form__item">
                <div></div>
                <input class="form__item-text" type="password" id="js-password"name="password" value="" placeholder="Пароль">
                <div></div>
            </label>
            <label class="form__item">
                <div></div>
                <input class="form__item-text" type="password" id="js-password-confirm" name="password-confirm" value="" placeholder="Подтверждение пароля">
                <div></div>
            </label>
            <p style="display: none; color: red;" id="js-error">Ошибка ДАДА</p>
            <input class="form__item-submit" type="submit" id="js-submit" value="Зарегистрироваться">
        </form>
        <p style="color: green; display: none;" id="js-success">Ошибка ДАДА</p>
    </div>
</article>