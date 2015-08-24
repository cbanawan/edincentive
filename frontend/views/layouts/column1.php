<?php
use yii\bootstrap\Nav;
use frontend\widgets\Alert;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="row">
	<div class="col-md-12">
		<div>			
			<?= Alert::widget() ?>
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>

