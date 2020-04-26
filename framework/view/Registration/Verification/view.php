<?
use Framework\Modules\Application;

Application::setPageTitle('Подтверждение аккаунта');

/**
 * @var $result
 */
?>
<div class="form">
    <div class="form__item">
        <div class="form__item-title">
            Camagru
        </div>
        <?if ($result['STATUS']['CODE'] == 200) :?>
            <div class="form__item-success" >
                <div>
                    Регистрация успешно завершена.
                </div>
                <div style="margin-top: 10px;">
                    Теперь вы можете <a href="/auth/" style="color: #0095F6; font-weight: 500;">Войти</a>.
                </div>
            </div>
        <?else:?>
            <div class="form__item-success" id="error">
                <div>
                    Возникла ошибка
                </div>
                <div style="margin-top: 10px; color: #ED495B;">
                    <?=$result['STATUS']['TEXT']?>
                </div>
            </div>
        <?endif;?>
    </div>
    <div class="form__item" style="height: 64px; margin-top: 15px;">
        <div class="form__item-signup">Есть аккаунт? <a href="#">Войдите</a></div>
    </div>
    <div class="form__item-github">
        <a href="https://github.com/kagestonedragon/camagru" target="_blank"><img src="/markups/images/github.png"></a>
    </div>
</div>
