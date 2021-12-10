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
    <h2>Откликнуться на работу</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'bid-create',
            'method' => 'post',
            'options' => [
                'name' => 'bid-create',
            ],
            'action' => [
                '/bid/create',
            ],
        ]); ?>
        <?= $form->field($model, 'price')
            ->textInput(['id' => 'enter-price', 'class' => 'input input-middle'])
            ->label('Цена', ['class' => 'form-modal-description']);
        ?>
        <?= $form->field($model, 'description')
            ->textarea(['id' => 'enter-description', 'class' => 'input input-middle'])
            ->label('Предложение', ['class' => 'form-modal-description']);
        ?>
        <?= $form->field($model, 'task_id')
            ->hiddenInput(['value' => $task->id])
            ->label(false);
        ?>
        <?= $form->field($model, 'performer_id')
            ->hiddenInput(['value' => Yii::$app->params['user']->id])
            ->label(false);
        ?>
        <?= Html::submitButton('Отправить', ['class' => 'button--blue']) ?>
        <?php $form = ActiveForm::end(); ?>
        <button class="form-modal-close" type="button">Закрыть</button>
</section>

