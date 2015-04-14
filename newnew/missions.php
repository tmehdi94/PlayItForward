<?php
include_once 'includes/dbConnect.php';
include_once 'includes/functions.php';
include_once 'includes/missions.inc.php'; 

sec_session_start();

$loggedin = login_check($db);
if(!$loggedin) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Play It Forward | Missions</title>
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css'/>
<!-- Font Awesome  -->
<link href="css/font-awesome.min.css" rel="stylesheet">
<!-- Web Font  -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquery.min.js"></script>
<script src="js/missions.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php"><i class="fa fa-sun-o"></i> Play It Forward</a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php echo navigation("missions", $loggedin); ?>
      </ul>
    </div>
  </div>
</nav>
<div id="section_header">
  <div class="container">
    <h2><span>Missions</span></h2>
  </div>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

<div class="container">
  <div class="row">
    
        
        <div class="col-md-12">
        <h4>Mission Assignments</h4>
        <div class="table-responsive">

              <table id="mytable" class="table table-bordred table-striped">
                   <thead>
				   
                   <th>Level</th>
                    <th>Title</th>
                     <th>Description</th>
                      <th>Complete</th>
                       <th>Give up</th>
                   </thead>
    <tbody>
    <?php echo getAssignedMissions($_SESSION['username'], $db); ?>
    </tbody>
        
</table>

<div class="clearfix"></div>                
            </div>
            
        </div>
  </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Journal Entry</h4>
      </div>
          <div class="modal-body">
          <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="mission_complete"
				id="mission_complete">
        <div class="form-group">        
        <input name="title" id="title" class="form-control " type="text" placeholder="Give your journal entry a title...">
        </div>
        <div class="form-group">
        <textarea name="entry" id="entry" rows="2" class="form-control" placeholder="Write about your mission..."></textarea>
		<input name="missionId" id="missionId" class="form-control " type="hidden" value="">
		<input name="userId" id="userId" class="form-control " type="hidden" value="<?php echo $_SESSION['uid']; ?>">
		</div>
		 <div class="modal-footer ">
		<button type="submit" class="btn btn-warning btn-lg" style="width: 100%;">Save</button>
    
        
        </div>
		</form>
      </div>
         
        
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Give up?</h4>
      </div>
      <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to give up on this mission?</div>
       
      </div>
        <div class="modal-footer ">
          <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
        </div>
    </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
<!-- END testing  -PHIL -->



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
</body>
</html>