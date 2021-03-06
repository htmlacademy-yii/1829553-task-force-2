<?php

use app\models\Task;
use yii\base\Model;
use yii\bootstrap4\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Model */
/* @var $task Task */

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
    <?= $form->field($model, 'taskId')
        ->hiddenInput(['value' => $task->id])
        ->label(false);
    ?>
    <?= Html::submitButton('Отказаться', ['class' => 'button--blue']) ?>
    <?php $form = ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>


