<?php
use yii\bootstrap\Nav;

$this->title = "Profiles";
$this->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
//$this->registerMetaTag(['name' => 'keywords', 'content' => "school rewards, school incentives, earn money for schoolsr"], 'keywords');
//$this->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an easy way for you to earn extra money for your school."], 'description');

$this->beginBlock('profilesMainNav');
?>
<div class="btn nav-header hidden-md hidden-lg" data-toggle="collapse" data-target=".sidebar-collapse"><span class="btn fa fa-bars"></span> Profiles</div>
<?php
foreach($profiles as $profile)
{
    $style = 'width: '.$profile['progress'].'%';
	$activeClass = ($profileId == $profile['profileId'])?'active':'';
	
	$navItems[] = '
		<li class="'.$activeClass.'">
		<div class="profile'.$profile['profileId'].' profile-nav">
			<a href="'.Yii::$app->urlManager->createURL('/dashboard/profile/'.$profile['profileId']).'">'.$profile['profileName'].'
				<div id="wizard-bar" class="progress">
					<div class="bar progress-bar progress-bar-primary" style="'.$style.'"></div>
				</div>
			</a>
		</div>
		</li>';
	
	
}

/*for(reset($profiles); key($profiles) !== null; next($profiles))
{
	$profile = current($profiles);
	$key = key($profiles);
			
	if($key > 0)
	{
		$previousProfile = $profiles[$key - 1];
		$nextProfile[$previousProfile->profileId] = $profile->profileId;
	}
		
	$attrs['memberId'] = $member->memberId;
	$attrs['profileId'] = $profile->profileId;
	
	$memberProfile = MemberProfile::findOne($attrs);
	$style = "";
	
	if($memberProfile->memberProfileStatusId == $profileStatusComplete)
	{
		$style = "width: 100%";
	}
	elseif($memberProfile->memberProfileStatusId == $profileStatusInProgress)
	{
		if($profile->profileId == 1)
		{
			$pModel = new BasicProfile($member);
			if($pModel->currentIndex == 0 && $pModel->validate())
			{
				$pModel->getBehavior('Survey')->questionData[0] = 1; //this makes it go to the next question after the first "special" page.
				$pModel->goToLastAnsweredQuestion();
			}
		}
		else
		{
			$pModel = new GenericProfile($member, $profile->profileId);
			$pModel->goToLastAnsweredQuestion();
		}
		
		
		$style = "width: ".floor((($pModel->getBehavior('Survey')->currentIndex + 1)/(count($pModel->getBehavior('Survey')->questions)+1))*100)."%";
	}
	
	$activeClass = ($profileId == $profile->profileId)?'active':'';
	$navItems[] = '
		<li class="'.$activeClass.'">
		<div class="profile'.$profile->profileId.' profile-nav">
			<a href="'.Yii::$app->urlManager->createURL('/dashboard/profile/'.$profile->profileId).'">'.$profile->profileName.'</a>
			<div id="wizard-bar" class="progress">
				<div class="bar progress-bar progress-bar-info" style="'.$style.'"></div>
			</div>			
		</div>
		</li>';

}*/?>
<div class="sidebar-collapse collapse in">
<?php
echo Nav::widget([
		'options' => ['class' => 'nav-pills nav-stacked', 'id' => 'profile-list'],
		'items' => $navItems,
	]);
?>
</div>
<?php			
$this->endBlock();
?>

<?php if($profileId):?>
<div class="well">	
    <div id="profile-widget">
        <img src="/images/spinner.gif" />
    </div>	
</div>
<?php
$this->registerJsFile('/js/react.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('/js/profileWidget.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJs('React.render(React.createElement(ProfileSurvey, {
    nextBtnUrl: "/dashboard/ajax-survey-next-button", 
    previousBtnUrl: "/dashboard/ajax-survey-previous-button", 
    startBtnUrl: "/dashboard/ajax-survey-start-over",
    nextProfileUrl: "/dashboard/profile/",
    profileId: "'.$profileId.'"}), 
    document.getElementById("profile-widget"));');
?>
<?php endif;?>
