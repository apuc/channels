<?php

namespace common\models\db;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $dt_add
 * @property int $status
 * @property int $private
 * @property int $user_id
 * @property int $type
 */
class Chat extends \yii\db\ActiveRecord
{
    public $last_msg;
    public $textMsg;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;

    const TYPE_CHANNEL = 1;
    const TYPE_DIALOG = 2;

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'common\behaviors\Slug',
                'in_attribute' => 'title',
                'out_attribute' => 'slug',
                'translit' => true
            ],
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
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dt_add', 'status', 'private', 'user_id', 'type'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'slug' => 'Slug',
            'dt_add' => 'Дата создания',
            'status' => 'Статус',
            'private' => 'Закрытый',
            'user_id' => 'Пользователь',
            'type' => 'Тип',
        ];
    }

    public function getMsg()
    {
        return $this->hasMany(Msg::className(), ['chat_id' => 'id'])->with('fromUser');
    }

    public static function getUserChats($userId)
    {
        return ArrayHelper::getColumn(UserChat::findAll(['user_id' => $userId]), 'chat_id');
    }

    public function getUserChat()
    {
        return $this->hasMany(UserChat::className(), ['chat_id' => 'id']);
    }
}
