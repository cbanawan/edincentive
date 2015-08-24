<?php if($noCounts): ?>
<div style="text-align: center; display: inline-block; width: <?php echo $width.'%';?>">
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url; ?>" data-lang="en" data-count="none" data-text="<?php echo $twitterText; ?>">Tweet</a>
</div>
<?php else: ?>
<div class="pull-left" style="margin-left: 5px">
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url; ?>" data-lang="en" data-count="<?=$style?>" data-text="<?php echo $twitterText; ?>">Tweet</a>
</div>
<?php endif; ?>

<?php
$this->registerJs("!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');", yii\web\View::POS_END, 'twitterJS');
?>