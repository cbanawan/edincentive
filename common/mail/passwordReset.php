<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $confirmCode, 'mId' => $memberId]);
?>

Hello <?= ucfirst($userName) ?>,,<br/>
<br/>
Click on the link below to reset your password:<br/>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
