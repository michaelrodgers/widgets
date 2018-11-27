<?php include 'includes/config.php'?>
<?php get_header()?>
<?php
if(isset($_POST['Name']))
{//data is submitted show it
    //echo $_POST['Name'];
    $to      = 'michael.rodgers312@gmail.com';
    $subject = 'Clean Contact Page';
    //$message = 'hello from ' . $_POST['Name'];
    $message = process_post();
    $replyTo = 'michael.rodgers312@gmail.com';
    $headers = 'From: noreply@michaelrodgers.azurewebsites.net' . PHP_EOL .
    'Reply-To: ' . $replyTo . PHP_EOL .
    'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
    echo '<p>Thanks for contacting us</p>
        <p><a href="">BACK</a></p>';
}else{//show a form
    echo '
    <form action="" method="post" name="sentMessage" id="contactForm" novalidate>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="Name" id="name" required data-validation-required-message="Please enter your name.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Email Address</label>
                <input type="email" class="form-control" placeholder="Email Address" name="Email" id="email" required data-validation-required-message="Please enter your email address.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Message</label>
                <textarea rows="5" class="form-control" placeholder="Message" name="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
            </div>
          </form>
    ';
}
?>

<br>
<h1>Alternative Contact Form</h1>
<?php

$toAddress = "michael.rodgers312@gmail.com";  
$toName = "Michael Rodgers"; 
$website = "Clean Contact Page";  

$sendEmail = TRUE; 
$dateFeedback = true; 
include_once 'sitekeys.php'; 
include 'contact-lib/contact_include.php'; 
$response = null;
$reCaptcha = new ReCaptcha($secretKey);
if (isset($_POST["g-recaptcha-response"]))
{
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}
if ($response != null && $response->success)
    {
        handle_POST($skipFields,$sendEmail,$toName,$fromAddress,$toAddress,$website,$fromDomain);
    ?>
    
    <div class="contact-feedback">
        <h2>Your Comments Have Been Received!</h2>
        <p>Thanks for the input!</p>
        <p>We'll respond via email within 48 hours, if you requested information.</p>
    </div>    
            
    <?php
}else{
    if($response != null && !$response->success)
    {
        $feedback = dateFeedback($dateFeedback);
        send_POSTtoJS($skipFields); 
    }
 
?>
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
	<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name" name="Name" id="name" required data-validation-required-message="Please enter your name.">
                <p class="help-block text-danger"></p>
              </div>
    </div>
    <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Email Address</label>
                <input type="email" class="form-control" placeholder="Email Address" name="Email" id="email" required data-validation-required-message="Please enter your email address.">
                <p class="help-block text-danger"></p>
              </div>
    </div>
	<div>	
		<label>
			How Did You Hear About Us?:<br />
			<select name="How_Did_You_Hear_About_Us?" required="required" title="How You Heard is required" tabindex="30">
				<option value="">Choose How You Heard</option>
				<option value="Phone">Phone</option>
				<option value="Web">Web</option>
				<option value="Magazine">Magazine</option>
				<option value="A Friend">A Friend</option>
				<option value="Other">Other</option>
			</select>
		</label>
	</div>
	
	<div>	
		<fieldset>
			<legend>What Services Are You Interested In?</legend>
			<input type="checkbox" name="Interested_In[]" value="Application Development" tabindex="40" /> Application Development <br />
			<input type="checkbox" name="Interested_In[]" value="Testing/Troubleshooting" /> Testing/Troubleshooting <br />
			<input type="checkbox" name="Interested_In[]" value="Special Features" /> Special Features <br />
			<input type="checkbox" name="Interested_In[]" value="Other" /> Other <br />
		</fieldset>
	</div>
	
		<div>	
		<fieldset>
			<legend>Would you like to join our mailing list?</legend>
			<input type="radio" name="Join_Mailing_List?" value="Yes" 
			required="required" title="Mailing list is required" tabindex="50"  
			/> Yes <br />
			<input type="radio" name="Join_Mailing_List?" value="No" /> No <br />
		</fieldset>
	</div>
	<div>	
		<label>
			Comments:<br /><textarea name="Comments" cols="36" rows="4" placeholder="Your comments are important to us!" tabindex="60"></textarea>
		</label>
	</div>	
	<div><?=$feedback?></div>
    <div class="g-recaptcha" data-sitekey="<?=$siteKey;?>"></div>
    <br>
	<div class="form-group">
              <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
    </div>
    </form>
	<!-- END HTML FORM -->
    <script type="text/javascript"
        src="https://www.google.com/recaptcha/api.js?hl=en">
    </script>
<?php
}
?>
<p class="clear-recaptcha"></p>

<?php get_footer();
    
function process_post()
{//loop through POST vars and return a single string
    $myReturn = ''; //set to initial empty value

    foreach($_POST as $varName=> $value)
    {#loop POST vars to create JS array on the current page - include email
         $strippedVarName = str_replace("_"," ",$varName);#remove underscores
        if(is_array($_POST[$varName]))
         {#checkboxes are arrays, and we need to collapse the array to comma separated string!
             $myReturn .= $strippedVarName . ": " . implode(",",$_POST[$varName]) . PHP_EOL;
         }else{//not an array, create line
             $myReturn .= $strippedVarName . ": " . $value . PHP_EOL;
         }
    }
    return $myReturn;
}
?>