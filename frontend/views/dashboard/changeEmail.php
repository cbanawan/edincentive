<?php 
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\tables\Question;
?>
<h1>Change Email</h1>
<p>
	You will need to re-confirm your new email address if you change it.
	<br/><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;<strong>Current Email:</strong> <?php echo $memberModel->memberEmail; ?>
</p>
<div class="row">
	<div class="col-md-6">
        <div class="well">
		<?php 
            $form = ActiveForm::begin([
                'id' => 'change-email-form',
                'enableClientValidation' => true,
                'validateOnSubmit' => true
            ]);
            echo $form->field($changeEmailForm, 'email');
            echo Html::submitButton('Submit', [
                'class'=>'btn btn-block btn-lg btn-success'
            ]);

            ActiveForm::end(); ?>
        </div>
	</div>
</div>
