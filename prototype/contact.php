	<?php include 'header.php'; ?>
	<div class = "wrapmeup">
	<?php
	include 'leftsidebar.php'; 
	include 'rightsidebar.php'; 
	require_once("./include/fgcontactform.php");

	$formproc = new FGContactForm();


	//1. Add your email address here.
	//You can add more than one receipients.
	$formproc->AddRecipient('hi@hi.com'); //<<---Put your email address here


	//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
	// and put it here
	$formproc->SetFormRandomKey('CnRrspl1FyEylUj');


	if(isset($_POST['submitted']))
	{	
	if($formproc->ProcessForm())
	{
			echo "<div title='Notification!' id='notification'>Thanks for contacting us yo!!</div>"; 
	}
	}
	?>
	
	<div class ="bodyBlock">
		<p>Hey we're always happy to hear from our users, leave us a message and we'll get back to you ASAP!!!!!!</p>
		
		<!-- Form Code Start -->
		<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
		<fieldset >
		<legend>Contact Us</legend>
		
		<input type='hidden' name='submitted' id='submitted' value='1'/>
		<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
		<input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />
		
		<div class='short_explanation'>* required fields</div>
		
		<div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>
		<div class='container'>
			<label for='name' >Your Full Name*: </label><br/>
			<input type='text' name='name' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="50" /><br/>
			<span id='contactus_name_errorloc' class='error'></span>
		</div>
		<div class='container'>
			<label for='email' >Email Address*:</label><br/>
			<input type='text' name='email' id='email' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" /><br/>
			<span id='contactus_email_errorloc' class='error'></span>
		</div>
		
		<div class='container'>
			<label for='message' >Message:</label><br/>
			<span id='contactus_message_errorloc' class='error'></span>
			<textarea rows="10" cols="50" name='message' id='message'><?php echo $formproc->SafeDisplay('message') ?></textarea>
		</div>
		
		
		<div class='container'>
			<input type='submit' name='Submit' value='Submit' />
		</div>
		
		</fieldset>
		</form>
		<!-- client-side Form Validations:
		Uses the excellent form validation script from JavaScript-coder.com-->
		
		<script type='text/javascript'>
		// <![CDATA[
		
			var frmvalidator  = new Validator("contactus");
			frmvalidator.EnableOnPageErrorDisplay();
			frmvalidator.EnableMsgsTogether();
			frmvalidator.addValidation("name","req","Please provide your name");
		
			frmvalidator.addValidation("email","req","Please provide your email address");
		
			frmvalidator.addValidation("email","email","Please provide a valid email address");
		
			frmvalidator.addValidation("message","maxlen=2048","The message is too long!(more than 2KB!)");
		
		// ]]>
		</script>
	</div>
	</div>
	<?php include 'footer.php'; ?>
