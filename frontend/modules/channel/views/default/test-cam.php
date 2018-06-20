<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 14.06.2018
 * Time: 13:01
 */

use timurmelnikov\widgets\WebcamShoot;

echo WebcamShoot::widget([
    'targetInputID' => 'textimg',
    'targetImgID' => 'textphoto',
]);