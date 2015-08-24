<?php
if($style == 'vertical')
	$data_type = 'top';
else
	$data_type = 'right';
//Yii::app()->clientScript->registerScript('LinkedInJS', array('content' => 'lang: en_US', 'src' => '//platform.linkedin.com/in.js'), CClientScript::POS_END);

$this->registerJs("$(document).ready(function() {
    $.getScript('//platform.linkedin.com/in.js?async=true', function success() {
        IN.init({
			lang: 'en_US',
        });
    });
});", yii\web\View::POS_END, 'linkedInJS');
?>
<?php if($noCounts): ?>
<div style="text-align: center; display: inline-block; width: <?php echo $width.'%';?>">
	<script type="IN/Share" data-url="<?php echo $url; ?>"></script>
</div>
<?php else: ?>
<div class="pull-left" style="margin-left: 5px">
	<script type="IN/Share" data-url="<?php echo $url; ?>" data-counter="<?php echo $data_type;?>" data-showZero="true"></script>
</div>
<?php endif; ?>
