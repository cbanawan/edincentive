<?php
/*
 *  @var $this yii\web\View
 */
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Dashboard";
$this->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
//$this->registerMetaTag(['name' => 'keywords', 'content' => "school rewards, school incentives, earn money for schoolsr"], 'keywords');
//$this->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an easy way for you to earn extra money for your school."], 'description');
?>
<h1>Welcome To <?=Yii::$app->name?></h1>
<?php
$formatter = Yii::$app->formatter;
?>
<div class="dashboard-main">
<div id="member-invites-container" style="display:none">
    <span class="label label-success h3">You have <strong id="invite-count"><?php echo $invitationCount; ?></strong> survey invitations!</span>
    <br/>
    <div id="member-invites"></div>
</div>

<?php if($profileId): ?>
<div class="well">	
    <div id="profile-widget">
        <img src="/images/spinner.gif" />
    </div>	
</div>
<?php endif; ?>

<h3>Transaction History</h3>
<span class="text-muted">Total Points: </span><strong id="total-points"><?php echo $totalPoints;?></strong><br/>
<span class="text-muted">Total Credits: </span><strong id="total-credits"><?php echo $totalCredits;?></strong><br/>
<br/>
<div id="member-txns"></div>
</div>

<?php
$this->registerJsFile('/js/ajaxGrid.js', ['depends' => ['yii\web\JqueryAsset']]);
// member invitations
$this->registerJs('React.render(React.createElement(AjaxGrid, {
        id: "member-invites-table",
        url: "/dashboard/ajax-load-member-invites", 
        afterDataLoad: function(data){$("#invite-count").text(data.rows.length); if(data.rows.length > 0){$("#member-invites-container").fadeIn(300);}}, 
        }), 
        document.getElementById("member-invites"));');

// member transactions
$this->registerJs('React.render(React.createElement(AjaxGrid, {
        id: "member-txns-table",
        url: "/dashboard/ajax-load-member-transactions", 
        afterDataLoad: function(data){$("#total-credits").text(data.totalCredits);$("#total-points").text(data.totalPoints);}, 
        }), 
        document.getElementById("member-txns"));');

if($profileId)
{
    $this->registerJsFile('/js/profileWidget.js', ['depends' => ['yii\web\JqueryAsset']]);
    $this->registerJs('React.render(React.createElement(ProfileSurvey, {
        nextBtnUrl: "/dashboard/ajax-survey-next-button", 
        previousBtnUrl: "/dashboard/ajax-survey-previous-button", 
        startBtnUrl: "/dashboard/ajax-survey-start-over",
        nextProfileUrl: "/dashboard/profile/",
        profileId: "'.$profileId.'"}), 
        document.getElementById("profile-widget"));');
}

