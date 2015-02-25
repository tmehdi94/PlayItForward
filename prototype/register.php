<?php 
//This file returns a response in json format:
//"success": 1 or 0
//"error": "error messages(seperated by commas)"
//"username": "blah"
//"email": "blah@blah"
//etc...
//
//
//
//
//
//
	if(!empty($_POST))
	{
		require('dbconnect.php');
		require('helper_functions.php');
		header('Content-Type: application/json');
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
		
		$error_msg="";
		
		if(empty($_POST['username']))
		{
			$error_msg="Empty user name";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		
		 
		if(empty($_POST['password']))
		{
			$error_msg="Empty password";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		else if(!validate_password($_POST['password'], $_POST['password_again'], $db, "", "register", $old_password=""))
		{
			die();
			
		}
		
		if(empty($_POST['email']))
		{
			$error_msg="Empty email";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		
		 
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$error_msg="Invalid email address";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		
		if(!empty($_POST["DOB"]))
		{
			try{
				$dob=new DateTime($_POST["DOB"]);
			}catch(Exception $e)
			{
				$error_msg=$e->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			$dob_formatted=explode("/", $dob->format("m/d/Y"));
			$m=$dob_formatted[0];
			$d=$dob_formatted[1];
			$y=$dob_formatted[2];
			if(!checkdate($m, $d, $y))
			{
				$error_msg="Wrong date format for the birthday";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
		}
		
		
		if(!empty($_FILES["avatar"]))
		{
			$possible_errs=array( 
			        0=>"There is no error, the file uploaded with success", 
			        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini", 
			        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form" ,
			        3=>"The uploaded file was only partially uploaded", 
			        4=>"No file was uploaded", 
			        6=>"Missing a temporary folder" 
			);
			if($_FILES["avatar"]["error"]!=0)
			{
				$error_msg=$possible_errs[$_FILES["avatar"]["error"]];
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			
			$tmp_fileloc=$_FILES["avatar"]["tmp_name"];
			if(exif_imagetype($tmp_fileloc)==false)
			{
				$error_msg="The image uploaded is not a valid image type";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
		}
		
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
		 
		$query = "
            INSERT INTO users (
                username,
                password,
                salt,
                email,
				gender,
				dob,
				level,
				personalgoal1,
				personalgoal2,
				personalgoal3
            ) VALUES (
                :username,
                :password,
                :salt,
                :email,
				:gender,
				STR_TO_DATE(:dob, '%m/%d/%Y'),
				:level,
				:personalgoal1,
				:personalgoal2,
				:personalgoal3
            )
        ";
		 
		// A salt is randomly generated here to protect against brute force attacks
		// and rainbow table attacks.  The following statement generates a hex
		// representation of an 8 byte salt.  Representing this in hex provides
		// no additional security, but makes it easier for humans to read.
		// For more information:
		// http://en.wikipedia.org/wiki/Salt_%28cryptography%29
		// http://en.wikipedia.org/wiki/Brute-force_attack
		// http://en.wikipedia.org/wiki/Rainbow_table
		$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
		 
		// This hashes the password with the salt so that it can be stored securely
		// in your database.  The output of this next statement is a 64 byte hex
		// string representing the 32 byte sha256 hash of the password.  The original
		// password cannot be recovered from the hash.  For more information:
		// http://en.wikipedia.org/wiki/Cryptographic_hash_function
		$password = hash('sha256', $_POST['password'] . $salt);
		 
		// Next we hash the hash value 65536 more times.  The purpose of this is to
		// protect against brute force attacks.  Now an attacker must compute the hash 65537
		// times for each guess they make against a password, whereas if the password
		// were hashed only once the attacker would have been able to make 65537 different
		// guesses in the same amount of time instead of only one.
		for($round = 0; $round < 65536; $round++)
		{
			$password = hash('sha256', $password . $salt);
		}
		 
		$query_params = array(
			':username' => $_POST['username'],
			':password' => $password,
			':salt' => $salt,
			':email' => $_POST['email'],
			':gender' => $_POST['gender'],
			':dob' => $_POST['DOB'],
			':level' => 1,
			':personalgoal1' => $_POST['pg1'],
			':personalgoal2' => $_POST['pg2'],
			':personalgoal3' => $_POST['pg3']
		);
		 
		try
		{
			$stmt = $db->prepare($query);
			$result = $stmt->execute($query_params);
		}catch(PDOException $ex)
		{
			$error_msg="Failed to run query: " . $ex->getMessage();
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		
		}
		
		
		
		$query="SELECT * FROM users WHERE username=:username";
		$query_params=array(":username"=>$_POST['username']);
		try
		{
			$stmt=$db->prepare($query);
			$result=$stmt->execute($query_params);
		}catch(PDOException $ex)
		{
			$error_msg="Failed to run query: " . $ex->getMessage();
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		
		//Saving the avatar of the user if he uploaded an image
		/*if(!empty($_FILES["avatar"]))
		{
			$user_folder_loc="users/".$_POST['username'];
			if(!(mkdir($user_folder_loc)))
			{
				$error_msg="Failed to create user directory";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			$suffix=array_pop(explode(".", $_FILES["avatar"]["name"]));
			if(!(move_uploaded_file($_FILES["avatar"]["tmp_name"], $user_folder_loc."/avatar.".$suffix)))
			{
				$error_msg="Failed to process uploaded image";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
			$query="UPDATE users SET `avatar`=:avatar WHERE `username`=:username";
			$query_params=array(":avatar"=>$_FILES["avatar"]["name"], ":username"=>$_POST["username"]);
			try
			{
				$stmt=$db->prepare($query);
				$result=$stmt->execute($query_params);
			}catch(PDOException $ex)
			{
				$error_msg="Failed to run query: " . $ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}
		}*/
		
		$user=$stmt->fetch();
		
		unset($user['salt']);
		unset($user['password']);
		
		//Fetch information regarding the user's completed missions
		try{
			 
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
			$error_msg="Failed to run query: " . $ex->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
		}
		
		$_SESSION["user"]=$user;
		echo json_encode(array("error"=>"None", "success"=>1, "sid"=>session_id(), "current_user"=>$user));
		
		die();
	}
	 
	?>