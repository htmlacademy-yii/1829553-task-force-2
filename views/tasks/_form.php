<?php

/* @var $this yii\web\View */

use app\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model Task */
/* @var $categories array */


?>

<?php $form = ActiveForm::begin([
    'id' => 'create-task',
    'method' => 'post',
    'action' => [
        '/tasks/create',
    ],
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
    <h3 class="head-main head-main">Публикация нового задания</h3>
    <?= $form->field($model, 'title')
        ->textInput(['id' => 'essence-work', 'class' => null])
        ->label('Опишите суть работы', ['class' => 'control-label']);
    ?>
    <?= $form->field($model, 'description')
        ->textarea(['id' => 'description', 'class' => null])
        ->label('Подробности задания', ['class' => 'control-label']);
    ?>
    <?= $form->field($model, 'categoryId')
        ->dropDownList($categories, ['id' => 'category', 'class' => null])
        ->label('Категория', ['class' => 'control-label']);
    ?>
    <?= $form->field($model, 'address')
        ->textInput(['id' => 'location', 'class' => null])
        ->label('Локация', ['class' => 'control-label']);
    ?>
    <div class="half-wrapper">
        <?= $form->field($model, 'price')
            ->input('number', ['id' => 'budget', 'class' => null])
            ->label('Бюджет', ['class' => 'control-label']);
        ?>
        <?= $form->field($model, 'deadline')
            ->input('date', ['id' => 'period-execution', 'class' => null])
            ->label('Срок исполнения', ['class' => 'control-label']);
        ?>
    </div>
    <p class="form-label">Файлы</p>
    <div class="new-file">
        <?= $form->field($model, 'filesSource[]', ['options' => ['tag' => false]])
            ->fileInput(['id' => 'files', 'class' => null, 'multiple' => true])
            ->label('Добавить новый файл', ['class' => 'control-label']);
        ?>
    </div>
    <?= Html::submitButton('Опубликовать', ['class' => 'button button--blue']) ?>
<?php $form = ActiveForm::end(); ?>
