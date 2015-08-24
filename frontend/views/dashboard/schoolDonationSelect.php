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
	<div class="col-sm-6">
        <h1>Thank You for Supporting <br/>Local Schools!</h1>
		<p>EdIncentive exists to help you raise funds for schools in your area.<br/> 
        Please <strong>click the button</strong> below to search and select a 
        specific school you want to support.</p>
        
        <p>I want to donate to: <strong><u class="target-school"><?=$schoolDonationForm->schoolName?></u></strong><br/>
        <span class="btn btn-danger btn-sm search-school-btn" data-toggle="modal" data-target=".school-widget-dialog">Search Schools</span>
        </p>
        
        <p>If you do not want to donate to a specific school, select the General 
        Education Fund and we will use it to support schools in your area.</p>
		<?php
        $listOptions = $schoolDonationForm->schoolDonationTypes;
        unset($listOptions[2]);
        $listOptions[1] = "General Education Fund - ".$listOptions[1];
		?>
		<div class="checkbox">
		<?php
        echo Html::checkbox('donationType', ($schoolDonationForm->schoolDonationType == 1), [
			'id' => 'general-fund-checkbox', 
			'value' => '1',
			'label' => $listOptions[1]]);
		?>
		</div>
		<?php
		echo $form->field($schoolDonationForm, 'schoolDonationType', ['enableLabel' => false])
		   ->hiddenInput();
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
		<p>You have selected <strong><u class="target-school"><?=($schoolDonationForm->schoolDonationType == 2) ? $schoolDonationForm->schoolName : "The Education Incentive Fund"?></u></strong> 
        to support schools in your area.  If you want to change this choice now 
        please click the 'Previous' button.<br/>
        <br/>
        You can change this option in the future when you cash out to donate funds. When you click next, you will be able to fill out your profiles which will help qualify you for future surveys.</p>
    </div>
</div>
<?php $this->endBlock(); ?>

<div class="well school-donation-wizard" style="background: #f4f4f4 url('/images/woman-school.png') no-repeat left center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    color: #000000;
    position: relative;">	
    
	<?php
	$tabs[] = [
		'label' =>'1',
		'content' => $this->blocks['schoolSelectPage1']];
	$tabs[] = [
		'label' =>'2',
		'content' => $this->blocks['schoolSelectPage2']];
	
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
                var schoolDonationType = $("#schooldonationform-schooldonationtype");
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
                        }
                        break;
                    
                    default:
                        if(!$(".school-id").val())
                        {
                            $(".school-donation-error").text("Please choose a school donation option. ");
                            $(".school-donation-error").show();
                            return false;
                        }
                        break;
                }
				
				var total = navigation.find("li").length;
				var current = index+1;
				
				if(current > total)
				{
                    var ajaxLoading = new ajaxLoader($(".school-donation-wizard"));
					$("#school-donation-form").submit();
				}
			}'),
		'onPrevious' => new JsExpression('function(tab, navigation, index)
			{
				
			}'),
		'onTabShow' => new JsExpression('function(tab, navigation, index) 
			{
                if(index > 0)
                {
                    $(".school-donation-wizard").css("background-position","0px -9999px");
                    $(".school-donation-wizard").css("background-attachment","fixed");                    
                }
                else
                {
                    $(".school-donation-wizard").css("background-position","left center");
                    $(".school-donation-wizard").css("background-attachment","");                    
                }
                
				$(".next").removeClass("disabled");
			}'),
	)
	]);
	?>
    <div class="alert alert-danger school-donation-error" style="display:none"></div>
</div>
<?php $form->end(); ?>
<div id="school-widget"></div>
<?php
$this->registerJsFile('/js/react.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('/js/schoolWidget.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJs('React.render(React.createElement(SchoolSearchWidget, {
    inputId: "school-widget",
    schoolIdInput: ".school-id",
    schoolNameInput: ".school-name",
    schoolSearchUrl: "/dashboard/ajax-school-search"}), 
    document.getElementById("school-widget"));');

$this->registerJs('
    
	$("#general-fund-checkbox").click(function(){
		if($(this).prop("checked"))
		{
			$(".target-school").text("The Education Incentive Fund");
            $(".school-id").removeAttr("value");
			$("#schooldonationform-schooldonationtype").val("1");
		}
		else
		{
			$(".target-school").text("");
            $(".school-id").removeAttr("value");
			$("#schooldonationform-schooldonationtype").val("2");
		}
	});
    
    $(".search-school-btn").click(function(){
       $("#schooldonationform-schooldonationtype").val("2");
	   $("#general-fund-checkbox").attr("checked", false);
    });
    
    $("#donation-percentage").change(function(e){
        var x = $(this).val();
        var parts = x.split(".");
        var valid = true
        if(typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2))
            valid = false;
        var n = parseFloat(x);
        if(isNaN(n))
            valid = false;
        if(n < 0 || n > 100)
            valid = false;

        if(!valid)
            $("#donation-percentage-error").show().text("Please enter a valid percentage value.");
        else{
            $("#donation-percentage-error").hide();
            var creditsToDonate = ('.$totalCreditsValue.' * (x/100)).toFixed(2);
            var creditsToCashout = ('.$totalCreditsValue.' - creditsToDonate).toFixed(2);
            $("#credits-to-donate").text("$ "+creditsToDonate);
            $("#credits-to-cashout").text("$ "+creditsToCashout);
        }
    });    
    ');
