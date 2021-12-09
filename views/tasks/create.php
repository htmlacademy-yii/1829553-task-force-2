<?php

/* @var $this yii\web\View */

use app\models\Task;

/* @var $model Task */
/* @var $categories array */

?>
<div class="add-task-form regular-form">
    <?= $this->render('_form', ['model' => $model, 'categories' => $categories])?>
</div>
