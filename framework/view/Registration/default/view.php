<article class="content content__form">
    <div class="form">
        <h2 class="form__title">Регистрация</h2>
        <form class="form__main" method="post" action="/ajax/registration/" id="js-form">
            <label class="form__item">
                <div class="form__item-desc">Логин</div>
                <input class="form__item-text" type="text" id="js-username" name="username" value="">
            </label>
            <label class="form__item">
                <div class="form__item-desc">Почта</div>
                <input class="form__item-text" type="email" id="js-email" name="email" value="">
            </label>
            <label class="form__item">
                <div class="form__item-desc">Пароль</div>
                <input class="form__item-text" type="password" id="js-password"name="password" value="">
            </label>
            <label class="form__item">
                <div class="form__item-desc">Пароль2 </div>
                <input class="form__item-text" type="password" id="js-password-confirm" name="password-confirm" value="">
            </label>
            <p style="display: none; color: red;" id="js-error">Ошибка ДАДА</p>
            <input class="form__item-submit" type="submit" id="js-submit" value="Зарегистрироваться">
        </form>
        <p style="color: green; display: none;" id="js-success">Ошибка ДАДА</p>
    </div>
</article>

<script>
    function sendAjax(url, username, email, password, password_confirm) {
        const errorText = document.getElementById('js-error');
        const request = new XMLHttpRequest();
        request.open('POST', url);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('username=' + username + '&email=' + email + '&password=' + password + '&password-confirm=' + password_confirm);
        request.addEventListener('readystatechange', function () {
            if (request.readyState === 4 && request.status === 200) {
                const resultAjax = JSON.parse(request.responseText);
                if (parseInt(resultAjax['STATUS']['CODE']) >= 500) {
                    errorText.style.display = 'block';
                    errorText.innerHTML = resultAjax['STATUS']['TEXT'];
                } else {
                    const form = document.getElementById('js-form');
                    const successMessage = document.getElementById('js-success');

                    form.style.display = 'none';
                    successMessage.innerHTML = resultAjax['STATUS']['TEXT'];
                    successMessage.style.display = 'block';
                    //document.location.href = 'https://kagestonedragon.tech';
                }
            }
        });
    }

    const submitButton = document.getElementById('js-submit');
    submitButton.addEventListener('click', function(e) {
        e.preventDefault();
        const errorText = document.getElementById('js-error');
        const url = document.getElementById('js-form').action;
        const username = document.getElementById('js-username').value;
        const email = document.getElementById('js-email').value;
        const password = document.getElementById('js-password').value;
        const password_confirm = document.getElementById('js-password-confirm').value;
        console.log(username);
        console.log(email);

        errorText.style.display = 'none';
        sendAjax(url, username, email, password, password_confirm);
    });
</script>