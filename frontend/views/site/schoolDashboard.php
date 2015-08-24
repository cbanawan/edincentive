<?php
$description = '';
use frontend\widgets\SocialShareButton;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

?>
<div class="pull-right" style="max-width: 300px">
    <center>Start Helping Today!</center>
    <a class="btn btn-lg btn-success btn-block" href="/sign-up">Join Now</a>
</div>

<h1><?=$schoolData['schoolName']?></h1>
<span><?=$schoolData['street'].', '.$schoolData['city'].', '.$schoolData['state'].', '.$schoolData['zip']?></span><br/>
<br/>
<p>Welcome to the EdIncentive fundraising page for <strong><?=$schoolData['schoolName']?></strong>.
Below we will show the amounts that have been earned for this school. You can get 
others involved in this great cause by sharing the URL of this page or using one 
of the social buttons below.</p><br/>
<br/>
<?php
echo SocialShareButton::widget([
        'style' => 'horizontal',
		'url' => $url2Share,
		'addlParams' => [
			'pinterestImage' => $image,
			'pinterestDescription' => $description,
		],
        'networks' => ['facebook','googleplus','pinterest','linkedin','twitter'],
        'data_via'=>'', //twitter username (for twitter only, if exists else leave empty)
	]);
?><br/>
<br/>
<?php if($schoolData['totalAmt'] != 0):?>
<span>Total Earned: </span><strong>$ <?=$schoolData['totalAmt']?></strong>
<div class="row">
    <div class="col-md-6">
    <?php
    $gridDataProvider = new ArrayDataProvider([
            'allModels' => $schoolData['stats'],
            'pagination' => false,
        ]);

    $gridColumns = [
        [
            'attribute' => 'date', 
            'header' => 'Date',
        ],
        [
            'attribute' => 'amt', 
            'header' => 'Amount',
            'value' => function($data){ return "$ " . $data["amt"];}
        ],    
    ];

    echo GridView::widget([
        'dataProvider' => $gridDataProvider, 
        'columns' =>$gridColumns,
        'layout' => '{items}',
    ]);
    ?>    
    </div>
</div>

<?php else:?>
<p>Fundraising amounts will show up when the first person has donated to this school.  
    Be the first to earn for this school by taking surveys and donating to <strong><?=$schoolData['schoolName']?></strong>.</p>
<?php endif;?>