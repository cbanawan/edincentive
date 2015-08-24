<?php
$this->title = "Support";
$this->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
//$this->registerMetaTag(['name' => 'keywords', 'content' => "school rewards, school incentives, earn money for schoolsr"], 'keywords');
//$this->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an easy way for you to earn extra money for your school."], 'description');

use yii\bootstrap\Tabs;
use frontend\models\ContactForm;

\Yii::$app->view->beginBlock('faqContents');
?>
<H1>Frequently Asked Questions</h1>
<div id="faq-content" class="panel-group collapse in" style="height: auto;">
	<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#faq-content-collapse1" data-toggle="collapse" data-parent="#faq-content"><i class="fa fa-caret-down"></i> Registration Questions</a>
			</h4></div>
		<div id="faq-content-collapse1" class="in panel-collapse collapse"><div class="panel-body"><div id="w0" class="panel-group collapse in" style="height: auto;">
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse1" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-down"></i> How do I join?</a>
							</h4></div>
						<div id="w0-collapse1" class="in panel-collapse collapse"><div class="panel-body">To join <?= \Yii::$app->name ?>, there is a simple registration process. <br><br>After you sign-up we will send an email to verify the email address. <br><br>Confirm your email by clicking on the link in the email. Once you confirm you membership will begin and you will be part of <?= \Yii::$app->name ?> panel. <br><br><b>Please note:</b><br>Spam filters may keep our emails from getting to your inbox. You may need to check your 'Bulk' or 'Junk' email folders and indicate emails from <?= \Yii::$app->name ?> are not junk or bulk mail. <br><br>Please <a href="/sign-up"><font color="blue">click here</font></a> to join.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse2" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> I am having trouble registering</a>
							</h4></div>
                        <div id="w0-collapse2" class="panel-collapse collapse"><div class="panel-body">If you have having trouble registering, please <a href="/contact" target="_blank"><font color="blue">email customer support</font></a> with the following information and we will create an account for you.<br><br>First Name<br>Last Name<br>Email Address<br>Desired Password<br>Gender<br>Year of Birth<br>Zip/Postal Code<br><br>Please include the error you received which will be helpful in making sure our sign up process is working properly.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse3" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> I did not receive my confirmation email.</a>
							</h4></div>
						<div id="w0-collapse3" class="panel-collapse collapse"><div class="panel-body"><b>First,</b><br>Check your Spam / Junk folder. See if the email was filtered out of your inbox. <br><br><b>Second</b>,<br>If it is not there, you can log into your account and click on the notification at the top of the screen to have the email sent again.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse4" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> Do I have to pay anything to join?</a>
							</h4></div>
						<div id="w0-collapse4" class="panel-collapse collapse"><div class="panel-body"><?= \Yii::$app->name ?> membership is free. We will never ask you for money, or try to sell you anything. We simply ask you to share your opinions by answering survey questions. As a way of saying ''Thank You'', we offer you rewards for each survey you complete and those rewards can be donated to a local school of your choice.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse5" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> Will I get paid for this?</a>
							</h4></div>
						<div id="w0-collapse5" class="panel-collapse collapse"><div class="panel-body">You will always earn rewards for each survey you complete. Once you have reached the minimum reward level, you can redeem and have your rewards donated to a local school of your choice. Each survey invitation will have details about how much the survey is worth and how long the survey will take.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse6" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> Who is eligible to join <?= \Yii::$app->name ?>?</a>
							</h4></div>
						<div id="w0-collapse6" class="panel-collapse collapse"><div class="panel-body">Panel members must be at least 18 years of age and reside in the United States to join and participate in surveys on <?= \Yii::$app->name ?>. Remember there are only 2 accounts per household allowed. Please review our <a href="/user-agreement"> <font color="blue">user agreement</font></a> for more information.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse7" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> Why do you ask me information about myself such as age, race, or income?</a>
							</h4></div>
						<div id="w0-collapse7" class="panel-collapse collapse"><div class="panel-body">We use the information you provide on the registration form and in your profile forms to assess demographics, interests, and other factors to invite you to the surveys best matched for you. Rest assured, any personal information you provide will remain confidential and used purely for research purposes. We support the rights of our members by limiting the use of its information for legitimate marketing research purposes only. We agree with the following organizations created to uphold ethical survey research: (MRA, AMA, AAPOR, CASRO, and ARF). Please review our <a href="/privacy-policy"><font color="blue">privacy policy</font></a> to find out more about how the privacy of your information is protected.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w0-collapse8" data-toggle="collapse" data-parent="#w0"><i class="fa fa-caret-right"></i> Good password rules to follow</a>
							</h4></div>
						<div id="w0-collapse8" class="panel-collapse collapse"><div class="panel-body"><ul>    <li>Don’t reuse passwords for the email address that you use with this site  </li>  <li>Avoid using single dictionary words as your full password    <ul>    <li>"<font color="blue">password</font>", "<font color="blue">football</font>", "<font color="blue">sunshine</font>"</li>    </ul>  </li>  <li>Avoid simple common phrases or strings of characters as your full password    <ul>    <li>"<font color="blue">letmein</font>", "<font color="blue">iloveyou</font>", "<font color="blue">abcd1234</font>"</li>    </ul>  </li>  <li>Avoid only using common patterns that many people use as your only level of security    <ul>    <li>"<font color="blue">Superman1</font>", "<font color="blue">trustno1</font>", "<font color="blue">P@ssword1</font>"</li>    </ul>  </li>  <li>Suggestion: Include multiple unrelated words as a base for your strong, long password    <ul>    <li>Simple long passwords are better than short complex passwords</li>    <li>Use words that will be simple for you to remember</li>    <li>"<font color="blue">battery staple</font>"</li>    </ul>  </li>  <li>Suggestion: Include a memorable but complex phrase to embed into all of your passwords    <ul>    <li>This makes your passwords much harder to guess but still memorable</li>    <li>Use a mix of character types (including spaces) "<font color="blue">~, !, @, #, $, %, &amp;, ?</font>"</li>    <li>In this example we changed the word “safe” to “<font color="blue">$aF3</font>”</li>    <li>"<font color="red">battery staple</font> <font color="blue">$aF3</font>"</li>    </ul>  </li>  <li>Suggestion: Include a unique code for each website    <ul>    <li>Base the code on something you can easily remember</li>    <li>If a thief figures out your password for one site they could get into all of your accounts</li>    <li>In this example, we took the first 3 letters of the website "<font color="blue">igl</font>" and increased the first 2 letters by 1 letter and lowered the last by 1 letter "<font color="blue">jhk</font>" </li>    <li>"<font color="red">battery staple $aF3</font> <font color="blue">jhk</font>"</li>    </ul>  </li>  <li>A password like this would be difficult for any computer to break, easier for you to remember, and would keep your other accounts more secure.</li>    <ul>    <li>"<font color="red">batterystaple$aF3jhk</font>"    </li></ul>  </ul></div>
						</div></div>
				</div>
			</div>
		</div></div>
	<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#faq-content-collapse2" data-toggle="collapse" data-parent="#faq-content"><i class="fa fa-caret-right"></i> Survey Experience / How it Works</a>
			</h4></div>
		<div id="faq-content-collapse2" class="panel-collapse collapse"><div class="panel-body"><div id="w1" class="panel-group collapse in" style="height: auto;">
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w1-collapse1" data-toggle="collapse" data-parent="#w1"><i class="fa fa-caret-right"></i> How do I ensure that I receive emails?</a>
							</h4></div>
						<div id="w1-collapse1" class="panel-collapse collapse"><div class="panel-body">The best method to ensure <?= \Yii::$app->name ?> emails reach your inbox is to add our email address to your address book ''admin@cintindex.com''. We work through this company for our email delivery. Many email providers allow you to do this easily with an 'Add to address book' option, 'mark email as safe', or 'This is not spam' options. You may also add ''@cintindex.com'' to your safe list.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w1-collapse2" data-toggle="collapse" data-parent="#w1"><i class="fa fa-caret-right"></i> How will I be notified of survey opportunities?</a>
							</h4></div>
						<div id="w1-collapse2" class="panel-collapse collapse"><div class="panel-body">We send survey invitations to your email, so please add ''admin@cintindex.com'' to your email safe list. We work through this company for our email delivery.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w1-collapse3" data-toggle="collapse" data-parent="#w1"><i class="fa fa-caret-right"></i> How quickly after joining should I expect to start receiving email invitations?</a>
							</h4></div>
						<div id="w1-collapse3" class="panel-collapse collapse"><div class="panel-body">There is not an exact time to when you will receive your first survey invitation. To maximize the amount of surveys you are invited to take, make sure all of your profiles are filled out and kept updated.<br><br>To update your profile just log into your account and <a href="/dashboard/profile"><font color="blue">click</font></a> on profiles.</div>
						</div></div>
				</div>
			</div>
		</div></div>
	<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#faq-content-collapse3" data-toggle="collapse" data-parent="#faq-content"><i class="fa fa-caret-right"></i> Rewards</a>
			</h4></div>
		<div id="faq-content-collapse3" class="panel-collapse collapse"><div class="panel-body"><div id="w2" class="panel-group collapse in" style="height: auto;">
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w2-collapse1" data-toggle="collapse" data-parent="#w2"><i class="fa fa-caret-right"></i> How do I redeem my money?</a>
							</h4></div>
						<div id="w2-collapse1" class="panel-collapse collapse"><div class="panel-body"><?= \Yii::$app->name ?> uses your email address to make payments through <a href="http://www.paypal.com"><font color="blue">PayPal</font></a>, so make sure your email address is tied to a PayPal account. If this is not the correct email address, you can change it in My Account or add the email address to your PayPal account as a secondary email. If you don't have a PayPal account, you can sign up here. Please allow 1-4 hours for processing.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w2-collapse2" data-toggle="collapse" data-parent="#w2"><i class="fa fa-caret-right"></i> Does my money expire?</a>
							</h4></div>
						<div id="w2-collapse2" class="panel-collapse collapse"><div class="panel-body">As long as you are an active member of <?= \Yii::$app->name ?>, your money will not expire The only situations that may result in a revocation of money are actions that violate the panel member <a href="/user-agreement"><font color="blue">User Agreement</font></a> (more than 2 accounts per household, consistently providing false data, etc.).</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w2-collapse3" data-toggle="collapse" data-parent="#w2"><i class="fa fa-caret-right"></i> What happens to my money if I deactivate my account?</a>
							</h4></div>
						<div id="w2-collapse3" class="panel-collapse collapse"><div class="panel-body">If you decide to unsubscribe or discontinue your membership at <?= \Yii::$app->name ?>, then you forfeit all unredeemed points.</div>
						</div></div>
				</div>
			</div>
		</div></div>
	<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#faq-content-collapse4" data-toggle="collapse" data-parent="#faq-content"><i class="fa fa-caret-right"></i> Problems with a Survey</a>
			</h4></div>
		<div id="faq-content-collapse4" class="panel-collapse collapse"><div class="panel-body"><div id="w3" class="panel-group collapse in" style="height: auto;">
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w3-collapse1" data-toggle="collapse" data-parent="#w3"><i class="fa fa-caret-right"></i> What if I don't want to take a particular survey?</a>
							</h4></div>
						<div id="w3-collapse1" class="panel-collapse collapse"><div class="panel-body">You have the choice to participate, or not participate in any of the surveys sent to you. If you do not wish to participate simply ignore the survey invitation. This will have no negative effect on your account.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w3-collapse2" data-toggle="collapse" data-parent="#w3"><i class="fa fa-caret-right"></i> I answer a few questions and then it says I do not qualify for the survey. Why is that?</a>
							</h4></div>
						<div id="w3-collapse2" class="panel-collapse collapse"><div class="panel-body">The few questions at the beginning of the survey are called qualification questions. These questions help us determine the most relevant audience for that specific survey. The screening questions usually only take a few minutes, so you should know quickly if you are qualified for a particular survey.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w3-collapse3" data-toggle="collapse" data-parent="#w3"><i class="fa fa-caret-right"></i> I answered several questions in a survey, before an error occurred. Can I re-access the survey?</a>
							</h4></div>
						<div id="w3-collapse3" class="panel-collapse collapse"><div class="panel-body">Some of our surveys are available to be accessed multiple times until completed, terminated, or the survey has closed. However, not all surveys can be accessed more than once. If an error occurred while you were taking the survey, please email customer support and they will look into the survey.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w3-collapse4" data-toggle="collapse" data-parent="#w3"><i class="fa fa-caret-right"></i> I have not received surveys in a few days. Is there something wrong with my account?</a>
							</h4></div>
						<div id="w3-collapse4" class="panel-collapse collapse"><div class="panel-body">Can you log into your <?= \Yii::$app->name ?> account? If so, there is most likely nothing wrong with your account, but feel free to email our customer support team and they will look at your account.</div>
						</div></div>
				</div>
			</div>
		</div></div>
	<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#faq-content-collapse5" data-toggle="collapse" data-parent="#faq-content"><i class="fa fa-caret-right"></i> Privacy Protection</a>
			</h4></div>
		<div id="faq-content-collapse5" class="panel-collapse collapse"><div class="panel-body"><div id="w4" class="panel-group collapse in" style="height: auto;">
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w4-collapse1" data-toggle="collapse" data-parent="#w4"><i class="fa fa-caret-right"></i> How do you protect my survey and account information?</a>
							</h4></div>
						<div id="w4-collapse1" class="panel-collapse collapse"><div class="panel-body">We strive to ensure the proper safeguards are in place to protect the integrity and confidentiality of the account and online survey information collected. We use Secure Socket Layer (SSL) encryption to protect the transmission of personal information submitted to us through secure online survey forms. All the information you provide us through these forms is stored in a secure data center. In addition we use firewall and password protection systems. For additional information please review our <a href="/privacy-policy"><font color="blue">privacy policy</font></a>.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w4-collapse2" data-toggle="collapse" data-parent="#w4"><i class="fa fa-caret-right"></i> What is your privacy policy?</a>
							</h4></div>
						<div id="w4-collapse2" class="panel-collapse collapse"><div class="panel-body">Our Privacy Policy explains who we are, how we use your account and online survey information, and under what circumstances, if any, we supply your information to other third parties. Please <a href="/privacy-policy"><font color="blue">click here</font></a>. to review our Privacy Policy.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w4-collapse3" data-toggle="collapse" data-parent="#w4"><i class="fa fa-caret-right"></i> What will you do with the information I provide?</a>
							</h4></div>
						<div id="w4-collapse3" class="panel-collapse collapse"><div class="panel-body">The information you fill out gives organizations a general picture of what types of people fill out their online surveys: how many men versus women, average level of education, etc. We use your email address to send you invitations to participate in new surveys and to contact you with messages about EdIncentive news & updates. We may use your postal address to mail any paid online survey-related incentives or product samples.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w4-collapse4" data-toggle="collapse" data-parent="#w4"><i class="fa fa-caret-right"></i> What do you do with the online survey research data?</a>
							</h4></div>
						<div id="w4-collapse4" class="panel-collapse collapse"><div class="panel-body">When you fill out a survey, we use your responses along with other participants' responses to inform clients about people's attitudes towards their products or services. <strong>Your personal information will not be linked with your responses.</strong> Collected data is used in aggregate by leading survey research consultancies throughout North America and the world to improve consumer products and services worldwide. Basic demographic information such as gender, race, age, and income is often shared in aggregate to help researchers understand how different segments of the population answer their questions. By way of example, the collected online survey data can be used to measure customer satisfaction, awareness of various advertisements, new concept testing or public opinion on a variety of political issues. Please see our <a href="/privacy-policy"><font color="blue">privacy policy</font></a> for more information.</div>
						</div></div>
				</div>
			</div>
		</div></div>
	<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#faq-content-collapse7" data-toggle="collapse" data-parent="#faq-content"><i class="fa fa-caret-right"></i> Member Account Questions</a>
			</h4></div>
		<div id="faq-content-collapse7" class="panel-collapse collapse"><div class="panel-body"><div id="w6" class="panel-group collapse in" style="height: auto;">
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w6-collapse1" data-toggle="collapse" data-parent="#w6"><i class="fa fa-caret-right"></i> How do I change/update my personal information such as email address?</a>
							</h4></div>
						<div id="w6-collapse1" class="panel-collapse collapse"><div class="panel-body">Account information can be changed when you log into your account and clicking the <a href="/dashboard/my-account"><font color="blue">My Account</font></a> on the left side menu. Keeping your information up to date will help you will receive more surveys targeted for you.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w6-collapse2" data-toggle="collapse" data-parent="#w6"><i class="fa fa-caret-right"></i> I forgot my password.</a>
							</h4></div>
						<div id="w6-collapse2" class="panel-collapse collapse"><div class="panel-body">If you have forgot your password, simply click the <a href="/request-password-reset"><font color="blue">'Password Reset'</font></a> link, fill in the email you registered with, and you will receive an email where you will be able to reset your password.</div>
						</div></div>					
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w6-collapse4" data-toggle="collapse" data-parent="#w6"><i class="fa fa-caret-right"></i> What if I no longer wish to be a member of <?= \Yii::$app->name ?>?</a>
							</h4></div>
						<div id="w6-collapse4" class="panel-collapse collapse"><div class="panel-body"> If you wish to no longer be a member of EdIncentive, simply sign into your account and go to <a href="/dashboard/my-account" target="_blank">'My Account'</a> . Then click on the button that says 'Unsubscribe'. If you decide to unsubscribe or discontinue your membership at Education Incentive, then you forfeit all unredeemed points. So, make sure you have redeemed your rewards before canceling your account.</div>
						</div></div>
					<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="collapse-toggle" href="#w6-collapse5" data-toggle="collapse" data-parent="#w6"><i class="fa fa-caret-right"></i> My account has been deactivated. How do I get my survey account reactivated?</a>
							</h4></div>
						<div id="w6-collapse5" class="panel-collapse collapse"><div class="panel-body">Our system is constantly monitoring all data that is stored for each panelist. If we detect suspicious activity or more than two accounts in your household, your account will be temporarily deactivated. Just like all systems, ours is not perfect. If you feel your account was wrongly flagged, please contact us that is found at the top of the support page, and we will look into the issue. In most cases, accounts are reactivated. All survey history and points will still be there when your account is active again. Do not attempt to create another account without talking to customer service first or your new account will be immediately flagged against your old account and deactivated.</div>
						</div></div>
				</div>
			</div>
		</div></div>
