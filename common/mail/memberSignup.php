<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $confirmCode string */
/* @var $memberId int */
/* @var $userName string */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'code' => $confirmCode, 'mId' => $memberId]);
?>

Hello <?= ucfirst($userName) ?>,<br/>
<br/>			
Thank you for signing up!<br/>
You need to verify that this email account is yours before surveys can be sent to you via your email.<br/>
<br/>
Click or copy and paste this link into your internet browser:<br/>
<?= $confirmLink ?><br/>
<br/>
