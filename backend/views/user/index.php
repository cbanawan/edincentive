<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['backend/user/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'userId',
            'userName',
            'userEmail:email',
            'userType.userTypeName',
            // 'userPassword',
            // 'userTypeId',
            [
				'class' => 'yii\grid\ActionColumn',
				'controller' => 'backend/user',
				'template' => '{update}&nbsp;{delete}',		
			],
        ],
    ]); ?>

</div>
