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
		<?php echo navigation("FAQ", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<!-- What we do Section -->
<div id = "about_section_1">
    <div class="container">
        <div class="row">
            <h3>What is <span>Play It Forward?</span></h3>
            <p>Play It Forward is a tool designed to help the user overcome social anxiety and become more confident.</p>
        </div>
        <div class="row">
            <h3>Why should I use <span>Play It Forward?</span></h3>
            <p>If you feel uncomfortable in social situations or want to be more outgoing. -ADD MORE-</p>
        </div>
        <div class="row">
            <h3>How does it work?</h3>
            <p>After signup, you will be given a selection of missions to complete. 
            These missions are designed to guide you outside your comfort zone in social
            situations. Completing these missions earns you experience and makes you level 
            up, allowing you to complete more challenging missions.</p>
            <p>Early missions will focus on confidence-building and developing thought
            strategies to make you more comfortable in social situations. As you level 
            up, missions will begin to apply these tools to real situations in your life. </p>
        </div>
        <div class="row">
            <h3>These missions are too easy! Can I skip them?</h3>
            <p>Everyone starts at a different point, and we here at Play It Forward want to
            make sure everyone is able to use our program. While it is not possible to skip
            early missions, Play It Forward gives you the option to take on more 
            challenging early missions, the kinds you would take on at later levels. 
            Doing this earns you bonus experience so you can pass by the earlier levels 
            faster if you want.</p>
            <br>
            <br>
        </div>
        <div class="row">
            <h3>These missions have gotten a little tough. What should I do?</h3>
            <p>If you ever feel you aren't ready for a mission, you can take on beginner
            missions for a level. These are similar to lower-level missions, but award
            less experience, so you have to complete more of them to level up. We want 
            to make sure you're always moving forward at your own pace.</p>
        </div>
        <div class="row">
            <h3>Why does this page look like garbage?</h3>
            <p>Jake doesn't know how to CSS or format properly. Luckily this page is 
            basically just text</p>
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