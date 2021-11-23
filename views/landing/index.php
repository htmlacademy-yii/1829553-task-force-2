<?php

/* @var $this yii\web\View */

use Mar4hk0\Helpers\Price;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $tasks array Tasks*/
/* @var $loginForm array loginForm*/
?>

<div class="landing-bottom-container">
    <h2>Последние задания на сайте</h2>
    <?php foreach ($tasks as $task):?>
        <?php ?>
        <div class="landing-task">
            <div class="landing-task-top task-<?=Html::encode($task->category->system_name)?>"></div>
            <div class="landing-task-description">
                <h3><a href="<?=Url::to(['tasks/view', 'id' => $task->id])?>" class="link-regular"><?=StringHelper::truncate(Html::encode($task->title), 15)?>></a></h3>
                <p><?=Html::encode(StringHelper::truncate($task->description, 150))?></p>
            </div>
            <div class="landing-task-info">
                <div class="task-info-left">
                    <p><a href="<?=Url::to(['tasks/index', 'TaskSearchForm' => ['filterCategories' => [$task->category->id]]])?>" class="link-regular"><?=Html::encode($task->category->human_name)?></a></p>
                    <p><?=Yii::$app->formatter->format($task->created, 'relativetime');?></p>
                </div>
                <span><?=HTML::encode(Price::getPriceHuman($task->price));?></span>
            </div>
        </div>
    <?php endforeach;?>
</div>

<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'registration',
        'method' => 'post',
        'options' => [
            'name' => 'registration',
        ],
        'action' => [
            '/site/login',
        ],
    ]); ?>
    <?= $form->field($loginForm, 'email')
        ->textInput(['id' => 'enter-email', 'class' => 'enter-form-email input input-middle'])
        ->label('Email', ['class' => 'form-modal-description']);
    ?>
    <?= $form->field($loginForm, 'password')
        ->passwordInput(['id' => 'enter-password', 'class' => 'enter-form-email input input-middle'])
        ->label('Пароль', ['class' => 'form-modal-description']);
    ?>
    <?= Html::submitButton('Войти', ['class' => 'button']) ?>
    <?php $form = ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
