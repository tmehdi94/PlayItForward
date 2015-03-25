<?php
include_once 'includes/dbConnect.php';
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';

sec_session_start();
$loggedin = login_check($db);

if ($loggedin) {
	header("Location: account.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Play It Forward | Login / Registration</title>
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css'/>
<!-- Font Awesome  -->
<link href="css/font-awesome.min.css" rel="stylesheet">
<!-- Web Font  -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquery.min.js"></script>
<!-- Form processing -->
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script> 
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php"><i class="fa fa-sun-o"></i> Play It Forward</a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php echo navigation("login", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<div id="section_header">
  <div class="container">
    <h2>
		<span>Login</span> or <span>Register</span>
	</h2>
  </div>
</div>
<div class="contact">
  <div class="container">
    <div class="col-md-6">
      <h3>Login</h3>
	  <div class="alert alert-info" role="alert">
	  <strong>Welcome back!</strong> Please login with your information here.</div>
      <form id="login_form" action="includes/processLogin.php" method="post" name="login_form">
        <div class="form_details">
          <input name="username" type="text" class="text" value="Username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Username';}" title="Enter your username">
          <input name="password" type="password" class="text" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" title="Enter your password">
		  <div class="clearfix"> </div>
          <button class="btn" type="submit" onclick="formhash(this.form, this.form.password);">Login</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <h3>Register</h3>
	  <?php
        if (!empty($error_msg)) {
		?>
			<div class="alert alert-danger" role="alert">
			<strong>Errors were encountered!</strong><br/>
		<?php
            echo $error_msg;
		?>
			</div>
		<?php
        } else {
        ?>
			<div class="alert alert-warning" role="alert">
			<strong>Hey there!</strong> Start using Play It Forward today!
			</div>
		<?php
		} 
		?>
		
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one uppercase letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
      <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="registration_form"
				id="registration_form">
        <div class="form_details">
          <input name ="username" id="username" type="text" class="text" value="Username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Username';}" title="Enter a username" >
          <input name="email" id="email" type="text" class="text" value="Email Address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email Address';}" title="Enter primary email address" >
		  <input name="password" id="password" type="password" class="text" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" title="Enter password" >
		  <input name="confirmpwd" id="confirmpwd" type="password" class="text" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" title="Confirm password" >
		  <div class="clearfix"> </div>
          <button class="btn" type="submit" onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);">Register</button>
        </div>
      </form>
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