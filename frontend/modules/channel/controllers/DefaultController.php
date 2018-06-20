<?php

namespace frontend\modules\channel\controllers;

use common\classes\Debug;
use common\models\db\Chat;
use common\models\db\Msg;
use common\models\UserD;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `channel` module
 */
class DefaultController extends Controller
{
    public $layout = '@frontend/views/layouts/ch3';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        return $this->render('index', ['chat' => null, 'partner' => null, 'mainBoxView' => '_main']);
    }

    public function actionSingle($id)
    {
        $model = Chat::find()->with('msg')->where(['id' => $id])->one();
        //Debug::prn(\Yii::$app->getModule('user'));
        //Debug::dd(Msg::getMsgByTime(1524735747));
        return $this->render('single', ['chat' => $model, 'partner' => null, 'msgs' => null]);
    }

    public function actionPers($id)
    {
        $partner = UserD::findOne($id);
        $model = Msg::find()
            ->where(['to' => $id, 'from' => \Yii::$app->user->id])
            ->with(['fromUser', 'toUser'])
            ->orWhere(['to' => \Yii::$app->user->id, 'from' => $id])
            ->andWhere(['chat_id' => null])
            ->all();
        return $this->render('single', ['chat' => null, 'partner' => $partner, 'msgs' => $model]);
    }

    public function actionAddPartner()
    {
        return $this->render('index', ['chat' => null, 'partner' => null, 'mainBoxView' => '_add-partner']);
    }

    public function actionAddChannel()
    {
        $model = new Chat();
        if ($model->load(Yii::$app->request->post())) {
            $model->status = Chat::STATUS_ACTIVE;
            $model->user_id = Yii::$app->user->id;
            $model->save();
            return $this->redirect(Url::to(['/channel/default/single', 'id' => $model->id]));
        }
        $myChannels = Chat::find()->where(['user_id' => \Yii::$app->user->id, 'status' => Chat::STATUS_ACTIVE])->all();
        $users = UserD::find()->joinWith('avatar')->limit(10)->all();
        return $this->render('add_channel', [
            'myChannels' => $myChannels,
            'partner' => null,
            'chat' => null,
            'users' => $users
        ]);
    }

    public function actionDelChannel()
    {
        $id = Yii::$app->request->get('id');
        $chat = Chat::findOne($id);
        if($chat->user_id === Yii::$app->user->id){
            $chat->status = Chat::STATUS_DELETE;
            $chat->save();
        }
        return $this->redirect(Url::to(['/channel/default/add-channel']));
    }

    public function actionTestCam()
    {
        return $this->render('test-cam');
    }
}


