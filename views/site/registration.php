<?php

/* @var $this yii\web\View */
/* @var $registration \app\models\RegistrationForm*/
/* @var $cities array on \app\models\City */

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
?>

<div class="center-block">
    <div class="registration-form regular-form">
        <?php $form = ActiveForm::begin([
            'id' => 'registration',
            'method' => 'post',
            'options' => [
                'name' => 'registration',
            ],
            'action' => [
                '/site/registration',
            ],
        ]); ?>
            <h3 class="head-main head-task">Регистрация нового пользователя</h3>
            <?= $form->field($registration, 'name')
                ->textInput(['id' => 'username', 'class' => null])
                ->label('Ваше имя', ['class' => 'control-label']);
            ?>
            <div class="half-wrapper">
                <?= $form->field($registration, 'email')
                    ->input('email', ['id' => 'email', 'class' => null])
                    ->label('Email', ['class' => 'control-label']);
                ?>
                <?= $form->field($registration, 'cityId')
                    ->dropDownList($cities, ['id' => 'town-user', 'class' => null])
                    ->label('Город', ['class' => 'control-label']);
                ?>
            </div>
            <?= $form->field($registration, 'password')
                ->passwordInput(['id' => 'password', 'class' => null])
                ->label('Пароль', ['class' => 'control-label']);
            ?>
            <?= $form->field($registration, 'passwordRepeat')
                ->passwordInput(['id' => 'password-repeat-user', 'class' => null])
                ->label('Повтор пароля', ['class' => 'control-label']);
            ?>
            <?= $form->field($registration, 'birthday')
                ->widget(DatePicker::class, [
                    'name' => 'birthday',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-dd'
                    ]
                ])
                ->label('Ваш день рождения', ['class' => 'control-label'])
            ?>
            <?= $form->field($registration, 'isClient')
                ->checkbox(['id' => 'response-user', 'class' => null])
                ->label('Я собираюсь откликаться на заказы', ['class' => 'control-label']);
            ?>


            <?= Html::submitButton('Создать аккаунт', ['class' => 'button button--blue']) ?>
        <?php $form = ActiveForm::end(); ?>
    </div>
</div>
