<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Новые задания';

/* @var $data array */

?>
<div class="left-column">
    <h3><?= Html::encode($this->title)?></h3>
    <?php foreach ($data as $key => $item) : ?>
        <div class="task-card">
            <div class="header-task">
                <a  href="#" class="link link--block link--big"><?= Html::encode($item['title'])?></a>
                <p class="price price--task"><?= Html::encode($item['price'])?></p>
            </div>
            <p class="info-text"><span class="current-time"><?= Html::encode($item['relative_time'])?></span> назад</p>
            <p class="task-text"><?= Html::encode($item['description'])?></p>
            <div class="footer-task">
                <p class="info-text town-text"><?= Html::encode($item['city_name'])?></p>
                <p class="info-text category-text"><?= Html::encode($item['category_name'])?></p>
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
            <form>
                <h4 class="head-card">Категории</h4>
                <div class="form-group">
                    <div>
                        <input type="checkbox" id="сourier-services" checked>
                        <label class="control-label" for="сourier-services">Курьерские услуги</label>
                        <input id="cargo-transportation" type="checkbox">
                        <label class="control-label" for="cargo-transportation">Грузоперевозки</label>
                        <input id="translations" type="checkbox">
                        <label class="control-label" for="translations">Переводы</label>
                    </div>
                </div>
                <h4 class="head-card">Дополнительно</h4>
                <div class="form-group">
                    <input id="without-performer" type="checkbox" checked>
                    <label class="control-label" for="without-performer">Без исполнителя</label>
                </div>
                <h4 class="head-card">Период</h4>
                <div class="form-group">
                    <label for="period-value"></label>
                    <select id="period-value">
                        <option>1 час</option>
                        <option>12 часов</option>
                        <option>24 часа</option>
                    </select>
                </div>
                <input type="button" class="button button--blue" value="Искать">
            </form>
        </div>
    </div>
</div>
