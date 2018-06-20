<?php

namespace common\models\db;

use common\models\UserD;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "msg".
 *
 * @property int $id
 * @property int $from
 * @property int $to
 * @property int $chat_id
 * @property string $textMsg
 * @property int $dt_add
 * @property int $status
 */
class Msg extends \yii\db\ActiveRecord
{
    public $user_name;
    public $user_id;
    public $last_msg;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dt_add'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'chat_id', 'dt_add', 'status'], 'integer'],
            [['textMsg'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'chat_id' => 'Chat ID',
            'textMsg' => 'Text Msg',
            'dt_add' => 'Dt Add',
            'status' => 'Status',
        ];
    }

    public function getFromUser()
    {
        return $this->hasOne(UserD::className(), ['id' => 'from']);
    }

    public function getToUser()
    {
        return $this->hasOne(UserD::className(), ['id' => 'to']);
    }

    public static function sendMsg($data)
    {
        $model = new self();
        $model->from = $data['userId'];
        $model->to = $data['partnerId'];
        $model->chat_id = $data['chatId'];
        $model->textMsg = $data['msg'];
        $model->status = self::STATUS_ACTIVE;
        return $model->save();
    }

    public static function getMsgByTime($time)
    {
        $msg = [];
        $model = self::find()->with(['fromUser', 'toUser'])->where(['>', 'dt_add', $time])->asArray()->all();
        if($model){
            foreach ($model as $item){
                $msg[] = [
                    'id' => $item['id'],
                    'from' => $item['from'],
                    'to' => $item['to'],
                    'fromUser' => isset($item['fromUser']['username']) ? $item['fromUser']['username'] : null,
                    'toUser' => isset($item['toUser']['username']) ? $item['toUser']['username'] : null,
                    'chatId' => $item['chat_id'],
                    'dt_add' => $item['dt_add'],
                    'dt_text' => date('H:i d-m-Y', $item['dt_add']),
                    'status' => $item['status'],
                    'textMsg' => nl2br($item['textMsg']),
                ];
            }
        }

        return $msg;
    }
}
