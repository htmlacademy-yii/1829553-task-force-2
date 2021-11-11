<?php

use app\models\Task;
use Mar4hk0\Helpers\DateTimeHelper;
use Mar4hk0\Helpers\Price;
use yii\helpers\Html;
use Mar4hk0\Helpers\HTML as CustomHTML;

/* @var $this yii\web\View */
/* @var $task Task */
?>
<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?=HTML::encode($task->title);?></h3>
        <p class="price price--big"><?=HTML::encode(Price::getPriceHuman($task->price));?></p>
    </div>
    <p class="task-description"><?=HTML::encode($task->description);?></p>
    <a href="#" class="button button--blue">Откликнуться на задание</a>
    <div class="task-map">
        <img class="map" src="/img/map.png"  width="725" height="346" alt="Новый арбат, 23, к. 1">
        <p class="map-address town">Москва</p>
        <p class="map-address">Новый арбат, 23, к. 1</p>
    </div>


    <?php if (!empty($task->bids)): ?>
        <h4 class="head-regular">Отклики на задание</h4>
        <?php foreach ($task->bids as $bid): ?>
            <?php $performer = $bid->performer;?>
            <div class="response-card">
                <img class="customer-photo" src="<?=HTML::encode($performer->getPathAvatar());?>"
                     width="146" height="156" alt="<?=HTML::encode($performer->name)?>">
                <div class="feedback-wrapper">
                    <a href="#" class="link link--block link--big"><?=HTML::encode($performer->name)?></a>
                    <div class="response-wrapper">
                        <?=CustomHTML::starts($performer->rating, 'big')?>
                        <p class="reviews"><?=Html::encode($performer->getReviews()->count())?> отзыва</p>
                    </div>
                    <p class="response-message">
                        <?=HTML::encode($bid->description)?>.
                    </p>
                </div>
                <div class="feedback-wrapper">
                    <p class="info-text">
                        <span class="current-time">
                            <?=Yii::$app->formatter->format($bid->created, 'relativetime');?>
                        </span>
                    </p>
                    <p class="price price--small"><?=Html::encode(Price::getPriceHuman($bid->price))?></p>
                </div>
                <div class="button-popup">
                    <a href="#" class="button button--blue button--small">Принять</a>
                    <a href="#" class="button button--orange button--small">Отказать</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?=HTML::encode($task->category->human_name);?></dd>
            <dt>Дата публикации</dt>
            <dd><?=HTML::encode(DateTimeHelper::convertTimeToRelative($task->created))?></dd>
            <dt>Срок выполнения</dt>
            <dd><?=HTML::encode($task->getDeadlineHuman())?></dd>
            <dt>Статус</dt>
            <dd><?=HTML::encode($task->status->human_name)?></dd>
        </dl>
    </div>
    <div class="right-card white file-card">
        <h4 class="head-card">Файлы задания</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="#" class="link link--block link--clip">my_picture.jpg</a>
                <p class="file-size">356 Кб</p>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--clip">information.docx</a>
                <p class="file-size">12 Кб</p>
            </li>
        </ul>
    </div>
</div>
