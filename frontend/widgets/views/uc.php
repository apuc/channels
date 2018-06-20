<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 28.04.2018
 * Time: 11:43
 * @var $model \common\models\db\Chat
 * @var $ac integer
 * @var $ap integer
 * @var $type string
 * @var $partner \common\models\db\Msg
 */
?>
<?php if ($ac !== null): ?>
    <?php foreach ($model as $item): ?>
        <li class="interlocutors__user <?= (int)$item->id === $ac ? 'interlocutors__user--active' : ''; ?>">
            <span class="interlocutors__user-online"></span>
            <a href="<?= \yii\helpers\Url::to([
                '/channel/default/single',
                'id' => $item->id,
            ]) ?>">
                <img class="interlocutors__avatar" src="<?= empty($model->photo) ? '/img/no-photo.jpg' : $model->photo?>" alt="user_icon"/>
            </a>
            <div class="interlocutors__text">
                <h3 class="interlocutors__name"><a href="<?= \yii\helpers\Url::to([
                        '/channel/default/single',
                        'id' => $item->id,
                    ]) ?>"><?= $item->title ?></a></h3>
                <span class="interlocutors__msg"><?= $item->textMsg ?></span>
            </div>
            <div class="interlocutors__actions">
                <button class="interlocutors__actions-btn"><span></span><span></span><span></span></button>
                <span class="interlocutors__time-left">5 min</span>
            </div>
        </li>
    <?php endforeach; ?>
<?php endif; ?>
<?php if ($ap !== null): ?>
    <?php foreach ($partner as $item): ?>
        <div class="channelSidebar_item<?= (int)$item->user_id === $ap ? ' active' : '' ?>">
            <a href="<?= \yii\helpers\Url::to([
                '/channel/default/pers',
                'id' => $item->user_id,
            ]) ?>"><?= $item->user_name ?></a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
