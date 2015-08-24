<?php
/* @var $this yii\web\View */
/* @var $schoolName string */
/* @var $schoolId int */
/* @var $memberName string */
?>
<p>
<?= ucfirst($memberName) ?>,<br/>
<br/>
Thanks for donating your rewards to <?= $schoolName ?>.<br/>
<br/>
Your contribution is very much appreciated. With the combined power of members of your community, donations like this will have a major impact.<br/>
<br/>
As an educator working with technology for the majority of my career my true hope is to make EdIncentive a platform that allows communities raise needed money for their schools.<br/>
<br/>
We hope that we can get more people in your community involved with this project. We are sending this email as my personal request to share this platform with others to get more people involved and help raise the needed funds for our schools.<br/>
<br/>
Please let me know what we can do to make this more effective. My direct email where you can reach me for your comments is colt@edincentive.com.<br/>
<br/>
Colt,<br/>
CEO, EdIncentive<br/>
<?php if($schoolId):?>
<?php
$schoolDashboardLink = Yii::$app->urlManager->createAbsoluteUrl(['site/school-dashboard', 'schoolId' => $schoolId]);
?>
PS: Progress can be monitored for this school at: <a href="<?= $schoolDashboardLink ?>"><?= $schoolDashboardLink ?></a>
<?php endif; ?>
</p>

