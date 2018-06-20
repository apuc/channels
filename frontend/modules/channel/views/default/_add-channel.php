<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 30.04.2018
 * Time: 14:09
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model = new \common\models\db\Chat();
?>

<div class="addItem">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'private')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
