<?php
$this->title = "School Rewards";
$this->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
$this->registerMetaTag(['name' => 'keywords', 'content' => "school rewards, school incentives, earn money for schoolsr"], 'keywords');
$this->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an easy way for you to earn extra money for your school."], 'description');
?>
<h1>EdIncentive School Rewards Program</h1>
<img src="/images/school-rewards.png" class="img-resposive pull-right" style="width: 30%"/>
<p>EdIncentive School Rewards is a year-round fundraising machine that requires 
    almost no effort by PTA volunteers or school staff. It's virtually automatic.</p>
<ul>
    <li>No products to stock or display</li>
    <li>No volunteers to manage</li>
    <li>No committee chair</li>
    <li>No delivery day</li>
    <li>No accounting</li>
    <li>No school calendar scheduling</li>
</ul>

<form id="school-select" action="/school-dashboard" method="GET">
    <input type="hidden" name="schoolId" class="school-id" value="" />

    <p>
        <span class="btn btn-danger btn-sm search-school-btn" data-toggle="modal" data-target=".school-widget-dialog">View Your School's Earnings</span>
    </p>
</form>
<div id="school-widget"></div>

<p>Here's how our unique school fundraising program works: parents or educators 
    sign up at edincentive.com to participate in consumer research studies and market 
    surveys. Every time a participate completes a survey, the participant is rewarded 
    for their time and insights on that particular survey. The participant is given 
    the ability to direct their rewards to the school of their choice.</p>

<p>Want more detail? Like to sign up YOUR school? Kindly complete the short registration 
    form and after you have activated your account, select a school you want to 
    receive your rewards. If you have questions, please feel free to contact us 
    or send us an email at rewards@edincentive.com.</p>

<h2>School Rewards FAQ</h2>
<ol>
    <li>
        <h4>What is EdIncentive School Rewards and how does it work?</h4>
        <p>School Rewards is our way and the way our members help give back to the 
           community. It’s really simple! You sign up to provide your spare time 
           and opinions and we give you an opportunity to send your rewards right 
           back to the community. No middle man, no red tape, no forms to fill out, 
           your spare time can earn spare change for local schools.</p>
    </li>
    <li>
        <h4>Can my school proactively get involved in EdInentive School Rewards?</h4>
        <p>Yes! The best way to be proactive and earn rewards for local schools 
           is to invite others to sign up and select your school to give back to. 
           The only way that we know what school to give back to is for you to sign 
           up and select a school. Once you have selected a school and complete 
           a survey you are helping raise funds for that school. It’s that easy. 
           Just sit back, relax and tell people to sign up for the School Rewards Program.</p>
    </li>
    <li>
        <h4>How do I participate in EdIncentive School Rewards?</h4>
        <p>Go to <a href="https://www.edincentive.com"><font color="blue">https://www.edincentive.com</font></a> 
           and complete the short registration form. After joining, select a local 
           school and make sure you complete your profile. The more complete your 
           profile the more likely you will qualify for reward opportunities. It’s 
           that simple and straightforward.</p>
    </li>
    <li>
        <h4>My School is not on the list, what do I do?</h4>
        <p>If your school isn’t on the list when you conduct your select a school 
            search, feel free to <a href="/contact"><font color="blue">contact us</font></a> with the following information:</p>
        <p><strong>Subject</strong>: Add New School</p>
        <ul>
            <li>School Name</li>
            <li>Address</li>
            <li>City</li>
            <li>Zip</li>
            <li>Phone</li>
            <li>Website (if applicable)</li>
        </ul>
        <p>After submitting the info for your school of choice, an EdIncentive team 
           member will verify the information and it will be added to your account 
           as your school of choice.</p>
    </li>
    <li>
        <h4>How do I see how much Rewards my school has earned?</h4>
        <p>Each school can have a School Dashboard page to show the aggregated results 
           of the your effort. After you have created and activated your EdIncentive 
           account, go to the "My Account" section and view or edit your school 
           assignment. In that area, it will show you how much you have sent to your 
           school of choice. You can also click on the school’s name to access the 
           dashboard page for that school. If a dashboard has not yet been set up, 
           you will be prompted to request a new dashboard for your school.</p>
    </li>
    <li>
        <h4>What percentage of my rewards is donated to the School?</h4>
        <p>The default amount is that 100% of your rewards will be donated to the 
           school you have selected. Members have the option to change the percentage, 
           but our recommendation is leave the default and send 100% of your rewards 
           to your local school.</p>
    </li>
    <li>
        <h4>Am I personally paying for the School Rewards?</h4>
        <p>You don’t pay a cent. The funds being raised for the school are a direct 
           result of your spare time and opinions you are providing on surveys you 
           complete.</p>
    </li>
    <li>
        <h4>When and how does the school get the rewards?</h4>
        <p>At the end of every quarter we get out the checkbook and write checks 
           for the schools. And no joke, we love doing it. We send a business check, 
           made out to the school, straight to the school or PTA for them to use 
           for their needs.</p>
    </li>
    <li>
        <h4>Can I sign up with more than one school?</h4>
        <p>No, because each email address is its own unique account. You cannot 
           split the way the School Rewards gives back. Do do have the option to 
           change your school of choice, but you can only direct funds to one school 
           at a time.</p>
    </li>
</ol>
<?php
$this->registerJsFile('/js/react.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('/js/schoolWidget.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJs('React.render(React.createElement(SchoolSearchWidget, {
    inputId: "school-widget",
    schoolIdInput: ".school-id",
    schoolNameInput: ".school-name",
    schoolSearchUrl: "/ajax-school-search",
    handleSubmit: function(e){e.preventDefault(); $("#school-select").submit();},
    btnText: "Go To School Dashboard"}),
    document.getElementById("school-widget"));');