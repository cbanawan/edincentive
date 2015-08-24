<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

$this->title = "Cash Out";
$this->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
//$this->registerMetaTag(['name' => 'keywords', 'content' => "school rewards, school incentives, earn money for schoolsr"], 'keywords');
//$this->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an easy way for you to earn extra money for your school."], 'description');
?>
<div class="row">
	<div class="col-md-12">
		<h1>Cash Out</h1>
		<?php if(Yii::$app->user->identity->statusId == 1):?>
		<div class="alert alert-error alert-danger">
			<p>Our records show that you have not confirmed your email address.<br/>
			<br/>
			<?php
			$resendConfirmLink = Yii::$app->urlManager->createAbsoluteUrl('/dashboard/send-confirmation-email');
			?>
			Please click on the link in the confirmation email you received on sign up. If you are having trouble finding it, <a href="<?php echo $resendConfirmLink;?>">Click here</a> to re-send the confirmation email.</p>
		</div>
		<?php else:?>
		<span>Total Points: </span><strong><?php echo $totalPoints;?></strong><br/>
		<span>Total Credits: </span><strong><?php echo $totalCredits;?></strong><br/>
		<p>You must have a minimum of: <strong><?php echo $minCashout;?></strong> credits to cash out.</p>
        <br/>
        <?php
        $this->beginBlock('educationIncentive');
        ?>
        <div class="row">            
            <div class="col-md-12">            
            <?php
            echo $this->render('schoolSelect',[
                'schoolDonationForm' => $schoolDonationForm,
                'cashoutType' => 2,
                'totalCreditValue' => $totalCreditsValue,
            ]);
            ?>
            </div>
        </div>      
        <?php
        $this->endBlock();
        ?>
        <?php
        $this->beginBlock('paypal');
        ?>
        <div class="row">
            <div class="col-md-12">
            <?php
            echo $this->render('paypalCashOut',[
                'schoolDonationForm' => $schoolDonationForm,
                'cashoutType' => 1,
                'totalCreditValue' => $totalCreditsValue,
            ]);
            ?>
            </div>           
        </div>
        
        
        <?php
        $this->endBlock();
        
        echo Tabs::widget([
            'items' => [
                [
                    'label' => 'Education Incentive Program',
                    'content' => $this->blocks['educationIncentive'],
                    'active' => ((isset($tabOptions) && $tabOptions['active'] == 2))?true:false,
                    'options' => ['id' => 'education-incentive']
                ],
                [
                    'label' => 'Paypal',
                    'content' => $this->blocks['paypal'],
                    'active' => ((isset($tabOptions) && $tabOptions['active'] == 1))?true:false,
                    'options' => ['id' => 'paypal']
                ]
            ]
        ]);
        ?>
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
            $("input[name=\'SchoolDonationForm[schoolDonationType]\']").click(function(){
                if($(this).attr("value") == 1)
                {
                    $(".target-school").text("The Education Incentive Fund");
                    $(".school-id").removeAttr("value");
                }
                var value = $(this).attr("value");
                $.each($("input[name=\'SchoolDonationForm[schoolDonationType]\']"), function (i,e){
                    if($(e).attr("value") == value)
                    {
                        $(e).prop("checked", true);
                    }
                    else
                    {
                        $(e).prop("checked", false);
                    }
                });
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
        ?>
		<?php endif;?>
		<div class="clearfix"></div>
	</div>	
</div>
