<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 21.04.2018
 * Time: 23:04
 */

namespace common\models;

use common\models\db\UserAvatar;
use Yii;
use yii\helpers\ArrayHelper;

class UserD extends \dektrium\user\models\User
{

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }

    public function getAvatar()
    {
        return $this->hasOne(UserAvatar::className(), ['user_id' => 'id']);
    }

}