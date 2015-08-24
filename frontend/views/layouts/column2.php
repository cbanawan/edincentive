<?php
use yii\bootstrap\Nav;
use frontend\widgets\Alert;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="row">
	<div class="col-md-2">
		<div id="sidebar">
            <?php
            $navItems = [
            '<h4><i class="fa fa-user"></i>&nbsp;'.Yii::$app->user->identity->firstName.' '.Yii::$app->user->identity->lastName.'</h4>',
            [
                'label' => 'Survey Home', 
                'url' => Yii::$app->urlManager->createURL('/dashboard'), 
                'options' => ['class'=> (Yii::$app->requestedAction->id == 'index' && !(Yii::$app->controller->module->id == 'affiliate'))?'active':'']
            ],
            [
                'label' => 'Cash Out', 
                'url' => Yii::$app->urlManager->createUrl('/dashboard/cash-out'), 
                'options' => ['class'=> (Yii::$app->requestedAction->id == 'cash-out' && !(Yii::$app->controller->module->id == 'affiliate'))?'active':'']
            ],
            [
                'label' => 'My Account', 
                'url' => Yii::$app->urlManager->createURL('/dashboard/my-account'), 
                'options' => ['class'=> (Yii::$app->requestedAction->id == 'my-account')?'active':'']
            ],
            [
                'label' => 'Support', 
                'url' => Yii::$app->urlManager->createURL('/dashboard/support'), 
                'options' => ['class'=> (Yii::$app->requestedAction->id == 'support')?'active':'']
            ],
            [
                'label' => 'Profiles', 
                'url' => Yii::$app->urlManager->createURL('/dashboard/profile/'), 
                'options' => ['class'=> (Yii::$app->requestedAction->id == 'profile')?'active':'']
            ],            
        ];		

        echo Nav::widget([
            'options' => ['class' => 'nav-pills nav-stacked'],
            'items' => $navItems,
        ]);
        
        if(isset($this->blocks['profilesMainNav']))
        {
            echo $this->blocks['profilesMainNav'];
        }
        ?>
		</div><!-- sidebar -->
	</div>
	<div class="col-md-10">
		<div>			
			<?= Alert::widget() ?>
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>

