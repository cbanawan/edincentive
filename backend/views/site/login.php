<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-md-4">
            <div class="well">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'validateOnSubmit' => true,
                    ]); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-success btn-block btn-lg', 'name' => 'login-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
