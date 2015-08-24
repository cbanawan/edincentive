<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */
?>
<h1>Contact Us</h1>

<p>
	If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="row">
	<div class="col-md-6">
		<div class="well">
			<?php $form = ActiveForm::begin([
                'id' => 'contact-form', 
                'action' => (Yii::$app->controller instanceof frontend\controllers\SiteController)?'/contact':Yii::$app->request->url]); ?>
				<?= $form->field($model, 'name') ?>
				<?= $form->field($model, 'email') ?>
				<?= $form->field($model, 'subject') ?>
				<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
				]) ?>
				<small>
					Please enter the letters as they are shown in the image above.<br/> 
					Letters are not case-sensitive.
				</small>
				<br/>
				<br/>
				<div class="form-group">
					<?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-block btn-lg', 'name' => 'contact-button']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
