<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */
?>
<h1>Reset Password</h1>
<?php if($formModel):;?>
<div class="row">
	<div class="col-md-6">
		<div class="form well">

			<?php 
            $form = ActiveForm::begin([
                'id' => 'reset-password-form',
                'enableClientValidation' => true,
                'validateOnSubmit' => true,
            ]);
            
				if($formModel->requireOldPassword)
				{
					echo $form->field($formModel, 'currentPassword')->passwordInput();
				}
				echo $form->field($formModel, 'password')->passwordInput();
				echo $form->field($formModel, 'passwordConfirm')->passwordInput();
				echo Html::submitButton('Submit',['class'=>'btn btn-block btn-lg btn-success']); ?>

			<?php ActiveForm::end(); ?>
		</div>	
	</div>
</div>

<?php
$this->registerCss("
       label[for=resetpasswordform-password] {display: block;}
       label[for=resetpasswordform-password] .passStrengthify {float: right;}");
$this->registerJs("$('#resetpasswordform-password').passStrengthify({element:$('label[for=resetpasswordform-password]'), minimum:8});");
?>
<?php endif;?>
