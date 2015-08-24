<?php
$slideItems[] = '
   <div class="slide">
      <img class="pull-right img-responsive" style="margin-right: 10%; width: 40%" src="/images/slide1b-500.png" alt="">
      <div class=" carousel-caption">
         <h3><b>Sign Up to Help Local Schools<br/></b></h3>
         <p style="width: 60%">EdIncentive gives parents and teachers a way to turn spare time into spare change for their school. Sign up, select a school, complete your profile and earn rewards.</p>
         <p></p>
      </div>
   </div>';

$slideItems[] = '
   <div class="slide">
      <img class="pull-right img-responsive" style="margin-right: 15%;" src="/images/slide2b-500.png" alt="">
      <div class=" carousel-caption">
         <h3><b>Complete Surveys<br/> from the Comfort of Anywhere</b></h3>
         <p style="width: 60%">We make it easy to earn rewards while helping shape future products. By investing minimal time at your convenience, you can earn money with each survey you complete. Personalize your profile to qualify for surveys that are relevant to you.</p>
      </div>
   </div>';

echo \yii\bootstrap\Carousel::widget([
    'items' => $slideItems,
    'clientOptions' => ['interval' => 12000],
    'controls' => ['<span class="glyphicon glyphicon-chevron-left"></span>','<span class="glyphicon glyphicon-chevron-right"></span>'],
    'options' => ['id' => 'homeSlider', 'class' => 'visible-md visible-lg slide'],
]);
?>
<a class="joinButton btn btn-lg btn-success visible-md visible-lg" href="/sign-up">
	Sign Up
</a>
<div id="home-widget" class="visible-md visible-lg">
	<div class="ui-accordion-horizontal" style="display: none">
		<div class="home-widget-item" style="background-color: #dfdfdf">
			<div class="ui-accordion-handle">
				<h3>Sign Up</h3>
			</div>
			<div class="ui-accordion-content">
				<div class="ui-accordion-content-meat">
					<div>
						<?php 
                        $form = yii\bootstrap\ActiveForm::begin([
                            'id'=>'joinForm',
							'layout'=>'inline',
							'action' => Yii::$app->urlManager->createUrl('/sign-up'),
							'enableClientValidation'=>true,
                            'validateOnSubmit' => true,
							//'afterValidate' => 'js:noDoubleSubmit'                            
                        ]);
                        ?>                                  
						<div class="row">
							<div class="col-md-4">
								<?php
								echo $form->field($joinModel, 'firstName', ['inputOptions' => ['placeholder' => $joinModel->getAttributeLabel('firstName')]]);
								echo $form->field($joinModel, 'lastName', ['inputOptions' => ['placeholder' => $joinModel->getAttributeLabel('lastName')]]);
								
								?>
							</div>
							<div class="col-md-4">
								<?php
								echo $form->field($joinModel, 'email', ['inputOptions' => ['placeholder' => $joinModel->getAttributeLabel('email')]]);
								echo $form->field($joinModel, 'yearOfBirth')->dropDownList($yearOfBirthList, array('prompt' => 'Year of Birth',)); 
								?>
								
							</div>
							<div class="col-md-4">
								<?php
								echo $form->field($joinModel, 'password', ['inputOptions' => ['placeholder' => $joinModel->getAttributeLabel('password')]])->passwordInput(); 
								?>
								<label for="JoinForm_password"></label>
							</div>						
						</div>
						
						<div>
							<div>
								<p>By clicking the signup button below you are agreeing to the <a href="/user-agreement" target="_blank">User Agreement</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.</p>
							</div>
							<div>
								<div>
								<?php
                                echo \yii\helpers\Html::submitButton('<i class="icon fa fa-male"></i> I am Male',
                                        array('name' => 'SignupForm[gender]', 'value'=>'m', 'class'=>'btn btn-lg btn-success pull-left', 'style' => 'width: 47%; position: relative; overflow: visible'));
                                ?>
								<?php 
                                echo \yii\helpers\Html::submitButton('<i class="icon fa fa-female"></i> I am Female',
                                        array('name' => 'SignupForm[gender]', 'value'=>'f', 'class'=>'btn btn-lg btn-success pull-right', 'style' => 'width: 47%; position: relative; overflow: visible'));
                                ?>
								</div>
							</div>							
						</div>
						
						<?php
						//hack to generate the code to disable buttons when submitting.
						$form->attributes = array('','');
						yii\bootstrap\ActiveForm::end();
						unset($form);
						$this->registerJs("$('#joinForm #signupform-password').passStrengthify({element:$('#joinForm label[for=JoinForm_password]'), minimum:8, labels:{tooShort:'Min. 8 characters'}});");
						?>						
					</div>
				</div>
				<div class="ui-accordion-content-preview">
					<i class="fa fa-pencil-square fa-4x"></i>
					<h3 class="h4">Sign Up</h3>
				</div>
			</div>
		</div>
		<div class="home-widget-item"  style="background-color: #82c3c5">
			<div class="ui-accordion-handle">
				<h3>Select A School</h3>
			</div>
			<div class="ui-accordion-content">
				<div class="ui-accordion-content-meat">
					<h2>Real Rewards for Local Schools</h2>
					<p>The main goal of EdIncentive is to give parents and teachers an avenue to raise funds for local schools. After you sign up, select a local school that will benefit each time you complete a survey. It’s that simple!</p>
				</div>
				<div class="ui-accordion-content-preview">
					<i class="fa fa-graduation-cap fa-4x"></i>
					<h3 class="h4">Select A School</h3>
				</div>
			</div>
		</div>
		<div class="home-widget-item" style="background-color: #4294ba">
			<div class="ui-accordion-handle">
				<h3>Take Surveys</h3>
			</div>
			<div class="ui-accordion-content">
				<div class="ui-accordion-content-meat">
					<h2>Spare Change for Spare Time</h2>
					<p>By investing minimal time at your convenience, you can earn money with each survey you complete. Personalize your profile to qualify for surveys that are relevant to you. By providing your valuable opinion, you will earn rewards for your school while helping shape future products.</p>
				</div>
				<div class="ui-accordion-content-preview">
					<i class="fa fa-tasks fa-4x"></i>
					<h3 class="h4">Take Surveys</h3>
				</div>				
			</div>
		</div>		
	</div>
