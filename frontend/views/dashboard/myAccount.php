<?php
/* @var $this yii\web\View */
/* @var $resetPasswordForm ResetPasswordForm */
/* @var $unsubscribeForm Form */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\bootstrap\Collapse;

$this->title = "My Account";
$this->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
//$this->registerMetaTag(['name' => 'keywords', 'content' => "school rewards, school incentives, earn money for schoolsr"], 'keywords');
//$this->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an easy way for you to earn extra money for your school."], 'description');
?>
<h1>My Account</h1>
<?php
$formatter = Yii::$app->formatter;
$cintTransactions = $transactions;

foreach($cintTransactions as &$transaction)
{
	if($transaction['cintTransactionTypeKey'] == 'tt_pay')
	{
		$totalCredits -= $transaction['cintMemberTransactionAmount'];
		//$totalPoints -= $transaction['cintMemberTransactionPoints'];
	}
	else
	{
		$totalCredits += $transaction['cintMemberTransactionAmount'];
		//$totalPoints += $transaction['cintMemberTransactionPoints'];
	}
	$transaction['cintMemberTransactionPoints'] = $transaction['cintMemberTransactionAmount']*100;
	$transaction['cintMemberTransactionAmount'] = str_ireplace('USD', '$', $formatter->asCurrency($transaction['cintMemberTransactionAmount']));
}
$totalCredits = round($totalCredits, 3);
$totalPoints = $totalCredits*100;
$totalCredits = str_ireplace('USD', '$', $formatter->asCurrency($totalCredits));
?>
<span>Total Points: </span><strong><?php echo $totalPoints;?></strong><br/>
<span>Total Credits: </span><strong><?php echo $totalCredits;?></strong><br/>
<br/>
<?php
// Reset password form
$resetPassword = $this->render('@frontend/views/site/resetPassword.php', ['formModel' => $resetPasswordForm]);

// Unsubscribe form
$unsubscribe = $this->render('@frontend/views/site/unsubscribe.php');

// Change email form

$changeEmail = $this->render('changeEmail', [
	'changeEmailForm' => $changeEmailForm,
	'memberModel' => $memberModel,
	'emailUpdateRequestSent' => $emailUpdateRequestSent
]);

if(!$accordionOptions)
{
	$accordionOptions['active'] = null;
}
Yii::trace($accordionOptions);
$panels[] = [
	'label' => '<i class="fa fa-caret-right"></i> '.'Reset Password',
	'content' => $resetPassword,
	'contentOptions' => [
        'class' => (0 === $accordionOptions['active'])?'in':'',
    ],
];
$panels[] = [
	'label' => '<i class="fa fa-caret-right"></i> '.'Change Email',
	'content' => $changeEmail,
	'contentOptions' => [
        'class' => (1 == $accordionOptions['active'])?'in':'',
    ],
];

$panels[] = [
	'label' => '<i class="fa fa-caret-right"></i> '.'Unsubscribe',
	'content' => $unsubscribe,
	'contentOptions' => [
        'class' => (3 == $accordionOptions['active'])?'in':'',
    ],
];

echo Collapse::widget([
	'items' => $panels,
	'encodeLabels' => false,
	'options' => ['id' => 'my-acct-items'],
]);

$this->registerJs('    
		$(".panel-group .panel-collapse").on("shown.bs.collapse", function (e) {
		   $(e.target).siblings(".panel-heading").find(".fa-caret-right").first().removeClass("fa-caret-right").addClass("fa-caret-down");
		});

		$(".panel-group .panel-collapse").on("hidden.bs.collapse", function (e) {
		   $(e.target).siblings(".panel-heading").find(".fa-caret-down").first().removeClass("fa-caret-down").addClass("fa-caret-right");
		});
	');
