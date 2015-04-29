<?php
include_once 'includes/dbConnect.php';
include_once 'includes/functions.php';
include_once 'includes/preferences.inc.php';

//sec_session_start();

$loggedin = login_check($db);

if (!$loggedin) {
	header("Location: login.php");
}

$db->where ("username", $_SESSION['username']);
$user = $db->getOne("users");

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Play It Forward | Preferences</title>
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css'/>
<!-- Font Awesome  -->
<link href="css/font-awesome.min.css" rel="stylesheet">
<!-- Web Font  -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquery.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php"><i class="fa fa-sun-o"></i> Play It Forward</a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
    <?php echo navigation("preferences", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>

<div id="section_header">
  <div class="container">
    <h2><span>Preferences</span> </h2>
  </div>
</div>
<div id="about_section_1">
  <div class="container">
    <div class="row">
	<?php if ( isset($_GET['success']) && $_GET["success"] == 1) { ?>
		<div class="col-md-6 col-md-offset-3 alert alert-success" role="alert">
			<strong>You have updated your preferences!</strong>
		</div>
	<?php
	} else if ( isset($error_msg) && ($error_msg != "")) { ?>
		<div class="col-md-6 col-md-offset-3 alert alert-warning" role="alert">
			<strong>Errors were encountered! <?php echo $error_msg; ?></strong>
		</div>
	<?php } ?>
	</div>
	<div class="row">
      <div class="col-lg-3 col-xs-3 mix col-lg-offset-3 col-xs-offset-3"> 
		  <h3>Change Avatar</h3>
		    <img src=
			<?php if ($user['avatar'] == NULL) { ?>
					"images/default-avatar.png" 
			<?php } else { ?>
					"<?php echo getAvatar($_SESSION['uid'], $db); ?>"
			<?php } ?>
			class="img-responsive" alt="avatar" />
			<br/>
		<h3 class="text-center"><b><?php echo $user['username']; ?></b></h3>
			<form enctype='multipart/form-data' action='<?php echo esc_url($_SERVER['PHP_SELF']); ?>' method='post'>
			<label>Choose a new profile picture</label>
			<input type='file' name='avatar' />
			<input type='submit' value='upload' />
			<br/>
			</form>
	  </div>
	  <div class="col-lg-3 col-xs-3 mix"> 
		  <h3>Update Email Address</h3>
		   <div class="form_details">
		   <form action='<?php echo esc_url($_SERVER['PHP_SELF']); ?>' method='post'>
          <input name="email" id="email" type="text" class="text" value="Email Address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email Address';}" title="Enter primary email address" >
		  <button class="btn" type="submit">Change Email</button>
		  </div>
	  </div>
	 </div>
	</div>
</div>

<!-- Footer -->
<div id="footerwrap">
  <div class="container">
    <div class="row">
      <div class="col-md-8"> <span class="copyright">Copyright &copy; 2015 Your Website Name. Design by <a href="http://www.templategarden.com" rel="nofollow">TemplateGarden</a></span> </div>
      <div class="col-md-4">
        <ul class="list-inline social-buttons">
          <li><a href="#"><i class="fa fa-twitter"></i></a> </li>
          <li><a href="#"><i class="fa fa-facebook"></i></a> </li>
          <li><a href="#"><i class="fa fa-google-plus"></i></a> </li>
          <li><a href="#"><i class="fa fa-linkedin"></i></a> </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript --> 
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