</div>
<div class="clearfix"></div>

<div class="hidden-md hidden-lg">
	<div class="site-index">
        <div class="row">

            <div class="col-md-7">
                <?php
                $slideItems = [];
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
                <img class="img-responsive" style="margin: -15px 0px; position: relative; z-index: 999;" src="/images/signup.png" alt="Sign Up">
                <div class="well" style="position:relative">
                    <?php
                    $form = yii\bootstrap\ActiveForm::begin([
                        'id' => 'signup-form',
                        'action' => Yii::$app->urlManager->createUrl('/sign-up'),
                        'enableClientValidation' => true,
                        'validateOnSubmit' => true
                    ]);
                    echo $form->field($joinModel, 'firstName');
                    echo $form->field($joinModel, 'lastName');
                    echo $form->field($joinModel, 'email');
                    echo $form->field($joinModel, 'password')->passwordInput();
                    echo $form->field($joinModel, 'yearOfBirth')->dropDownList($yearOfBirthList);
                    ?>
                    <div>
                        <p>By clicking the signup button below you are agreeing to the <a href="/user-agreement" target="_blank">User Agreement</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.</p>
                    </div>
                    <div class="row" style="margin: auto">
                        <?php
                        echo yii\helpers\Html::submitButton('<i class="icon fa fa-male"></i> I am Male ', array('name' => 'SignupForm[gender]', 'value' => 'm', 'class' => 'btn btn-lg btn-success pull-left', 'style' => 'width: 47%; position: relative; overflow: visible'));
                        ?>

                        <?php
                        echo yii\helpers\Html::submitButton('<i class="icon fa fa-female"></i> I am Female ', array('name' => 'SignupForm[gender]', 'value' => 'f', 'class' => 'btn btn-lg btn-success pull-right', 'style' => 'width: 47%; position: relative; overflow: visible'));
                        ?>
                    </div>
                    <?php
                        yii\bootstrap\ActiveForm::end();
                    ?>
                </div>			
            </div>

        </div>   
    </div>
</div>
<div class="clearfix"></div>

