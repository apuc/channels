<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 28.04.2018
 * Time: 11:03
 */

namespace frontend\widgets;

use common\classes\Debug;
use common\models\db\Chat;
use common\models\db\Msg;
use common\models\db\UserChat;
use common\models\UserD;
use yii\base\Widget;

class UserChats extends Widget
{

    public $activeChat;
    public $activePartner;
    public $type;

    public function run()
    {
        $user_id = \Yii::$app->user->id;
        $model = Chat::find()->select('`chat`.*, MAX(`msg`.`dt_add`) last_msg, textMsg')
            ->leftJoin('user_chat', '`user_chat`.`chat_id` = `chat`.`id`')
            ->leftJoin('msg', '`msg`.`chat_id` = `chat`.`id`')
            ->where(['`user_chat`.`user_id`' => $user_id])
            ->groupBy('`chat`.`id`')
            ->orderBy('last_msg DESC')
            ->all();
        //Debug::dd($model);

        $partner = Msg::find()
            ->select('`user`.`username` user_name, IF(`from`='.$user_id.', `to`, `from`) user_id, MAX(`dt_add`) last_msg')
            ->leftJoin('`user`', '`user`.`id` = IF(`from`='.$user_id.', `to`, `from`)')
            ->where('(`from`='.$user_id.' OR `to`='.$user_id.')')
            ->andWhere('`to` IS NOT NULL')
            ->groupBy('user_id')
            ->orderBy('last_msg DESC')
            ->all();

        return $this->render('uc', [
            'model' => $model,
            'ac' => $this->activeChat,
            'ap' => $this->activePartner,
            'partner' => $partner,
            'type' => $this->type
        ]);
    }

}