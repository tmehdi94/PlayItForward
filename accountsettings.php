<?php 
if(!empty($_POST))
{
	
	require("dbconnect.php");
	require("helper_functions.php");
	header("Content-Type: application/json");
	header("Last-Modified: {now} GMT");
	header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');
	
	session_start();
	
	//A custom session timeout implementation
	if(isset($_SESSION["lastActivity"]) && time()-$_SESSION["lastActivity"]>1800)
	{
		unset($_SESSION['user']);
		unset($_SESSION['lastActivity']);
		setcookie(session_name(), '', time() - 72000);
		session_destroy();
		header("Location: index.php");
		die();
	}
	else
	{
		$_SESSION["lastActivity"]=time();
	}
	
	if(isset($_SESSION["user"]))
	{
		//Get the id of the user
		$uid=$_SESSION["user"]["id"];
		
		//If user sends an update request for username
		if(isset($_POST["username"]))
		{
			//Check for duplicate username
			$query = "SELECT * FROM users WHERE username = :username";
			$query_params = array(
					':username' => $_POST['username']
			);
			
			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				$error_msg="Failed to run query: " . $ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
				
			if($stmt->rowCount()!=0)
			{
				$error_msg="Duplicate username";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			
			//Make an update to the users table where user id matches
			try
			{
				$query="UPDATE `users` SET `username`=:username WHERE `id`=:uid";
				$stmt=$db->prepare($query);
				$query_params=array(":username"=> $_POST["username"], ":uid"=>$uid);
				$result=$stmt->execute($query_params);
				
				
			}
			catch(PDOException $ex)
			{
				$error_msg="Username update failed. Failed to run query: ".$ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
		}
		
		
		//If user sends an update request for email
		else if(isset($_POST["email"]))
		{
			//Validate email format
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				$error_msg="Invalid email address";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			
			//Check for duplicate email address
			$query = "SELECT * FROM users WHERE email = :email";
				
			$query_params = array(
					':email' => $_POST['email']
			);
				
			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				$error_msg="Failed to run query: " . $ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
				
			if($stmt->rowCount()!=0)
			{
				$error_msg="Duplicate email address";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			
			//Make an update to the users table where user id matches
			try
			{
				$query="UPDATE `users` SET `email`=:email WHERE `id`=:uid";
				$stmt=$db->prepare($query);
				$query_params=array(":email"=>$_POST["email"], ":uid"=>$uid);
				$result=$stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				$error_msg="Email update failed. Failed to run query: ".$ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
		}
		
		//If user sends an update request for password
		else if(isset($_POST["password"]))
		{
			try
			{
				
				//Validate the password
// 				$query="SELECT `password`, `salt` FROM `users` WHERE `id`=:uid";
// 				$query_params=array(":uid"=>$uid);
// 				$stmt=$db->prepare($query);
// 				$result=$stmt->execute($query_params);
// 				$row=$stmt->fetch();
				
// 				$check_password = hash('sha256', $_POST["old_password"] . $row["salt"]);
// 				for($round = 0; $round < 65536; $round++)
// 				{
// 					$check_password = hash('sha256', $check_password . $row["salt"]);
// 				}
// 				if($check_password!=$row["password"])
// 				{
// 					$error_msg="You enter an incorrect password";
// 					echo json_encode(array("error"=>$error_msg, "success"=>0));
// 					die();
// 				}
				
				if(!validate_password($_POST["password"], $_POST["password_again"], $db, $uid, "change", $_POST["old_password"]))
				{
					die();
				}

				//Update the password
				$salt=dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
				$password=hash('sha256', $_POST["password"].$salt);
				for($round = 0; $round < 65536; $round++)
				{
					$password = hash('sha256', $password . $salt);
				}
				
				$query="UPDATE `users` SET `password`=:password, `salt`=:salt WHERE `id`=:uid";
				$query_params=array(":password"=>$password, ":salt"=>$salt, ":uid"=>$uid);
				$stmt=$db->prepare($query);
				$result=$stmt->execute($query_params);
				
			}
			catch(PDOException $ex)
			{
				$error_msg="Failed to run query: ".$ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			
		}
		
		
		//If user sends an update request for personal goals
		else if(isset($_POST["pg1"]) && isset($_POST["pg2"]) && isset($_POST["pg3"]))
		{
			if(!empty($_POST["pg1"]))
			{
				$pg=$_POST["pg1"];
				$query="UPDATE `users` SET `personalgoal1`=:pg WHERE `id`=:uid";
				$query_params=array(":pg"=>$pg, ":uid"=>$uid);
				$stmt=$db->prepare($query);
				$result=$stmt->execute($query_params);
			}
			else if(!empty($_POST["pg1"]))
			{
				$pg=$_POST["pg2"];
				$query="UPDATE `users` SET `personalgoal2`=:pg";
				$query_params=array(":pg"=>$pg, ":uid"=>$uid);
				$stmt=$db->prepare($query);
				$result=$stmt->execute($query_params);
			}
			else if(!empty($_POST["pg1"]))
			{
				$pg=$_POST["pg3"];
				$query="UPDATE `users` SET `personalgoal3`=:pg";
				$query_params=array(":pg"=>$pg, ":uid"=>$uid);
				$stmt=$db->prepare($query);
				$result=$stmt->execute($query_params);
			}
			else
			{
				$error_msg="You must enter at least some words to describe your goals";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			
		}
		
		//Query for the latest user info and return it to the caller
		try
		{
			$query="SELECT * FROM `users` WHERE `id`=:uid";
			$query_params=array(":uid"=>$uid);
			$stmt=$db->prepare($query);
			$result=$stmt->execute($query_params);
			$user=$stmt->fetch();
			
			//Extra query to fetch the tasks the user has completed 
			$query="SELECT `tasks`.`title`, `tasks`.`star` FROM
		            		`tasks` WHERE
		            		`tasks`.`id` IN
		            		(SELECT `completedtasks`.`tid` FROM
		            		`completedtasks` WHERE
		            		`completedtasks`.`uid`=:userId)";
			
			$query_params=array(":userId"=>$user["id"]);
			$stmt=$db->prepare($query);
			$result=$stmt->execute($query_params);
			
			$completedTasks=array();
			$completedTasks=$stmt->fetchAll();
			$user["completedTasks"]=$completedTasks;
		}
		catch(PDOException $ex)
		{
			$error_msg="Failed to run query: ".$ex->getMessage();
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		
		//Update the Session variable
		$_SESSION["user"]["username"]=$user["username"];
		$_SESSION["user"]["email"]=$user["email"];
		$_SESSION["user"]["personalGoal1"]=$user["personalGoal1"];
		$_SESSION["user"]["personalGoal2"]=$user["personalGoal2"];
		$_SESSION["user"]["personalGoal3"]=$user["personalGoal3"];
		
		echo json_encode(array("error"=>"None", "success"=>1,  "sid"=>session_id(), "current_user"=>$user));
		die();
	}
}


?>

