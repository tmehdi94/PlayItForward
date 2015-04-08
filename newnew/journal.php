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
    <?php echo navigation("journal", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<!-- Welcome Section -->
<div id="section_header">
  <h2><span>Journal</span></h2>
</div>
<div id="welcome">
  <div class="container">
    <div class="col-md-6"> <img class="img-responsive" src="images/about1.jpg" align=""> </div>
    <div class="col-md-6">
      <h3>About us</h3>
      <p>Lorem ipsum dolor sit amet, quo meis audire placerat eu, te eos porro veniam. An everti maiorum detracto mea. Eu eos dicam voluptaria, erant bonorum albucius et per, ei sapientem accommodare est. Saepe dolorum constituam ei vel. Te sit malorum ceteros repudiandae, ne tritani adipisci vis.</p>
      <p>Lorem ipsum dolor sit amet, quo meis audire placerat eu, te eos porro veniam. An everti maiorum detracto mea. Eu eos dicam voluptaria, erant bonorum albucius et per, ei sapientem accommodare est.</p>
      <a href="about.html" class="btn">More</a> </div>
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