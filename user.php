<?php 
require("dbconnect.php"); 
require("helper_functions.php");
session_start(); header('Content-Type: text/html; charset=utf-8'); 
//A custom session timeout implementation
if(isset($_SESSION["lastActivity"]) && time()-$_SESSION["lastActivity"]>1800)
{
	unset($_SESSION['user']);
	unset($_SESSION['lastActivity']);
	setcookie(session_name(), '', time() - 72000);
	session_destroy();
}
else 
{
	$_SESSION["lastActivity"]=time();
}

// echo 'The $_SESSION: <br />';
// print_r($_SESSION);
?>

<div id="user">				
	<script src="user_helper.js"></script>
		
	<div id="info">
	  <div class="error">
	  <?php if(isset($_SESSION["error"]) && $_SESSION["error"]!=""){ echo "<p>"+$_SESSION["error"]+"</p>";}?>
	  	
	  </div>
	  
	  <div id="account">
	    <div class="left_c" id="account_setting"></div>
	    <div style="clear:both;" id="account_setting_toggle"></div>
	  </div>
	</div>
	
	<div id="login_container">
	  <a href="#">I want to log in!</a>
	  <form action="login.php" method="post" id="login">
	    <label>User Name:</label><input type="text" name="username" />
	    <label>Password:</label><input type="password" name="password"/>
	    <input id="button_login" type="submit" value="Log in!"/>
	  </form>
	</div>
	
	<div id="register_container">
	  <a href="#">I want to register!</a>
	  <form enctype="multipart/form-data" action="register.php" method="post" id="register">
	    <div class="left_c">
	    	<label>User Name*:</label><input type="text" name="username" /><br />
	    	<label>Email*:</label><input type="email" name="email"/><br />
	    	<label>Password*:</label><input type="password" name="password"/><br />
	    	<label>Password again*:</label><input type="password" name="password_again"/><br />
		    <label>Gender:</label>
		    <select name="gender" style="float:right">
		      <option selected value="unspecified">unspecified</option>
		      <option value="male">male</option>
		      <option value="female">female</option>
		    </select>
		</div>
		<div class="right_c">
		    <label>Date of birth(mm/dd/yyyy):</label><input type="text" name="DOB"/><br />
		    <label>Personal goal1: </label><input type="text" name="pg1"/><br />
		    <label>Personal goal2: </label><input type="text" name="pg2"/><br />
		    <label>Personal goal3: </label><input type="text" name="pg3"/><br />
		    <input id="button_register" type="submit" value="Register!"/>
		    <p>* required</p>
		</div>
		
	  </form>
	</div>
	
	
	<div id="logout_container">
	  <div class="error">
	    
	  </div>
	  <a id="logout" href="#">Log out</a>
	  <!-- <form style="display:none;" name="logout" id = "logout" action='logout.php' method='post' id="logout"><input id='button_logout' type='submit' value='Log out' /></form> -->
	</div>
	<script>
		var ajax_response="";
		$("#user #register").on("submit", function(e){
			e.preventDefault();
			$.post("register.php", $(this).serialize(), function(data){
				if(data["success"]==1)
				{
					$("#user").hide(500);
					$("#user #login_container").hide(500);
					$("#user #register_container").hide(500);
					$("#uesr #login_container").remove();
					$("#user #register_container").remove();
					$("#user #logout_container").show(500);
					$("#user").show(500);
					alert("You have successfully registered!");
					window.location.reload();
					//display_user_info(data);
					
				}
				else if(data["success"]==0)
				{
					$("#user #info .error").html("<p>"+data["error"]+"</p>");
				}
				else
				{
					$("#user #info .error").html("<p>"+"We encountered an unknown error!"+"</p>");
				}
			}, "json").fail(function(jqXHR, textStatus, errorThrown){
				$("#user #info .error").html("<p>"+"Some serious error has occurred: "+textStatus + ", " + errorThrown+","+jqXHR.responseText+"</p>");
				
			});
			
		});
		
		$("#user #login").on("submit", function(e){
			e.preventDefault();
			$.post("login.php", $(this).serialize(), function(data){
				if(data["success"]==1)
				{
					alert("You have successfully logged in!");
					window.location.reload();
				}
				else if(data["success"]==0)
				{
					$("#user #info .error").html("<p>"+data["error"]+"</p>");
				}
				else 
				{
					$("#user #info .error").html("<p>"+"We encountered an unknown error!"+"</p>");
				}
			}, "json").fail(function(jqXHR, textStatus, errorThrown){
				$("#user #info .error").html("<p>"+"Some serious error has occurred: "+textStatus + ", " + errorThrown+","+jqXHR.responseText+"</p>");
			});
			
		});
	
		$("#user #logout").click("submit", function(e){
			e.preventDefault();
			$.post("logout.php", $(this).serialize(), function(data){
				if(data["success"]==1)
				{
					var refresh=alert("You are logged out! Click OK to refresh the page");
					window.location.href = 'index.php';
				}
				else if(data["success"]==0)
				{
					$("#user #info .error").html("<p>"+data["error"]+"</p>");
				}
				else
				{
					$("#user #info .error").html("<p>"+"We encountered an unknown error!"+"</p>");
				}
			}, "json").fail(function(jqXHR, textStatus, errorThrown){
				$("#user #info .error").html("<p>"+"Some serious error has occurred: "+textStatus + ", " + errorThrown+"</p>");
			});
			
		});

		


		
	</script>
	
</div>

<?php if(count($ERRORS)==0):?>
	<!-- If the user has already logged in and he refreshes the page -->
	<?php if(isset($_SESSION["user"])):?>
		<?php 
		//print_r($_SESSION); echo "<br />";
		?>
		<script>
			$("#user #login_container").remove();
			$("#user #register_container").remove();
			$("#user #logout_container").show(500);

			$.post("login.php", {refresh: true}, function(data){
				//Use Ajax to display user info
				if(data["success"]==1)
				{
					display_user_info(data);
					
				}
				else if(data["success"]==0)
				{
					$("#user #info .error").html("<p>"+data["error"]+"</p>");
				}
				else
				{
					$("#user #info .error").html("<p>"+"We encountered an unknown error!"+"</p>");
				}
			}, "json").fail(function(){
				$("#user #info .error").html("<p>"+"Some serious error has occurred: "+textStatus + ", " + errorThrown+"</p>");
				
			});
			
		</script>
	<!-- If the user has not logged in and he just refreshed the page -->
	<?php else:?>
		<script>
			$("#user form#login").hide();
			$("#user form#register").hide();
			$("#user #logout_container").hide();
			$("#user #login_container a").on("click", function(){
				$("#user form#login").slideToggle(300);
			});
			
			$("#user #register_container a").on("click", function(){
				$("#user form#register").slideToggle(300);
			});
			
			destroy_user_info();
		</script>
	<?php endif;?>
<?php else: ?>
	<script>
		$("#user form#login").hide();
		$("#user form#register").hide();
		$("#user #logout_container").hide();
		$("#user #info .error").html("<p>Sorryyy. We encoutered some errors in database connection!</p>");
	</script>
<?php endif; ?>