</div>

<?php
\Yii::$app->view->endBlock();

if (!isset($contactForm))
{
	$contactForm = new ContactForm();
}

$contactPage = $this->render('@frontend/views/site/contact.php', array('model' => $contactForm));

echo Tabs::widget([
	'items' => [
		[
			'label' => 'FAQ',
			'content' => \Yii::$app->view->blocks['faqContents'],
			'active' => ($_POST['ContactForm'] || (isset($tabOptions) && $tabOptions['active'] == 1)) ? false : true,
			'options' => ['id' => 'faq']
		],
		[
			'label' => 'Contact Us',
			'content' => $contactPage,
			'active' => ($_POST['ContactForm'] || (isset($tabOptions) && $tabOptions['active'] == 1)) ? true : false,
			'options' => ['id' => 'contact']
		]
	]
]);

$this->registerJs('    
		$(".panel-group .panel-collapse").on("shown.bs.collapse", function (e) {
		   $(e.target).siblings(".panel-heading").find(".fa-caret-right").first().removeClass("fa-caret-right").addClass("fa-caret-down");
		});

		$(".panel-group .panel-collapse").on("hidden.bs.collapse", function (e) {
		   $(e.target).siblings(".panel-heading").find(".fa-caret-down").first().removeClass("fa-caret-down").addClass("fa-caret-right");
		});
	');
