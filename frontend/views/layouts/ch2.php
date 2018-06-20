<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= Alert::widget() ?>

<div class="app" id="app">
    <!-- start menu.html-->
    <aside class="menu">
        <div class="menu__actions">
            <button class="menu__hamburger" id="menu__hamburger" data-toggle-target="menu__submenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="menu__actions-list">
                <li class="menu__actions-item">
                    <button class="menu__actions-btn">Д</button>
                </li>
                <li class="menu__actions-item menu__actions-item--active">
                    <button class="menu__actions-btn">К</button>
                </li>
                <li class="menu__actions-item">
                    <button class="menu__actions-btn">+</button>
                </li>
            </ul>
        </div>
        <div class="menu__submenu" id="menu__submenu" style="display: none">
            <div class="menu__head">
                <h2 class="menu__title">Диалоги</h2>
                <button class="menu__add-btn"><img src="/img/icons/add.png" alt="add"></button>
            </div>
            <ul class="menu__list">
                <li class="menu__item"><a href="#" class="menu__link">Добавить комнату</a></li>
                <li class="menu__item"><a href="#" class="menu__link">Добавить канал</a></li>
                <li class="menu__item"><a href="#" class="menu__link">Начать диалог</a></li>
            </ul>
            <ul class="menu__list">
                <li class="menu__item"><a href="#" class="menu__link">Настройки</a></li>
                <li class="menu__item"><a href="#" class="menu__link">Поддержка</a></li>
            </ul>
        </div>
    </aside>
    <!-- end menu.html-->
    <!-- start interlocutors.html-->
    <div class="interlocutors">
        <div class="interlocutors__search">
            <div class="interlocutors__searchbar">
                <input type="text" placeholder="Search">
                <img src="/img/icons/search.png" alt="search">
            </div>
        </div>
        <div class="interlocutors__wrap">
            <ul class="interlocutors__list" id="interlocutors__list">
                <?= \frontend\widgets\UserChats::widget([
                    'activeChat' => $chat !== null ? $chat->id : null,
                    'activePartner' => $partner !== null ? $partner->id : null,
                ]) ?>
            </ul>
            <span class="interlocutors__bar"></span>
        </div>

    </div>
    <!-- end interlocutors.html-->
<?= $content ?>
    <!-- start info.html-->
    <div class="info">
        <div class="info__header">
            <button class="info__notification info__notification--active"><img src="/img/icons/notifications.png"
                                                                               alt="notifications"></button>
            <div class="info__drop">
                <button class="info__drop-name">Ольга Курочкина</button>
            </div>
        </div>
        <div class="info__body">
            <div class="info__menu">
                <button class="info__menu-btn"><span></span><span></span><span></span></button>
            </div>
            <img src="/img/user.png" alt="user photo" class="info__photo">
            <h2 class="info__name">Ольга Курочкина</h2>
            <span class="info__location">ДНР, Донецк</span>
        </div>
        <ul class="info__list">
            <li class="info__item">
                <span class="info__item-key">Ник:</span>
                <span class="info__item-val">Killa Kella</span>
            </li>
            <li class="info__item">
                <span class="info__item-key">Телефон:</span>
                <span class="info__item-val">072 143 9920</span>
            </li>
            <li class="info__item">
                <span class="info__item-key">Дата визита:</span>
                <span class="info__item-val">July 12, 1988</span>
            </li>
        </ul>
    </div>
    <!-- end info.html-->

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
