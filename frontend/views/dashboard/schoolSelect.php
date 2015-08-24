<?php
use yii\bootstrap\ActiveForm;
use frontend\widgets\TbWizard;
use yii\helpers\Html;
use yii\web\JsExpression;
?>
<?php
$form = ActiveForm::begin([
    'enableClientValidation' => false,
    'validateOnSubmit' => true,
    'options' => ['id' => 'school-donation-form']
]);

echo Html::hiddenInput($schoolDonationForm->formName()."[cashoutType]", $cashoutType);
echo $form->field($schoolDonationForm, 'schoolId', ['enableLabel' => false])->hiddenInput(['class' => 'school-id']);
echo $form->field($schoolDonationForm, 'schoolName', ['enableLabel' => false])->hiddenInput(['class' => 'school-name']);
?>
<?php $this->beginBlock('schoolSelectPage1'); ?>
<div class="row">
	<div class="col-md-3">
		<img src="/images/logo-med.png"/>
	</div>
	<div class="col-md-9">
		<p>Donate money to a school near you and help them supply 
		tools needed for education. To get started, please choose a donation option below.</p>
		<p>I want to donate <?=($totalCreditValue)?"<strong>\$$totalCreditValue</strong>":""?> to:</p>
		<?php		
        echo $form->field($schoolDonationForm, 'schoolDonationType', ['enableLabel' => false])
            ->radioList($schoolDonationForm->schoolDonationTypes);
		?>
	</div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('schoolSelectPage2'); ?>
<div class="row">
	<div class="col-md-3">
		<img src="/images/logo-med.png"/>
	</div>
	<div class="col-md-9">
		<p>Please click on the button below to choose a specific school.</p>
		<p>I want to donate <?=($totalCreditValue)?"<strong>\$$totalCreditValue</strong>":""?> 
            to: <strong><u class="target-school"><?=$schoolDonationForm->schoolName?></u></strong></p>
		<span class="btn btn-danger btn-sm" data-toggle="modal" data-target=".school-widget-dialog">Search School</span>
	</div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('schoolSelectPage3'); ?>
<div class="row">
	<div class="col-md-3">
		<img src="/images/logo-med.png"/>
	</div>
	<div class="col-md-9">
        <p>Please review the information below. If it is correct, click on the 'Next' 
        button to proceed with the cash out. Otherwise, click on the 'Previous' 
        button to change the cash out details.</p>
        
        <p>I want to donate <?=($totalCreditValue)?"<strong>\$$totalCreditValue</strong>":""?> to <strong>
        <u class="target-school"><?=$schoolDonationForm->schoolName?></u></strong></p>
    </div>
</div>
<?php $this->endBlock(); ?>

<div class="well">
	<div id="wizard-bar-container" class="" style="position:relative">
        <div id="wizard-bar" class="progress">
            <div class="bar progress-bar progress-bar-info"></div>
        </div>
    </div>
    <div class="alert alert-danger school-donation-error" style="display:none"></div>
	<?php
	$tabs[] = [
		'label' =>'1',
		'content' => $this->blocks['schoolSelectPage1']];
	$tabs[] = [
		'label' =>'2',
		'content' => $this->blocks['schoolSelectPage2']];
	$tabs[] = [
		'label' =>'3',
		'active' => ($schoolDonationForm->schoolDonationType == 1 || ($schoolDonationForm->schoolDonationType == 2 && $schoolDonationForm->schoolId > 0)),
		'content' => $this->blocks['schoolSelectPage3']];

	echo TbWizard::widget([
	'type' => 'pills', // 'tabs' or 'pills'
	'navOptions' => ['class' => 'hidden'],
	'tabs' => $tabs,
	'id' => 'schoolSelectWizard',
	'pagerContent' => '
				<div class="pager wizard row-fluid">
					<input type="button" value="Previous" class="previous btn btn-primary pull-left" style="width: 48%" />
					<input type="button" value="Next" href="#" class="next btn btn-primary pull-right" style="width: 48%" />
				</div>
				',
	'options' => array(
		'nextSelector' => '.next',
		'previousSelector' => '.previous',
		'onNext' => new JsExpression('function(tab, navigation, index)
			{
                $(".school-donation-error").hide();
                var schoolDonationType = $("#schooldonationform-schooldonationtype input[type=radio]:checked");
                if(schoolDonationType.length > 0){
                    schoolDonationType = schoolDonationType.val();
                }
                else{
                    schoolDonationType = null;
                }
                
                switch(schoolDonationType)
                {
                    case "1":
                        if(index === 1){
                            $(navigation).find("li:eq(2) a").tab("show");
                            return false;
                        }
                        break;
                    case "2":
                        if(index === 1 && !$(".school-id").val()){
                            $(".target-school").text("");                            
                        }
                        if(index === 2 && !$(".school-id").val()){
                            $(".school-donation-error").text("Please choose a school.");
                            $(".school-donation-error").show();
                            return false;
                        }
                        break;
                    default:
                        $(".school-donation-error").text("Please choose a school donation option. ");
                        $(".school-donation-error").show();
                        return false;
                        break;
                }
				
				var total = navigation.find("li").length;
				var current = index+1;
				
				if(current > total)
				{
					$("#school-donation-form").submit();
				}
			}'),
		'onPrevious' => new JsExpression('function(tab, navigation, index)
			{
				var schoolDonationType = $("#schooldonationform-schooldonationtype input[type=radio]:checked");
                if(schoolDonationType.length > 0){
                    schoolDonationType = schoolDonationType.val();
                }
                else{
                    schoolDonationType = null;
                }
                
                switch(schoolDonationType)
                {
                    case "1":
                        if(index === 1){
                            $(navigation).find("li:eq(0) a").tab("show");
                            return false;
                        }
                        break;
                    case "2":
                        if(index === 1 && !$(".school-id").val()){
                            $(".target-school").text("");                            
                        }
                        if(index === 2 && !$(".school-id").val()){
                            $(".school-donation-error").text("Please choose a school.");
                            $(".school-donation-error").show();
                            return false;
                        }
                        break;
                    default:
                        $(".school-donation-error").text("Please choose a school donation option. ");
                        $(".school-donation-error").show();
                        return false;
                        break;
                }
			}'),
		'onTabShow' => new JsExpression('function(tab, navigation, index) 
			{		
				var total = navigation.find("li").length;
				var current = index+1;
				var percent = (current === 1)? 1 : (current/total) * 100;
				$(navigation).parent().parent().find("#wizard-bar > .bar").css({width:percent+"%"});
                $(".next").removeClass("disabled");
			}'),
	)
	]);
	?>
</div>
<?php $form->end(); ?>

