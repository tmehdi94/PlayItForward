<!doctype html>
<html>
	<head>
		<!--Favicon icon-->
		<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAANliAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABERAAAAAAARERERAAAAARERERERAAABEREREREQABEREAERERAAEREAABEREAAREQAAEREQAAEREAABEQAAAREREAAAAAAAERERAAAAAAABEREQAAAAAAABERAAAAAAAAEREAAAAAAAABEAAAAAAAAAEAAAAAAAAAEAAAAAD4fwAA4B8AAMAHAADAAwAAgwMAAIeDAACHgwAAw8cAAMD/AADgfwAA8D8AAPw/AAD8PwAA/n8AAP7/AAD9/wAA" rel="icon" type="image/x-icon" />		<link href='http://fonts.googleapis.com/css?family=Share+Tech' rel='stylesheet' type='text/css'>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
		<script>  
                function toggle_visibility(id) {
                  $("#" + id).toggle('medium');
                } 
		</script>
		<script>
		$(function() {
			$(".meter > span").each(function() {
				$(this)
					.data("origWidth", $(this).width())
					.width(0)
					.animate({
						width: $(this).data("origWidth")
					}, 1200);
			});
		});
		</script>
		<script>
		$(function() {
			$( "#dialog" ).dialog({
			autoOpen: false,
			modal: true,
			show: {
				effect: "blind",
				duration: 1000
			},
			hide: {
				effect: "explode",
				duration: 1000
			}
			});
		
			$( "#personalgoals" ).click(function() {
			$( "#dialog" ).dialog( "open" );
			});
		});
		$(function() {
			$( "#notification" ).dialog({
			modal: true,
			width: 500,
			show: {
				effect: "blind",
				duration: 1000
			},
			hide: {
				effect: "explode",
				duration: 1000
			}
			});
		});
		</script>		
		<title>Confiden | 
		<?php 
			if (basename($_SERVER['PHP_SELF']) == "index.php") echo "Welcome";
			else if (basename($_SERVER['PHP_SELF']) == "missions.php") echo "Missions";
			else if (basename($_SERVER['PHP_SELF']) == "contact.php") echo "Contact";
			else if (basename($_SERVER['PHP_SELF']) == "faq.php") echo "FAQ";
			else if (basename($_SERVER['PHP_SELF']) == "resources.php") echo "Resources";
			else if (basename($_SERVER['PHP_SELF']) == "privacypolicy.php") echo "Privacy Policy";
			else if (basename($_SERVER['PHP_SELF']) == "termsandconditions.php") echo "Terms and Conditions";
			else if (basename($_SERVER['PHP_SELF']) == "journal.php") echo "Journal";
			else if (basename($_SERVER['PHP_SELF']) == "about.php") echo "About Us";
			// etc
		?>
		</title>
		<?php
			if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
			<link rel="stylesheet" type="text/css" href="style/slider.css" />
			<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
			<script type="text/javascript" src="scripts/coda-slider.1.1.1.pack.js"></script>
			<script type="text/javascript" src="scripts/jquery-easing-1.3.pack.js"></script>
			<script type="text/javascript" src="scripts/jquery-easing-compatibility.1.2.pack.js"></script>
			
			<script type="text/javascript" src="scripts/slider.js"></script>
		<?php } ?>
		
		<link rel="stylesheet" type="text/css" href= "style/format.css">
		<!-- <script src="http://code.jquery.com/jquery-1.9.0.js"></script> -->
		<!--<script src="scripts/jquery-1.7.1.js"></script>-->
		<?php
			if (basename($_SERVER['PHP_SELF']) == "contact.php") {
		?>
		<link rel="STYLESHEET" type="text/css" href="contact.css" />
		<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
		
		<?php } ?>
	</head>
	<body>
		<div id="header">
		
		<!--LOGO, YO-->
		<a href = "index.php" style = "float:left;"><img alt="Logo" src = "style/resources/LOGOforheader.png" height = "40"></a>
			<?php 
			include("user.php");
			$notification = "";
			if (isset($_POST['submit']) && ($_POST['submit'] == "Submit Mission")) {
				
				if(str_word_count($_POST['feedback']) < 30) {
					$notification .= "Please write at least 30 words on what you experienced!<br/>";
				}
				else {
					$yay = submit_mission($_SESSION['user']['id'], $db, $_POST['id'], $_POST['feedback']); 
					
					if ($yay===true) {
						$notification .= "Congratulations! You have successfully completed the mission!";
						$notification .=level_up($_SESSION['user']['id'], $db);
					}
					else {
						$notification .= $yay;
					}
					
				}
			}
			else if (isset($_POST['submit']) && ($_POST['submit'] == "Suggest Mission")) {
				
				if ($_POST["suggest"] == "") {
					$notification .= "Please enter something to be suggested!";
				}
				else {
					$yay = suggest_mission($_SESSION['user']['id'], $_POST['suggest'], $db);
					if ($yay===true) {
						$notification .= "Thanks for your suggestion homie!";
					}
					else {
						$notification .= "Some error occurred!";
					}
				}
			}

			?>
			<!-- Logo, site name here -->
			<!--Our awesome header here-->
			
		</div>
		<?php 
			if ((isset($notification)) && ($notification != NULL) &&($notification != ""))
			echo "<div title='Notification!' id='notification'>".$notification."</div>"; ?>
