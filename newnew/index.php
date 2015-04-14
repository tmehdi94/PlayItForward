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
<title>Play It Forward</title>
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
		<?php echo navigation("index", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<!-- Slider -->
<div class="header-banner"> 
  <script src="js/responsiveslides.min.js"></script> 
  <script>
			 $(function () {
			  $("#slider").responsiveSlides({
				auto: true,
				nav: true,
				speed: 500,
				namespace: "callbacks",
				pager: true,
			  });
			 });
			 </script>
  <div class="container">
    <div class="slider">
      <div class="callbacks_container">
        <ul class="rslides" id="slider">
          <li> <img src="images/slides/slide1.jpg" alt="">
            <div class="caption">
              <h1>Break out of your shell<span>!</span></h1>
              <p>Get out of your comfort zone and do things you never thought you were capable of.</p>
              <a href="login.php" class="btn">Register now</a> </div>
          </li>
          <li> <img src="images/slides/slide2.jpg" alt="">
            <div class="caption">
              <h1>Complete missions and level up in confidence<span>!</span></h1>
              <p>Take on missions that keep challenging you to improve your self-esteem.</p>
              <a href="faq.php" class="btn">Learn more</a> </div>
          </li>
          <li> <img src="images/slides/slide3.jpg" alt="">
            <div class="caption">
              <h1>Keep track of your progress<span>!</span></h1>
              <p>Record a journal entry after every mission and see how far you've came.</p>
              <a href="login.php" class="btn">Join now</a> </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Welcome Section -->
<div id="section_header">
  <h2>Welcome to <span>Play It Forward</span>!</h2>
</div>
<div id="welcome">
  <div class="container">
    <div class="col-md-4"> <img class="img-responsive" src="images/confident-kid.jpg"> </div>
    <div class="col-md-8">
      <h3>About us</h3>
      <p>Play It Forward is a place for people to improve themselves by building their confidence levels, no matter their current perceived level of confidence. You can complete challenges, aka "missions" with the intention of building a solid foundation of healthy confidence.</p>
	  <p>Play It Forward has the potential to assist anyone willing to put the work towards changing their lives for the better, gradually leaving their comfort zones and becoming more independent, self-assured individuals.</p>
      <p>Our mission is to help guide individuals who feel that they lack confidence and are looking to build theirs by providing the resources and opportunities to do so in a safe and fun way.</p>
      <a href="login.php" class="btn">Join now</a> </div>
  </div>
</div>
</div>
<!-- What we do Section -->
<div id="section_header">
  <h2><span>What</span> we do</h2>
</div>
<div id="main-services">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 centered"> <i class="fa fa-gears fa-3x"></i>
        <h3>Select missions to complete</h3>
        <p>Once you log in, you have an option to select from a list of missions. Choose whatever missions you are most comfortable.</p>
        <a href="faq.php" class="btn">More info</a> </div>
      <div class="col-lg-4 centered"> <i class="fa fa-line-chart fa-3x"></i>
        <h3>Level up in confidence</h3>
        <p>Once you have completed enough missions, you level up and can take on more challenging missions!</p>
        <a href="login.php" class="btn">Join now</a> </div>
      <div class="col-lg-4 centered"> <i class="fa fa-pencil fa-3x"></i>
        <h3>Keep track of how far you came</h3>
        <p>Write a journal entry after every completed mission, which you can view at any time. See how much progress you made since you started!</p>
        <a href="faq.php" class="btn">Got questions?</a> </div>
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