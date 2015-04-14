<?php
include_once 'includes/dbConnect.php';
include_once 'includes/functions.php';
 
sec_session_start();

$loggedin = login_check($db);

if (!$loggedin) {
	header("Location: login.php");
}

// localize variables
$db->where ("username", $_SESSION['username']);
$user = $db->getOne("users");


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Play It Forward | Overview</title>
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
        <?php echo navigation("overview", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<div id="section_header">
  <div class="container">
    <h2><span>Welcome</span> <?php echo htmlentities($user['username']); ?>!</h2>
  </div>
</div>
<div id="about_section_1">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-xs-3 mix"> 
		<img src=
		<?php if ($user['avatar'] == NULL) { ?>
				"images/default-avatar.png" 
		<?php } else { ?>
				<!-- TODO: Change to URL of user avatar-->
				"[the user image]" 
		<?php } ?>
		class="img-responsive" alt="avatar" />
		<br/>
		<h3 class="text-center"><b><?php echo $user['username']; ?></b></h3>
	  </div>
      <div class="col-lg-9 col-xs-6 mix">
		<h3>Current Level: <?php echo $user['level']; ?></h3>
        Debugging:
        <?php test_reward_exp($user['level']) ?><!-- This is for debugging and testing, so it's completely nonessential-->
        <!--Prints EXP Progress-->
		<h3>Experience Needed: <?php echo get_exp_progress($user['experience'], $user['level']); ?> /
            <?php echo get_level_exp($user['level']); ?></h3> 
         <!--Bar fills with EXP percentage-->
		<div class="progress progress-striped">
			<div class="progress-bar progress-bar-custom" role="progressbar" 
                aria-valuemin="0" aria-valuemax="100" 
                style="width: <?php echo get_exp_percent($user['experience'], $user['level']); ?>%" > 
			</div>
		</div>
        
		<h3>Accepted Missions:  </h3>
			<!-- TODO: Write function to output accepted missions -->
		    <table class="table">
			<tbody>
				<tr class="warning">
					<td>Mission 1</td>
				</tr>
				<tr class="active">
					<td>Mission 2</td>
				</tr>
				<tr class="warning">
					<td>Mission 3</td>
				</tr>
				<tr class="active">
					<td>Mission 4</td>
				</tr>
			</tbody>
			</table>
        <h3>Most Recent Journal Entry:</h3>
		<!-- TODO: Write function to output most recent journal entry -->
        <p>Lorem ipsum dolor sit amet, sem sodales in sapien, sed risus. Pharetra ullamcorper, maecenas egestas, quis pellentesque proin eget donec nam libero, eget egestas velit, mi nulla feugiat elit suscipit sed. Elit eget mauris feugiat. Nulla pharetra pharetra pulvinar est deserunt scelerisque, posuere orci ac nulla vivamus pede, dolor luctus commodo etiam est, convallis risus pede aliquam in ac. Scelerisque eu quis dictumst in urna consequat.
		<br/><a href="journal.php"><b>View Journal</b></a></p>

        
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