<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\tables\UserType;

/* @var $this yii\web\View */
/* @var $model common\models\tables\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userName')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'userEmail')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'userPassword')->passwordInput() ?>

    <?= $form->field($model, 'userTypeId')->dropDownList(ArrayHelper::map( UserType::find()->all(),'userTypeId', 'userTypeName'),['prompt' => '-- Select User Type --']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
