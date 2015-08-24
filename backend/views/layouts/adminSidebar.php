<?php
use yii\bootstrap\Nav;

$navItems = [];

$navItems[] = [
    'label' => 'Manage Users', 
    'url' => '/backend/user', 
    'options' => ['class'=> (Yii::$app->controller instanceof backend\controllers\UserController)?'active':'']
    ];

$navItems[] = [
    'label' => 'Migrations', 
    'url' => '/backend/site/migrations', 
    'options' => ['class'=> (Yii::$app->requestedAction->id == 'migrations')?'active':'']
    ];

echo Nav::widget([
    'options' => ['class' => 'nav-pills nav-stacked'],
    'items' => $navItems,
]); 
