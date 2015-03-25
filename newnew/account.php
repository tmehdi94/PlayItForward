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
<title>Play It Forward | Account</title>
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
        <?php echo navigation("account", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<div id="section_header">
  <div class="container">
    <h2><span>Welcome</span> <?php echo htmlentities($_SESSION['username']); ?>!</h2>
  </div>
</div>
<div id="about_section_1">
  <div class="container">
    <div class="row">
      <div class="col-lg-6"> <img src="images/about2.jpg" class="img-responsive" alt=" "> </div>
      <div class="col-lg-6">
	   <?php if ($loggedin) : ?>
            <p></p>
            <p>
				You can only see this if you're logged in :D
            </p>
            <p>Return to <a href="login.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
            </p>
        <?php 
		header("Location: login.php");
		endif; ?>
        <h3>Who we are</h3>
        <p >Lorem ipsum dolor sit amet, sem sodales in sapien, sed risus. Pharetra ullamcorper, maecenas egestas, quis pellentesque proin eget donec nam libero, eget egestas velit, mi nulla feugiat elit suscipit sed. Elit eget mauris feugiat. Nulla pharetra pharetra pulvinar est deserunt scelerisque, posuere orci ac nulla vivamus pede, dolor luctus commodo etiam est, convallis risus pede aliquam in ac. Scelerisque eu quis dictumst in urna consequat.</p>
        <h3>Our history</h3>
        <p>Lorem ipsum dolor sit amet, sem sodales in sapien, sed risus. Pharetra ullamcorper, maecenas egestas, quis pellentesque proin eget donec nam libero, eget egestas velit, mi nulla feugiat elit suscipit sed. Elit eget mauris feugiat. Nulla pharetra pharetra pulvinar est deserunt scelerisque, posuere orci ac nulla vivamus pede, dolor luctus commodo etiam est, convallis risus pede aliquam in ac. Scelerisque eu quis dictumst.</p>
      </div>
    </div>
  </div>
</div>
<!-- Why choose us Section -->
<div id="section_header">
  <h2><span>Why</span> choose us</h2>
</div>
<div id="about_section_2">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h4><i class="fa fa-graduation-cap fa-2x pull-left"></i> Lorem ipsum dolor sit amet, consectetuer adipiscing elit</h4>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus.</p>
      </div>
      <div class="col-lg-6">
        <h4><i class="fa fa-trophy fa-2x pull-left"></i> Cum socis natoque penatibus et magnis dis</h4>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus.</p>
      </div>
      <div class="col-lg-6">
        <h4><i class="fa fa-globe fa-2x pull-left"></i> Aenean commodo ligula eget dolor aenean massa</h4>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus.</p>
      </div>
      <div class="col-lg-6">
        <h4><i class="fa fa-language fa-2x pull-left"></i> Ipsum dolor sit amet, consectetuer adipiscing elit</h4>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus.</p>
      </div>
    </div>
  </div>
</div>
<!-- Our clients Section -->
<div id="section_header">
  <h2><span>Our</span> clients</h2>
</div>
<div id="clients">
  <div class="container">
    <div class="row centered">
      <div class="col-lg-8 col-lg-offset-2">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-2"> <img src="images/client1.jpg" class="img-responsive"> </div>
      <div class="col-lg-2"> <img src="images/client2.jpg" class="img-responsive"> </div>
      <div class="col-lg-2"> <img src="images/client3.jpg" class="img-responsive"> </div>
      <div class="col-lg-2"> <img src="images/client4.jpg" class="img-responsive"> </div>
      <div class="col-lg-2"> <img src="images/client5.jpg" class="img-responsive"> </div>
      <div class="col-lg-2"> <img src="images/client6.jpg" class="img-responsive"> </div>
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