<?php

use app\models\Buttons\Button;

/* @var $this \yii\web\View */
/* @var $button Button|null */

?>

<?php if (!empty($button)):?>
    <?php
        $tokenModal = '';
        $class = 'class="button button--blue';
        if ($button->isModal()) {
            $class .= ' open-modal';
            $tokenModal = 'data-for="button-form"';
        }
        $class .= '"';

    ?>
    <a href="<?=$button->getUrl()?>" <?=$class . ' ' . $tokenModal?>><?=$button->getTitle()?></a>
<?php endif; ?>
