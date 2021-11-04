<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Новые задания';

/* @var $listTasks array */
/* @var $categories array */
/* @var $taskSearchForm array */
/* @var $listPeriods array */

?>
<div class="left-column">
    <h3><?= Html::encode($this->title)?></h3>
    <?php foreach ($listTasks as $key => $item) : ?>
        <div class="task-card">
            <div class="header-task">
                <a  href="#" class="link link--block link--big"><?= Html::encode($item['title'])?></a>
                <p class="price price--task"><?= Html::encode($item['price'])?></p>
            </div>
            <p class="info-text"><span class="current-time"><?= Html::encode($item['relative_time'])?></span> назад</p>
            <p class="task-text"><?= Html::encode($item['description'])?></p>
            <div class="footer-task">
                <p class="info-text town-text"><?= Html::encode($item['city_name'])?></p>
                <p class="info-text category-text"><?= Html::encode($item['category_human_name'])?></p>
                <a href="<?=Url::to('task/' . $item['task_id'], true)?>" class="button button--black">
                    Смотреть Задание
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="pagination-wrapper">
        <ul class="pagination-list">
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">1</a>
            </li>
            <li class="pagination-item pagination-item--active">
                <a href="#" class="link link--page">2</a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">3</a>
            </li>
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
        </ul>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <?php $form = ActiveForm::begin([
                'id' => 'searched-new-tasks',
                'method' => 'get',
                'options' => [
                    'name' => 'test',
                ],
                'action' => [
                    '/tasks',
                ],
                'fieldConfig' => [
                    'options' => [
                        'tag' => false,
                    ],
                ],
            ]); ?>
            <h4 class="head-card">Категории</h4>
            <div class="form-group">
                <div>
                    <?php foreach ($categories as $id => $category) : ?>
                    <div class="category">
                        <?= $form->field($taskSearchForm, 'filterCategories[]', [
                            'template' => '{input}',
                        ])->checkbox([
                            'label' => false,
                            'value' => Html::encode($category->id),
                            'uncheck' => null,
                            'checked' => in_array($category->id, $taskSearchForm->filterCategories),
                            'id' => Html::encode($category->system_name),
                        ]) ?>
                        <label class="control-label" for="<?=Html::encode($category->system_name)?>">
                            <?=Html::encode($category->human_name)?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <h4 class="head-card">Период</h4>
            <div class="form-group">
                <label for="period-value"></label>
                <?= $form->field($taskSearchForm, 'period', [
                    'template' => '{input}',
                ])->dropDownList(
                    $listPeriods,
                    [
                        'id' => 'period-value',
                        'class' => null,
                    ]
                ) ?>
            </div>
            <?= Html::submitButton('Искать', ['class' => 'button button--blue']) ?>
            <?php $form = ActiveForm::end(); ?>
        </div>
    </div>
</div>
