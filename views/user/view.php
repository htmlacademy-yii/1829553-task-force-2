<?php

use app\models\Performer;
use Mar4hk0\Helpers\DateTimeHelper;
use Mar4hk0\Helpers\Price;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $performer Performer */
?>
<div class="left-column">
    <h3 class="head-main"><?=Html::encode($performer->name)?></h3>
    <div class="user-card">
        <div class="photo-rate">
            <img class="card-photo" src="<?=Html::encode($performer->getPathAvatar())?>" width="191" height="190" alt="<?=Html::encode($performer->name)?>">
            <div class="card-rate">
                <div class="stars-rating big"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                <span class="current-rate"><?=Html::encode($performer->rating)?></span>
            </div>
        </div>
        <p class="user-description">
            <?=Html::encode($performer->about)?>
        </p>
    </div>
    <div class="specialization-bio">
        <div class="specialization">
            <p class="head-info">Специализации</p>
            <ul class="special-list">
                <?php foreach ($performer->categories as $category): ?>
                    <li class="special-item">
                        <a href="#" class="link link--regular"><?=Html::encode($category->human_name)?></a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="bio">
            <p class="head-info">Био</p>
            <p class="bio-info">
                <span class="country-info">Россия</span>,
                <span class="town-info"><?=Html::encode($performer->city->name)?></span>,
                <span class="age-info"><?=Html::encode($performer->getCurrentAge())?></span> лет
            </p>
        </div>
    </div>
    <h4 class="head-regular">Отзывы заказчиков</h4>
    <div class="response-card">
        <img class="customer-photo" src="img/man-coat.png" width="120" height="127" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <p class="feedback">«Кумар сделал всё в лучшем виде. Буду обращаться к нему в
                будущем, если возникнет такая необходимость!»</p>
            <p class="task">Задание «<a href="#" class="link link--small">Повесить полочку</a>» выполнено</p>
        </div>
        <div class="feedback-wrapper">
            <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
            <p class="info-text"><span class="current-time">25 минут </span>назад</p>
        </div>
    </div>
    <div class="response-card">
        <img class="customer-photo" src="img/man-sweater.png" width="120" height="127" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <p class="feedback">«Кумар сделал всё в лучшем виде. Буду обращаться к нему в
                будущем, если возникнет такая необходимость!»</p>
            <p class="task">Задание «<a href="#" class="link link--small">Повесить полочку</a>» выполнено</p>
        </div>
        <div class="feedback-wrapper">
            <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
            <p class="info-text"><span class="current-time">25 минут </span>назад</p>
        </div>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
        <h4 class="head-card">Статистика исполнителя</h4>
        <dl class="black-list">
            <dt>Всего заказов</dt>
            <dd><?=Html::encode($performer->getNumberTaskCompleted())?> выполнено, <?=Html::encode($performer->getNumberTaskFailed())?> провалено</dd>
            <dt>Место в рейтинге</dt>
            <dd><?=Html::encode($performer->getPlaceRating())?> место</dd>
            <dt>Дата регистрации</dt>
            <dd><?=Html::encode(Yii::$app->formatter->format($performer->created, ['datetime', 'php:j F, H:i']))?></dd>
            <dt>Статус</dt>
            <dd><?=Html::encode($performer->getStatusHuman())?></dd>
        </dl>
    </div>
    <div class="right-card white">
        <h4 class="head-card">Контакты</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="#" class="link link--block link--phone"><?=Html::encode($performer->phone)?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--email"><?=Html::encode($performer->email)?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--tg"><?=Html::encode($performer->telegram)?></a>
            </li>
        </ul>
    </div>
</div>
