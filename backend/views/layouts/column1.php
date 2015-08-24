<?php 
/* @var $this Controller */ 
use frontend\widgets\Alert;
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<div id="content" class="row">
	<div class="col-md-12">
        <?= Alert::widget() ?>
		<?php echo $content; ?>
	</div>	
</div><!-- content -->
<?php $this->endContent(); ?>