<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $dt_add
 * @property int $status
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dt_add', 'status'], 'integer'],
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
            'title' => 'Title',
            'slug' => 'Slug',
            'dt_add' => 'Dt Add',
            'status' => 'Status',
        ];
    }
}
