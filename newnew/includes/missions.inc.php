<?php
	include_once 'dbConnect.php';
    include_once 'includes/functions.php'; //Include EXP helper functions
    include_once 'classes/user.class.php';
	$message = "";
if (isset($_POST['title'], $_POST['entry'], $_POST['missionId'], $_POST['userId'])) {
	$user = new User($_POST['userId'], $db);
	$gainedEXP = $user->completeMission($db, $_POST['missionId'], $_POST['title'], $_POST['entry']);

	$message = "<div class='alert alert-success' role='alert'>
			<strong>Congratulations!</strong><br/>
			You have completed the mission and have been rewarded <strong>$gainedEXP</strong> EXP!";
}
?>