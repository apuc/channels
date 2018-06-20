<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "user_avatar".
 *
 * @property int $id
 * @property int $user_id
 * @property string $avatar
 */
class UserAvatar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_avatar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'avatar'], 'required'],
            [['user_id'], 'integer'],
            [['avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'avatar' => 'Avatar',
        ];
    }
}
