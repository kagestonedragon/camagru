<?php
/**
 * @var $result
 */
use Framework\Models\Auth\Authorize;
?>
<?if (isset($result['status'])) :?>
    <?if ($result['status'] == Authorize::STATUS['NOT_VALID_DATA']) :?>
        <p>Не верные данные!</p>
    <?elseif ($result['status'] == Authorize::STATUS['NOT_VERIFIED']) :?>
        <p>Аккаунт не подтвержден!</p>
    <?endif;?>
<?endif;?>
<article class="content">
    <div class="form">
        <h2 class="form__title">Авторизация</h2>
        <form class="form__main" method="post">
            <label class="form__item">
                <div class="form__item-desc">Логин</div>
                <input class="form__item-text" type="text" name="username" value="">
            </label>
            <label class="form__item">
                <div class="form__item-desc">Пароль</div>
                <input class="form__item-text" type="password" name="password" value="">
            </label>
            <input class="form__item-submit" type="submit" value="Войти">
        </form>
    </div>
</article>