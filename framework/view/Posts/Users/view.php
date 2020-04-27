<?php
global $USER;

/**
 * @var $result
 */
$userName = $USER->getUsername();
$userLink = '/u/' . $userName . '/';
?>
<section class="users">
    <div class="users__item-current">
        <a href="<?=$userLink?>">
            <img class="users__item-current__img" src="/markups/images/photo.jpg">
        </a>
        <div class="users__item-current__name">
            <a href="<?=$userLink?>">
                <?=$userName?>
            </a>
        </div>
    </div>
    <div class="users__item-new">
        <div class="users__item-new__title">
            <div class="users__item-new__title-new">Новые</div>
            <div class="users__item-new__title-all">Все</div>
        </div>
        <?foreach ($result as $keyValue => $itemValue) :?>
            <?$userName = $itemValue['username']?>
            <?$userLink = '/u/' . $userName . '/'?>
            <div class="users__item-new__item">
                <a href="<?=$userLink?>">
                    <img class="users__item-new__item-img" src="/markups/images/photo.jpg">
                </a>
                <div class="users__item-new__item-name">
                    <a href="<?=$userLink?>">
                        <?=$userName?>
                    </a>
                </div>
            </div>
        <?endforeach;?>
    </div>
</section>