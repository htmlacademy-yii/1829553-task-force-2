<?php

use app\models\Performer;
use yii\helpers\Url;
use Mar4hk0\Helpers\HTML as CustomHTML;
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
                <?=CustomHTML::starts($performer->rating, 'big')?>
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
    <?php if (!empty($performer->reviews)): ?>
        <h4 class="head-regular">Отзывы заказчиков</h4>
        <?php foreach ($performer->reviews as $review): ?>
            <?php
                $client = $review->client;
                $task = $review->task;
            ?>
            <div class="response-card">
                <img class="customer-photo" src="<?=Html::encode($client->getPathAvatar())?>" width="120" height="127" alt="<?=Html::encode($client->name)?>">
                <div class="feedback-wrapper">
                    <p class="feedback">«<?=Html::encode($review->description)?>»</p>
                    <p class="task">Задание «<a href="<?=URL::to(['tasks/view', 'id' => $task->id]);?>" class="link link--small"><?=Html::encode($task->title);?></a>» выполнено</p>
                </div>
                <div class="feedback-wrapper">
                    <?=CustomHTML::starts($review->grade)?>
                    <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->format($review->created, 'relativetime');?></span></p>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif;?>
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
