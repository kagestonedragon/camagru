<?php
/**
 * @var $result
 */
use Framework\Models\Auth\Authorize;
?>
<article class="content content__form">
    <div class="form">
        <h2 class="form__title">Авторизация</h2>
        <form class="form__main" id="js-form" method="post" action="/ajax/auth/">
            <label class="form__item">
                <div class="form__item-desc">Логин</div>
                <input class="form__item-text" id="js-login" type="text" name="username" value="">
            </label>
            <label class="form__item">
                <div class="form__item-desc">Пароль</div>
                <input class="form__item-text" id="js-password" type="password" name="password" value="">
            </label>
            <p style="display: none; color: red;" id="js-error">Ошибка ДАДА</p>
            <input class="form__item-submit" id="js-button" type="submit" value="Войти">
        </form>
    </div>
</article>

<script>
    function sendAjax(url, login, password) {
        const errorText = document.getElementById('js-error');
        const request = new XMLHttpRequest();
        request.open('POST', url);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('username=' + login + '&password=' + password);
        request.addEventListener('readystatechange', function () {
            if (request.readyState === 4 && request.status === 200) {
                const resultAjax = JSON.parse(request.responseText);
                if (parseInt(resultAjax['status']['CODE']) >= 500) {
                    errorText.style.display = 'block';
                    errorText.innerHTML = resultAjax['status']['TEXT'];

                    console.log(errorText);
                }
                console.log(resultAjax);
                //return (resultAjax);
            }
        });
    }
    const submitButton = document.getElementById('js-button');

    submitButton.addEventListener('click', function(e){
        e.preventDefault();
        const errorText = document.getElementById('js-error');
        const url = document.getElementById('js-form').action;
        const login = document.getElementById('js-login').value;
        const password = document.getElementById('js-password').value;
        errorText.style.display = 'none';

        const resultAjax = sendAjax(url, login, password);
        //console.log(resultAjax);
    });
</script>