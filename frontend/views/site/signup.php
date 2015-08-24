<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name.' - Sign Up';
?>
<div class="site-index">
	<div class="row">
        
        <div class="col-md-7">
            <?php
            $slideItems[] = '
               <div class="slide">
                  <img class="img-responsive" style="margin: 10px auto;" src="/images/signup-1.png" alt="">
                  <div style="text-align: center; padding: 0 10%;">
                     <h2>Sign Up to Help Local Schools</h2>
                     <p>EdIncentive gives parents and teachers a way to turn spare time into spare change for their school. Sign up, select a school and take surveys to earn rewards.</p>                     
                  </div>
               </div>';

            $slideItems[] = '
               <div class="slide">
                  <img class="img-responsive" style="margin: 10px auto;" src="/images/slide2b-500.png" alt="">
                  <div style="text-align: center; padding: 0 10%;">
                     <h2>Complete Surveys<br/> from the Comfort of Anywhere</h2>
                     <p>We make it easy to earn rewards while helping shape future products. By investing minimal time at your convenience, you can earn money with each survey you complete. Personalize your profile to qualify for surveys that are relevant to you.</p>
                  </div>
               </div>';

            echo \yii\bootstrap\Carousel::widget([
                'items' => $slideItems,
                'showIndicators' => false,
                'clientOptions' => ['interval' => 13000],
                'controls' => ['<span class="glyphicon glyphicon-chevron-left"></span>','<span class="glyphicon glyphicon-chevron-right"></span>'],
                'options' => ['id' => 'signupSlider', 'class' => 'slide'],
            ]);
            ?>            
        </div>
        
        <div class="col-md-5">
            <img class="img-responsive" style="margin: -15px 0px; position:relative; z-index: 999;" src="/images/signup.png" alt="Sign Up">
			<div class="well" style="position:relative">
                <?php
				$form = ActiveForm::begin([
					'id' => 'signup-form',
					'enableClientValidation' => true,
					'validateOnSubmit' => true
				]);
				echo $form->field($signupForm, 'firstName');
				echo $form->field($signupForm, 'lastName');
				echo $form->field($signupForm, 'email');
				echo $form->field($signupForm, 'password')->passwordInput();
				echo $form->field($signupForm, 'yearOfBirth')->dropDownList($yearOfBirthList);
				?>
				<div>
					<p>By clicking the signup button below you are agreeing to the <a href="/user-agreement" target="_blank">User Agreement</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.</p>
				</div>
				<div class="row" style="margin: auto">
					<?php
					echo Html::submitButton('<i class="icon fa fa-male"></i> I am Male ', array('name' => 'SignupForm[gender]', 'value' => 'm', 'class' => 'btn btn-lg btn-success pull-left', 'style' => 'width: 47%; position: relative; overflow: visible'));
					?>

					<?php
					echo Html::submitButton('<i class="icon fa fa-female"></i> I am Female ', array('name' => 'SignupForm[gender]', 'value' => 'f', 'class' => 'btn btn-lg btn-success pull-right', 'style' => 'width: 47%; position: relative; overflow: visible'));
					?>
				</div>
				<?php
					ActiveForm::end();
				?>
			</div>			
		</div>
				
	</div>   
</div>
<?php
$this->registerJsFile('/js/jquery.passstrength.min.js.js', ['position' => \yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJs("$('#signupform-password').passStrengthify({element:$('label[for=signupform-password]'), minimum:8, labels:{tooShort:'Min. 8 characters'}});");
$this->registerJs('
    var ajaxLoading = null;
    $("#signup-form").on("afterValidate", function(event, messages){
        if($(event.target).find(".has-error").length == 0){
            var ajaxLoading = new ajaxLoader($(event.target).closest("form").parent());
        }
    });
    ');
$this->registerCss("
   label[for=signupform-password] {display: block;}
   label[for=signupform-password] .passStrengthify {float: right;}");
