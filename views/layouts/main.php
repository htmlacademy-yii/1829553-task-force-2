<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (Yii::$app->request->getPathInfo() !== 'site/registration'): ?>
    <header class="page-header">
    <nav class="main-nav">
        <a href='#' class="header-logo">
            <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item list-item--active">
                    <a class="link link--nav" >Новое</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Мои задания</a>
                </li>
                <?php if (Yii::$app->params['user']->is_client): ?>
                    <li class="list-item">
                        <a href="<?=Url::to(['/tasks/create'])?>" class="link link--nav" >Создать задание</a>
                    </li>
                <?php endif; ?>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php if (!empty(Yii::$app->params['user'])): ?>
        <?php $user = Yii::$app->params['user']; ?>
        <div class="user-block">
            <a href="#">
                <img class="user-photo" src="<?=Yii::getAlias('@avatars') . '/' . $user->avatar ?>" width="55" height="55" alt="Аватар">
            </a>
            <div class="user-menu">
                <p class="user-name"><?=Html::encode($user->name)?></p>
                <div class="popup-head">
                    <ul class="popup-menu">
                        <li class="menu-item">
                            <a href="#" class="link">Настройки</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="link">Связаться с нами</a>
                        </li>
                        <li class="menu-item">
                            <a href="<?=Url::to('/site/logout')?>" class="link">Выход из системы</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</header>
<?php endif; ?>

<main class="main-content container">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</main>
<div class="overlay"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

