<?php 
/* @var $this Controller */ 
use frontend\widgets\Alert;
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<div class="row">
	<div class="col-md-2">
		<div id="sidebar">
			<?php 
				echo $this->render('/layouts/adminSidebar');
			?>
		</div><!-- sidebar -->
	</div>
	<div class="col-md-10">
		<div id="content">
            <?= Alert::widget() ?>
			<?= $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>