<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 30.04.2018
 * Time: 0:29
 */
use kartik\select2\Select2;

?>

<div class="addItem">
    <?php
    echo Select2::widget([
        'name' => 'partner',
        'value' => '',
        'data' => \common\models\UserD::getList(),
        'options' => ['multiple' => false, 'placeholder' => 'Пользователи ...', 'id' => 'partnerId']
    ]);
    ?>
    <a href="#" id="startDialog" class="btn btn-primary">Начать</a>
</div>
