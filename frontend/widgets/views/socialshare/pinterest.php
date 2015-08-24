<?php
$this->registerJs("(function(d){
    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
    p.type = 'text/javascript';
    p.async = true;
    p.src = '//assets.pinterest.com/js/pinit.js';
    f.parentNode.insertBefore(p, f);
}(document));", yii\web\View::POS_END, 'pinterestJS');
?>
<?php if($noCounts):?>
<div style="text-align: center; display: inline-block; width: <?php echo $width.'%';?>">
	<a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&media=<?php echo urlencode($pinterestImage); ?>&description=<?php echo urlencode($pinterestDescription); ?>" class="pin-it-button" data-pin-do="buttonPin" data-pin-config="none"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
</div>
<?php else:?>
<div class="pull-left" style="margin-left: 5px">
	<div style="margin-right: 30px;">
	<a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&media=<?php echo urlencode($pinterestImage); ?>&description=<?php echo urlencode($pinterestDescription); ?>" class="pin-it-button" data-pin-do="buttonPin" data-pin-zero="true" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
	</div>
</div>
<?php endif;?>
