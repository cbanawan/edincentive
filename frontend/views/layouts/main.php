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
			
            $menuItems[] = [
                    'label' => 'Home',
                    'url' => ['/site/index'],
                    'visible' => Yii::$app->user->isGuest
                ];
            $menuItems[] = [
                    'label' => 'Join',
                    'url' => ['/site/sign-up'],
                    'visible' => Yii::$app->user->isGuest
                ];
            $menuItems[] = [
                    'label' => 'School Rewards',
                    'url' => ['/site/page', 'view' => 'school-rewards'],
                    //'visible' => Yii::$app->user->isGuest
                ];
            /*$menuItems[] = [
                    'label' => 'Blog',
                    'url' => ['/site/blog'],
                    //'visible' => Yii::$app->user->isGuest
                ];*/
            $menuItems[] = [
                    'label' => 'Support',
                    'url' => ['/site/page', 'view' => 'support'],
                    'visible' => Yii::$app->user->isGuest
                ];
            $menuItems[] = [
                    'label' => 'About',
                    'url' => ['/site/page', 'view' => 'about'],
                    //'visible' => Yii::$app->user->isGuest
                ];
			if (Yii::$app->user->isGuest) {                
                /*$menuItems[] = 
                    '					
						<form class="navbar-form" method="POST" action="'.Yii::$app->urlManager->createUrl('/site/login').'" >
							<div class="form-group form-group-md"  style="padding-top:10px !important;">
								'.Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->csrfToken).'
								<input type="text" class="form-control" name="LoginForm[email]" placeholder="Email Address">
								<input type="password" class="form-control" name="LoginForm[password]" placeholder="Password">
								<button type="submit" class="btn btn-success">Login</button>
							</div>
						</form>					
					';*/
				$activeClass = (Yii::$app->controller->action->id == 'login') ? 'class="active"' : '';
                $menuItems[] = '<li ' . $activeClass . ' ><a href="' . Yii::$app->urlManager->createUrl('/dashboard') . '"><i class="fa fa-sign-in"></i> Login</a></li>';
            } 
			else 
            {                
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->email . ')',
                    'url' => ['/site/logout'],
                    'active' => Yii::$app->controller->id == 'dashboard'
                ];
            }
			
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        <footer class="footer">
            <div class="container">
                <p style="padding-top: 10px">&copy; <?= Yii::$app->name ?> <?= date('Y') ?>. EdIncentive is a division of <a href="http://ednak.com" target="_blank">Ednak.com</a>.</p>
            <ul class="nav nav-pills">
                <li><a href="https://www.facebook.com/pages/Edincentive/1563845627223316" target="_blank"><i class="fa fa-2x fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/edincentive" target="_blank"><i class="fa fa-2x fa-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/company/edincentive" target="_blank"><i class="fa fa-2x fa-linkedin"></i></a></li>
                <li><a href="https://www.pinterest.com/edincentive/" target="_blank"><i class="fa fa-2x fa-pinterest"></i></a></li>
                <li><a href="https://plus.google.com/b/107631466930282618448/107631466930282618448/about" target="_blank"><i class="fa fa-2x fa-google-plus"></i></a></li>
                <li><a href="/user-agreement" target="_blank">User Agreement</a></li>
                <li><a href="/privacy-policy" target="_blank">Privacy Policy</i></a></li>
            </ul>
            </div>
        </footer>
        </div>
    </div>
    <?php
    if (isset(Yii::$app->params['ga_script']))
    {
        echo Yii::$app->params['ga_script'];
    }
    ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
