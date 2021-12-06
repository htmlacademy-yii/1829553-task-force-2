<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

?>

<section class="bid-form form-modal" id="button-form">
    <h2>Отказаться от работы</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'task-refuse',
        'method' => 'post',
        'options' => [
            'name' => 'task-refuse',
        ],
        'action' => [
            '/tasks/refuse',
        ],
    ]); ?>
    <?= Html::submitButton('Отказаться', ['class' => 'button--blue']) ?>
    <?php $form = ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>


