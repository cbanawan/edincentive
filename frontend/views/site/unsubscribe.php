<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
	<div class="col-md-12">
		<h1>Unsubscribe</h1>
		<p>If you would like to unsubscribe from the survey panel please click on the "Unsubscribe" button. Please be aware that any current points balance will be forfeited when you unsubscribe from the panel. If you choose not to unsubscribe please click on your browser's 'Back' button.</p>
		<?php 
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'options' => [
                'id' => 'unsubscribe-form',
                'class' => 'well pull-left'
            ]
        ]);
        
        echo Html::submitButton('Unsubscribe',[
            'class' => 'btn btn-lg btn-success'
        ]);
        
        echo Html::hiddenInput('unsubscribe', 1);
        ActiveForm::end();
        ?>
	</div>	
</div>