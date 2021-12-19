<?php

/* @var $this yii\web\View */

use app\models\Task;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/* @var $model Task */
/* @var $categories array */

?>
<div class="add-task-form regular-form">
    <?= $this->render('_form', ['model' => $model, 'categories' => $categories])?>
</div>


<?php
    $this->registerJsFile(
        'https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.6/dist/autoComplete.min.js',
        ['depends' => [JqueryAsset::class]]
    );
    $this->registerJsFile(
        '@web/js/geo.js',
        ['depends' => [JqueryAsset::class]]
    );
    $this->registerJsVar('url_get_geo', Url::to(['ajax/geo']));
?>
