<?php
if($style == 'vertical')
	$data_type = 'box_count';
else
	$data_type = 'button_count';

 echo $this->registerJs("window.fbAsyncInit = function() {
	  FB.init({
		appId      : ".Yii::$app->params['fb_app_id'].",
		xfbml      : true,
		version    : 'v2.0'
	  });
	};

	(function(d, s, id){
	   var js, fjs = d.getElementsByTagName(s)[0];
	   if (d.getElementById(id)) {return;}
	   js = d.createElement(s); js.id = id;
	   js.src = '//connect.facebook.net/en_US/sdk.js';
	   fjs.parentNode.insertBefore(js, fjs);
	 }(document, 'script', 'facebook-jssdk'));",  yii\web\View::POS_END, 'FacebookJS');
?>

<?php if($noCounts): ?>
<div style="text-align: center; display: inline-block; width: <?php echo $width.'%'; ?>;">
	<div id="fb-root"></div>
	<div class="fb-share-button" data-href="<?php echo $url; ?>" data-width="200" data-layout="button"></div>
</div>	
<?php else: ?>
	<div class="pull-left" style="margin-left: 5px">
		<div id="fb-root"></div>
		<div class="fb-share-button" data-href="<?php echo $url; ?>" data-width="200" data-type="<?=$data_type?>"></div>
	</div>
<?php endif; ?>