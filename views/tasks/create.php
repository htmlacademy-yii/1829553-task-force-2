<?php

/* @var $this yii\web\View */

use app\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model Task */
/* @var $categories array */

?>
<div class="add-task-form regular-form">
    <?= $this->render('_form', ['model' => $model, 'categories' => $categories])?>
</div>
