<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '<img src="/images/logo.png"/>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default',
                ],
            ]);
			
            $menuItems = [];
            
			if (Yii::$app->user->isGuest) {                
                $menuItems[] = '					
						<form class="navbar-form" method="POST" action="'.(Yii::$app->urlManager->createUrl('backend/site/login')).'" >
							<div class="form-group form-group-md"  style="padding-top:40px !important;">
								'.Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->csrfToken).'
								<input type="text" class="form-control" name="LoginForm[username]" placeholder="Username">
								<input type="password" class="form-control" name="LoginForm[password]" placeholder="Password">
								<button type="submit" class="btn btn-primary">Login</button>
							<//div>
						<//form>					
					';
				
            } 
			else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->userName . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
			
            echo Nav::widget([
                'options' => ['class' => 'navbar-right'],
                'items' => $menuItems,
            ]);
            
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
