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
<?php $this->beginBlock('paypalCashoutPage1'); ?>
<div class="row">
	<div class="col-md-3">
		<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img class="img-responsive" src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" border="0" alt="PayPal Logo"></a></td></tr></table><!-- PayPal Logo -->
	</div>
	<div class="col-md-9">
		<p>PayPal is an online payment platform that is widely adopted by many popular 
		e-commerce sites. Through PayPal, you may deposit your cash to a credit 
		card or bank account.</p> 
		<p>Before cashing out, please make sure your email address 
		(<strong><?php echo Yii::$app->user->identity->email;?></strong>) is tied 
		to an <strong>active and verified <a href="https://www.paypal.com">Paypal</a> 
		account</strong>.</p>
    </div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('paypalCashoutPage2'); ?>
<div class="row">
	<div class="col-md-3">
		<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img class="img-responsive" src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" border="0" alt="PayPal Logo"></a></td></tr></table><!-- PayPal Logo -->
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-12">
				<img src="/images/logo.png" class="img-responsive" style="margin-top: 10px"/>
				<p>You may consider donating a part of your credits to the Education Incentive Program and helps schools supply tools needed for education.</p>
				<p>If you want to donate, just put a percentage value between 1-100 in the box below and choose your donation option.</p>
				<div class="alert alert-danger" id="donation-percentage-error" style="display:none"></div>
				<p>I have <strong>$ <?=$totalCreditValue?></strong> and 
				I want to donate <?=Html::input('text', $schoolDonationForm->formName()."[donationPercentage]", '0', ['id' => 'donation-percentage', 'style' => 'width: 30px'])?>% (<strong class="credits-to-donate">$ 0.00</strong>) to:</p>
				<?php		
				echo $form->field($schoolDonationForm, 'schoolDonationType', ['enableLabel' => false])
					->radioList($schoolDonationForm->schoolDonationTypes);
				?>
			</div>
		</div>		
		
	</div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('paypalCashoutPage3'); ?>
<div class="row">
	<div class="col-md-3">
		<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img class="img-responsive" src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" border="0" alt="PayPal Logo"></a></td></tr></table><!-- PayPal Logo -->
	</div>
	<div class="col-md-9">
        <img src="/images/logo.png" class="img-responsive" style="margin-top: 10px"/>
		<p>Please click on the button below to choose a specific school.</p>
		<p>I want to donate to: <strong><u class="target-school"><?=$schoolDonationForm->schoolName?></u></strong></p>
		<span class="btn btn-danger btn-sm" data-toggle="modal" data-target=".school-widget-dialog">Search School</span>
	</div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('paypalCashoutPage4'); ?>
<div class="row">
	<div class="col-md-3">
		<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img class="img-responsive" src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" border="0" alt="PayPal Logo"></a></td></tr></table><!-- PayPal Logo -->
	</div>
	<div class="col-md-9">
        <p>Please review the information below. If it is correct, click on the 'Next' 
        button to proceed with the cash out. Otherwise, click on the 'Previous' 
        button to change the cash out details.</p>
        <p id="donation-text">You have <strong><?=($totalCreditValue)?"<strong>\$$totalCreditValue</strong>":""?></strong> 
        and you want to donate <strong class="credits-to-donate"><?=$totalCredits?></strong> to <strong>
        <u class="target-school"><?=$schoolDonationForm->schoolName?></u></strong>.</p>
		<p class=""><strong class="credits-to-cashout"><?php echo $totalCredits;?></strong> 
		will be sent to your PayPal account.</p>
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
		'content' => $this->blocks['paypalCashoutPage1']];
	$tabs[] = [
		'label' =>'2',
		'content' => $this->blocks['paypalCashoutPage2']];
	$tabs[] = [
		'label' =>'3',
		'content' => $this->blocks['paypalCashoutPage3']];
	$tabs[] = [
		'label' =>'3',
		'content' => $this->blocks['paypalCashoutPage4']];

	echo TbWizard::widget([
	'type' => 'pills', // 'tabs' or 'pills'
	'navOptions' => ['class' => 'hidden'],
	'tabs' => $tabs,
	'id' => 'paypalCashOutWizard',
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
                
				if(index > 1)
				{
                    var x = $("#donation-percentage").val();
                    var parts = x.split(".");
                    var valid = true
                    if(typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2))
                        valid = false;
                    var n = parseFloat(x);
                    if(isNaN(n))
                        valid = false;
                    if(n < 0 || n > 100)
                        valid = false;

                    if(!valid){
                        $("#donation-percentage-error").show().text("Please enter a valid percentage value.");
                        return false;
                    }
                    else{
                        $("#donation-percentage-error").hide();
                        var creditsToDonate = ('.$totalCreditValue.' * (x/100)).toFixed(2);
                        var creditsToCashout = ('.$totalCreditValue.' - creditsToDonate).toFixed(2);
                        $(".credits-to-donate").text("$ "+creditsToDonate);
                        $(".credits-to-cashout").text("$ "+creditsToCashout);
                    }
                    
                    if(valid && n > 0)
                    {
                        $("#donation-text").show();
                        switch(schoolDonationType)
                        {
                            case "1":
                                if(index === 2){
                                    $(navigation).find("li:eq(3) a").tab("show");
                                    return false;
                                }
                                break;
                            case "2":
                                if(index === 2 && !$(".school-id").val()){
                                    $(".target-school").text("");                            
                                }
                                if(index === 3 && !$(".school-id").val()){
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
                    }
                    else if(valid && n == 0)
                    {
                        $("#donation-text").hide();
                        if(index === 2){
                            $(navigation).find("li:eq(3) a").tab("show");
                            return false;
                        }
                    }					
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
                
				if(index > 1)
				{
					switch(schoolDonationType)
					{
						case "1":
							if(index === 2){
								$(navigation).find("li:eq(2) a").tab("show");
                                return false;
							}
							break;
						case "2":
							if(index === 2 && !$(".school-id").val()){
								$(".target-school").text("");                            
							}							
							break;
						default:
							
							break;
					}
				}
			}'),
		'onTabShow' => new JsExpression('function(tab, navigation, index) 
			{		
				var total = navigation.find("li").length;
				var current = index+1;
				var percent = (current === 1)? 1 : (current/total) * 100;
				$(navigation).parent().parent().parent().find("#wizard-bar > .bar").css({width:percent+"%"});
                $(".next").removeClass("disabled");
			}'),
	)
	]);
	?>
</div>
<?php $form->end(); ?>