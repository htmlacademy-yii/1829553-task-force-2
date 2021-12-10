<?php

use app\models\Review;
use app\models\Task;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Review */
/* @var $task Task */

?>

<section class="review-form form-modal" id="button-form">
    <h2>Оставить отзыв</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'review-create',
        'method' => 'post',
        'options' => [
            'name' => 'review-create',
        ],
        'action' => [
            '/review/create',
        ],
    ]); ?>
    <?= $form->field($model, 'description')
        ->textarea(['id' => 'enter-description', 'class' => 'input input-middle'])
        ->label(null, ['class' => 'form-modal-description']);
    ?>
    <?= $form->field($model, 'grade')
        ->textInput(['id' => 'enter-grade', 'class' => 'input input-middle'])
        ->label(null, ['class' => 'form-modal-description']);
    ?>
    <?= $form->field($model, 'task_id')
        ->hiddenInput(['value' => $task->id])
        ->label(false);
    ?>
    <?= $form->field($model, 'performer_id')
        ->hiddenInput(['value' => $task->performer_id])
        ->label(false);
    ?>
    <?= Html::submitButton('Отправить', ['class' => 'button--blue']) ?>
    <?php $form = ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
