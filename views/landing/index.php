<?php

/* @var $this yii\web\View */

use Mar4hk0\Helpers\Price;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $tasks array Tasks*/

$length = 70;

?>

<div class="landing-bottom-container">
    <h2>Последние задания на сайте</h2>
    <?php foreach ($tasks as $task):?>
        <?php ?>
        <div class="landing-task">
            <div class="landing-task-top task-<?=Html::encode($task->category->system_name)?>"></div>
            <div class="landing-task-description">
                <h3><a href="#" class="link-regular"><?=StringHelper::truncate(Html::encode($task->title), 15)?>></a></h3>
                <p><?=Html::encode(StringHelper::truncate($task->description, 150))?></p>
            </div>
            <div class="landing-task-info">
                <div class="task-info-left">
                    <p><a href="#" class="link-regular"><?=Html::encode($task->category->human_name)?></a></p>
                    <p><?=Yii::$app->formatter->format($task->created, 'relativetime');?></p>
                </div>
                <span><?=HTML::encode(Price::getPriceHuman($task->price));?></span>
            </div>
        </div>
    <?php endforeach;?>
</div>
<div class="landing-bottom-container">
    <button type="button" class="button red-button">смотреть все задания</button>
</div>
