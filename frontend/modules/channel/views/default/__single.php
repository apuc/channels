<?php
/**
 * @var $chat \common\models\db\Chat
 * @var $partner \common\models\UserD
 * @var $msgs \common\models\db\Msg
 */
?>
<script>
    var userId = <?= Yii::$app->user->id ?>;
    var chatId = <?= $chat !== null ? $chat->id : 'null' ?>;
    var partnerId = <?= $partner !== null ? $partner->id : 'null'?>;
</script>
<?php
$this->registerJsFile('/js/script.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$msg = $partner === null ? $chat->msg : $msgs;
?>

<div class="channelWrap" id="channelWrap">
    <div id="channelSidebar" class="channelSidebar">
        <?= \frontend\widgets\UserChats::widget([
            'activeChat' => $chat !== null ? $chat->id : null,
            'activePartner' => $partner !== null ? $partner->id : null
        ]) ?>
    </div>
    <div id="channelContent" class="channelContent">
        <div id="channelAction" class="channelAction"></div>
        <div class="channelContent_msgBox" id="msgBox">
            <?php if (!empty($msg)): ?>
                <?php foreach ((array)$msg as $item): ?>
                    <div class="msgBox_item <?= $item->from === Yii::$app->user->id ? '_me' : '_partner' ?>">
                        <div><?= $item->fromUser->username . ' ' . date('H:i d-m-Y', $item->dt_add)?></div>
                        <div><?= nl2br($item->textMsg); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div>Сообщений нет</div>
            <?php endif; ?>

        </div>
        <div class="channelContent_actionBox" id="actionBox">
            <form action="">
                <label for="channelMsg"></label><textarea name="channelMsg" id="channelMsg" class="actionBox_area"></textarea>
                <input type="button" value="Отправить" id="msgBtn">
            </form>
        </div>
    </div>
</div>