<?php 
$this->registerJs('
    var activeItem = null;
    var contentWidth = 0;
    var handleWidth = 43;
    var expanded = false;
    var overAllWidth = $("#home-widget").width();
    var itemWidth = (overAllWidth) / $(".ui-accordion-horizontal .home-widget-item").length;

    $(window).bind("load", function(){
        contentWidth =  overAllWidth - (handleWidth * $(".ui-accordion-horizontal .home-widget-item").length)-30;

        //$(".home-widget-item:first-child .ui-accordion-content-meat").css("display", "block");
        //$(".home-widget-item:first-child .ui-accordion-content-preview").css("width", (contentWidth * 0.2)+"px");
        //$(".home-widget-item:first-child .ui-accordion-content-preview").css("float", "right");


        $(".home-widget-item:first-child .ui-accordion-content-meat").css("width", (contentWidth * 0.80)+"px");
        //$(".home-widget-item:first-child .ui-accordion-content-meat").css("overflow", "hidden");

        $(".home-widget-item:first-child .ui-accordion-content-preview").css("float", "right");
        $(".home-widget-item:first-child .ui-accordion-content-preview").css("width", (contentWidth * 0.2)+"px");
        $(".home-widget-item:first-child .ui-accordion-content-preview").css("margin", "0px");

        $(".home-widget-item:first-child").animate({width:(contentWidth+30+handleWidth)+"px"},0);
        $(".home-widget-item:not(:first-child)").animate({width: handleWidth+"px"},0);

        $(".ui-accordion-horizontal").fadeIn(800, function(){



            //$(".home-widget-item").css("overflow", "hidden");
            //$(".home-widget-item .ui-accordion-content").css("margin", "0px");
            //$(".home-widget-item .ui-accordion-content").css("padding", "0px");

            //$(".home-widget-item:first-child .ui-accordion-content-meat").fadeIn(500);
            //$(".home-widget-item:first-child .ui-accordion-content-preview").fadeIn(500);

            $(".home-widget-item:first-child .ui-accordion-content-meat").fadeIn("fast").delay(1500).fadeOut(2000, function(){
                $(".home-widget-item:first-child .ui-accordion-content-preview").css("float", "");
                $(".home-widget-item:first-child .ui-accordion-content-preview").css("width", "");
                $(".home-widget-item").each(function(index){
                    var self = $(this);

                    setTimeout(function(){
                        self.animate({width: itemWidth+"px"},{duration: 300, queue: false});
                    }, index*150);

                });
                //$(".home-widget-item").css("width", "");
            });
        });	
    });
    
    $(".home-widget-item .ui-accordion-handle, .home-widget-item .ui-accordion-content-preview").click(function(){
        expanded = true;	
        if(activeItem)
        {
            if($(activeItem).is(":first-child"))
            {
                $(activeItem).animate({width: (handleWidth+30)+"px"},{duration:300, queue:false, start:function(){$(activeItem).find(".ui-accordion-content").hide();}});
            }
            else
            {
                $(activeItem).animate({width: handleWidth+"px"},{duration:300, queue:false, start:function(){$(activeItem).find(".ui-accordion-content").hide();}});
            }

            //$(activeItem).find(".ui-accordion-content").animate({width: "0px"}, {duration:300, queue:false});
        }
        else
        {
            $(".home-widget-item .ui-accordion-content").css("width", contentWidth+"px");
            $(".home-widget-item .ui-accordion-content-meat").css("width", (contentWidth * 0.8)+"px");
            $(".home-widget-item .ui-accordion-content-meat").css("display", "block");
            $(".home-widget-item .ui-accordion-content-preview").css("width", (contentWidth * 0.2)+"px");
            $(".home-widget-item .ui-accordion-content-preview").css("float", "right");
            //$(".home-widget-item:first-child").css("padding-left", "30px");
            $(".home-widget-item .ui-accordion-content").hide();
            $(".home-widget-item").each(function(){
                if($(this).is(":first-child"))
                {
                    $(this).animate({width: (handleWidth+30)+"px"}, {duration:300, queue:false, done: function(){
                        $(this).css("margin", "0px");
                        $(this).css("padding", "0px");
                    }});
                }
                else
                {
                    $(this).find(".ui-accordion-content").css("margin","10px 0px");
                    $(this).animate({width: handleWidth+"px"}, {duration:300, queue:false, done: function(){
                        $(this).css("margin", "0px");
                        $(this).css("padding", "0px");
                    }});
                }
            });

        }
        activeItem = $(this).closest(".home-widget-item");
        var totalWidth = contentWidth + handleWidth;
        if($(activeItem).is(":first-child"))
        {
            totalWidth += 30;
        }

        $(activeItem).animate({width: totalWidth+"px"},{duration:300, queue:false, complete:function(){$(activeItem).find(".ui-accordion-content").fadeIn(200);}});
        //$(activeItem).children(".ui-accordion-content").animate({width: contentWidth+"px"}, {duration:300, queue:false});

    });
    
    $("#signup-form").on("afterValidate", function(event, messages){
        if($(event.target).find(".has-error").length == 0){
            var ajaxLoading = new ajaxLoader($(event.target).closest("form").parent());
        }
    });
    
    $("#joinForm").on("afterValidate", function(event, messages){
        if($(event.target).find(".has-error").length == 0){
            var ajaxLoading = new ajaxLoader($(event.target).closest("form").parent().parent().parent().parent());
        }
    });
	'		
	);
?>