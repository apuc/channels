<?php
/**
 * @var $chat \common\models\db\Chat
 * @var $partner \common\models\UserD
 * @var $mainBoxView string
 */
?>
<script>
    var userId = <?= Yii::$app->user->id ?>;
    var chatId = <?= $chat !== null ? $chat->id : 'null' ?>;
    var partnerId = <?= $partner !== null ? $partner->id : 'null'?>;
</script>
<?php
$this->registerJsFile('/js/script.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="channelWrap" id="channelWrap">
    <div id="channelSidebar" class="channelSidebar">
        <?= \frontend\widgets\UserChats::widget([
            'activeChat' => $chat !== null ? $chat->id : null,
            'activePartner' => $partner !== null ? $partner->id : null
        ]) ?>
    </div>
    <div id="channelContent" class="channelContent">
        <div class="channelContent_msgBox" id="msgBox">
            <?= $this->render($mainBoxView) ?>
        </div>
        <div class="channelContent_actionBox" id="actionBox">
            <form action="">
                <textarea name="channelMsg" id="channelMsg" class="actionBox_area"></textarea>
                <input type="button" value="Отправить" id="msgBtn">
            </form>
        </div>
    </div>
</div>
