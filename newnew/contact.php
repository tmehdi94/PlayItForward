<?php
include_once 'includes/dbConnect.php';
include_once 'includes/functions.php';

sec_session_start();

$loggedin = login_check($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Play It Forward | Contact us</title>
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
        <?php echo navigation("contact", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<div id="section_header">
  <div class="container">
    <h2><span>Contact</span> us</h2>
  </div>
</div>
<div class="contact">
  <div class="container">
    <div class="col-md-6">
      <h3>Contact info</h3>
      <p><span>Email:</span> playitforward.thuglife@gmail.com</p>
    </div>
    <div class="col-md-6">
      <h3>Get in touch</h3>
      <?php if ( isset($_GET['error']) && $_GET["error"] == 1) { ?>
			<div class="alert alert-danger" role="alert">
			<strong>Error Sending Form!</strong> Please make sure all fields are filled in.<br/>
			</div>
		<?php
        } else if (isset($_GET['success']) && $_GET['success'] == 1) {
        ?>
        <div class="alert alert-info" role="alert">
        <strong>We've got mail!</strong> You can expect a response in three to five business days.</div>
        <?php } ?>
        
      <form id="contact_form" action="includes/processMail.php" method="post" name="contact_form">
        <select name="type" type = "text" class = "text">
            <option value="">Why are you contacting us?</option>
            <option value="general">General Question</option>
            <option value="help">Site Help</option>
            <option value="suggest">Mission Suggestion</option>
        </select>
        <div class="form_details">
          <input name = "name" type="text" class="text" value="Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name';}">
          <input name = "address" type="text" class="text" value="Email Address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email Address';}">
          <input name = "subject" type="text" class="text" value="Subject" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Subject';}">
          <textarea name = "message" value="message" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message';}">Message</textarea>
          <div class="clearfix"> </div>
          <button class="btn" type="submit">Send Us Mail</button>
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