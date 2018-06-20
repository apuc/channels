<?php

namespace frontend\modules\ajax\controllers;

use common\classes\Folder;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `ajax` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionChannelAva()
    {
        //phpinfo();
        $dir = '/media/users/' . Yii::$app->user->id. '/' . date('Y-m-d') . '/';
        $path = Yii::getAlias('@frontend/web' . $dir);
        $folderImg = new Folder($path, 0775);
        $folderImg->create()
            ->file($_FILES['file']['tmp_name'])
            ->save($_FILES['file']['name']);

        return json_encode([
            'img' => $dir . $_FILES['file']['name'],
        ]);
    }
}
