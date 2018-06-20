<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 16.06.2018
 * Time: 15:17
 * @var $myChannels array
 * @var $users \common\models\UserD
 */
?>
<script>
    var userId = <?= Yii::$app->user->id ?>;
    var chatId = <?= $chat !== null ? $chat->id : 'null' ?>;
    var partnerId = <?= $partner !== null ? $partner->id : 'null'?>;
</script>
<?php
$this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-token');
$this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-param');
$this->registerJsFile('/js/channel_add.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<!-- start create-chat.html-->
<main class="main create-chat">
    <header class="main__header">
        <strong class="main__header-title">Для создания канала выберите действие</strong>
        <div class="main__header-actions">
            <button class="main__header-btn"><img src="/img/icons/favorite.png" alt="favorite"></button>
            <button class="main__header-btn"><img src="/img/icons/phone.png" alt="phone"></button>
            <button class="main__header-btn"><img src="/img/icons/video-call.png" alt="video phone"></button>
        </div>
    </header>
    <div class="main__body">
        <div class="main__aside">
            <form action="" method="post">
                <div class="main__aside-row">
                    <div class="input__white">
                        <input type="text" placeholder="Введите название канала">
                        <button class="input__white-btn"><img src="/img/icons/cross.png" alt="clear"></button>
                    </div>
                </div>
                <div class="main__aside-row">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">
                            <span>Закрытый</span>
                        </label>
                    </div>
                </div>
                <div class="main__aside-row">
                    <div class="channelImgBox" id="wrapperCont">
                        <span class="channelItemImg">
                            <span class="channelImg"><img src="/img/ava.jpg" alt=""></span>
                        </span>
                    </div>
                </div>
                <div class="main__aside-row">
                    <button class="btn-green" id="channelAddPhoto">Добавить фото</button>
                    <input type="file" id="channelAddPhotoInput" style="display: none">
                </div>
                <div class="main__aside-row">
                    <strong class="main__aside-title">Осталось добавить пользователей</strong>
                </div>
                <div class="main__aside-row">
                    <div class="input__white">
                        <input type="text" placeholder="Введите название канала">
                        <button class="input__white-btn"><img src="/img/icons/cross.png" alt="clear"></button>
                    </div>
                </div>
                <ul class="interlocutors__list--simple">
                    <?php foreach ((array)$users as $user): ?>
                        <li class="interlocutors__user" data-user-id="<?= $user->id ?>"
                            data-user-name="<?= $user->username ?>">
                            <span class="interlocutors__user-online"></span>
                            <img class="interlocutors__avatar"
                                 src="<?= !empty($user->avatar) ? $user->avatar->avatar : '/img/no-photo.jpg' ?>"
                                 alt="user_icon"/>
                            <div class="interlocutors__text">
                                <h3 class="interlocutors__name"><?= $user->username ?></h3>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="main__aside-row">
                    <button class="btn-green">Создать чат</button>
                </div>
                <div id="membersInput" style="display: none"></div>
            </form>
            <div id="members">

            </div>
        </div>
        <div class="main__wrap">
            <div class="chat">
                <div class="chat__body">
                    <h2 class="main__title c-green">Каналы созданные мной</h2>
                    <div class="chat__tabs">
                        <?php foreach ($myChannels as $channel): ?>
                            <div class="chat__tab">
                                <img src="<?= empty($channel->photo) ? '/img/no-photo.jpg' : $channel->photo ?>"
                                     alt="chat logo" class="chat__tab-logo">
                                <span class="chat__tab-title"><a href="<?= \yii\helpers\Url::to([
                                        '/channel/default/single',
                                        'id' => $channel->id,
                                    ]) ?>"><?= $channel->title ?></a></span>
                                <div class="chat__tab-actions">
                                    <a href="<?= \yii\helpers\Url::to([
                                        '/channel/default/del-channel',
                                        'id' => $channel->id,
                                    ]) ?>" class="chat__tab-del"> <img src="/img/icons/cross.png"
                                                                       alt="delete">удалить</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- end create-chat.html-->
