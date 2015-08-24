<?php
if($style == 'vertical')
	$data_type = 'vertical-bubble';
else
	$data_type = 'bubble';

$this->registerJs("(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/platform.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();", 
	yii\web\View::POS_END, 'googlePlusJS');
?>

<?php if($noCounts): ?>
<div style="text-align: center; display: inline-block; width: <?php echo $width.'%';?>">
	<div class="g-plus" data-href="<?php echo $url; ?>" data-action="share" data-annotation="none"></div>
</div>
<?php else: ?>
<div class="pull-left" style="margin-left: 5px">
	<div class="g-plus" data-href="<?php echo $url; ?>" data-action="share" data-annotation="<?=$data_type?>"></div>
</div>
<?php endif; ?>
