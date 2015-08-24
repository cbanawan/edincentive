<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-lg-7">
        <div class="well">
            <?php 
                $form = ActiveForm::begin([
                    'id' => 'create-migration-form',            
                ]);
                echo Html::textInput('CreateMigration[migrationName]', '', ['class' => 'form-control']);
                echo '&nbsp;';
                echo '<br/>';
                echo Html::submitButton('Create Migration', ['class'=>'btn btn-success btn-lg']);

                ActiveForm::end();
            ?>            
        </div>
    </div>
    <div class="col-lg-7">
        <?php
            $form = ActiveForm::begin([
                'id' => 'run-migration-form'
            ]);
            echo Html::submitButton('Run Migrations', ['name' => 'RunMigrations', 'class'=>'btn btn-primary btn-lg', 'value' => '1']);

            ActiveForm::end();
        ?>
        
    </div>
	
	
</div>