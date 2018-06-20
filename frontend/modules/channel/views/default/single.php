<?php
/**
 * @var $chat \common\models\db\Chat
 * @var $partner \common\models\UserD
 * @var $msgs \common\models\db\Msg
 */
?>
<style>
    .chat__input-field:empty:not(:focus):before {
        content: attr(data-placeholder)
    }
</style>
<script>
    var userId = <?= Yii::$app->user->id ?>;
    var chatId = <?= $chat !== null ? $chat->id : 'null' ?>;
    var partnerId = <?= $partner !== null ? $partner->id : 'null'?>;
</script>
<?php
$this->registerJsFile('/js/script.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$msg = $partner === null ? $chat->msg : $msgs;
?>
<?= \frontend\widgets\UserChats::widget() ?>
<!-- start index.html-->
<main class="main dialog">
    <div class="main__body">
        <div class="main__aside">
            <header class="main__header">
                <div class="interlocutors__search">
                    <div class="interlocutors__searchbar">
                        <input type="text" placeholder="Search">
                        <img src="/img/icons/search.png" alt="search">
                    </div>
                </div>
            </header>
            <div class="interlocutors__wrap">
                <ul class="interlocutors__list">
                    <?= \frontend\widgets\UserChats::widget([
                        'activeChat' => $chat !== null ? $chat->id : null,
                        'activePartner' => $partner !== null ? $partner->id : null,
                    ]) ?>
                </ul>
            </div>
        </div>
        <div class="main__wrap chat">
            <header class="main__header">
                <span class="chat__header-text">Ольга Курочкина набирает...</span>
                <button class="chat__header-btn"><img src="/img/icons/favorite.png" alt="favorite"></button>
                <button class="chat__header-btn"><img src="/img/icons/phone.png" alt="phone"></button>
                <button class="chat__header-btn"><img src="/img/icons/video-call.png" alt="video phone"></button>
            </header>
            <div class="chat__body" id="chat__body">
                <?php if (!empty($msg)): ?>
                    <?php foreach ((array)$msg as $item): ?>
                        <div class="chat__message chat__msg-from-<?= $item->from === Yii::$app->user->id ? 'my' : 'interlocutor' ?>">
                            <div class="chat__user">
                                <img src="/img/icons/user2.png" alt="icon interlocutor" class="chat__user-icon">
                                <span class="chat__msg-time"><?= date('H:i', $item->dt_add) ?></span>
                            </div>
                            <div class="chat__msg-text"><?= nl2br($item->textMsg); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Сообщений нет</div>
                <?php endif; ?>
            </div>
            <div class="chat__footer">
                <div class="chat__add">
                    <button class="chat__add-btn"><img src="/img/icons/attach.png" alt="attach file"
                                                       data-toggle-target="chat__add-list" data-display-target="flex">
                    </button>
                    <div class="chat__add-list" id="chat__add-list" style="display: none">
                        <label class="chat__add-item"><input type="file"><img src="/img/icons/phone.png" alt=""></label>
                        <label class="chat__add-item"><input type="file"><img src="/img/icons/phone.png" alt=""></label>
                        <label class="chat__add-item"><input type="file"><img src="/img/icons/phone.png" alt=""></label>
                        <label class="chat__add-item"><input type="file"><img src="/img/icons/phone.png" alt=""></label>
                        <label class="chat__add-item"><input type="file"><img src="/img/icons/phone.png" alt=""></label>
                    </div>
                </div>
                <div class="chat__input">
                    <div class="chat__input-field" data-placeholder="Напишите ваше сообщение" contenteditable="true" id="chat__input-hidden"></div>
                    <input type="hidden" class="chat__input-hidden" id="chat__input-hidden_">
                </div>
                <button class="chat__smile-btn"><img src="/img/icons/emojis.png" alt="emoji"></button>
                <button class="chat__send-btn" id="chat__send-btn"><img src="/img/icons/send.png" alt="send"></button>
            </div>
        </div>

    </div>
</main>