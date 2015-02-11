<?php 
//This file returns a response in json format:
//"success": 1 or 0
//"error": "error messages(seperated by commas)"
//"username": "blah"
//"email": "blah@blah"
//
//
//
//
//
//
//
    if(!empty($_POST)) 
    {
    	require("dbconnect.php");
    	require("helper_functions.php");
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
    	
    	
    	//If the user has already logged in, return the info about the user
    	if(isset($_SESSION["user"]))
    	{
    		$user=$_SESSION["user"];
    		echo json_encode(array("error"=>"None", "success"=>1, "sid"=>session_id(), "current_user"=>$user));
    		die();
    	}
    	
    	//If the user has not logged in
    	else if(!isset($_SESSION["user"]))
    	{
	    	$error_msg="";
	    	
	    	$submitted_username = '';
	        // This query retreives the user's information from the database using 
	        // their username. 
	        $query = " SELECT * FROM users WHERE username = :username"; 
	         
	        // The parameter values 
	        $query_params = array( 
	            ':username' => $_POST['username'] 
	        ); 
	         
	        try 
	        { 
	            // Execute the query against the database 
	            $stmt = $db->prepare($query); 
	            $result = $stmt->execute($query_params); 
	        } 
	        catch(PDOException $ex) 
	        { 
	        	$error_msg="Failed to run query: " . $ex->getMessage();
	        	$_SESSION["error"]=$error_msg;
	        	echo json_encode(array("error"=>$error_msg, "success"=>0));
	        	die();
	        } 
	         
	        // This variable tells us whether the user has successfully logged in or not. 
	        // We initialize it to false, assuming they have not. 
	        // If we determine that they have entered the right details, then we switch it to true. 
	        $login_ok = false; 
	         
	        // Retrieve the user data from the database.  If $row is false, then the username 
	        // they entered is not registered. 
	        $user = $stmt->fetch(); 
	        if($user) 
	        { 
	            // Using the password submitted by the user and the salt stored in the database, 
	            // we now check to see whether the passwords match by hashing the submitted password 
	            // and comparing it to the hashed version already stored in the database. 
	            
	        	if(!validate_password($_POST['password'], $_POST['password'], $db, $user["id"], "login", $_POST['password']))
	        	{
	        		$login_ok=false;
	        	}
	        	else 
	        	{
	        		$login_ok=true;
	        	}
	        	
	        } 
	         
	        if($login_ok) 
	        { 
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
// 				echo '<script type="text/javascript">
// 				alert("You are logged in! Click OK to refresh the page")
// 				window.location.reload()
// 				</script>';
				
	           	die();
	        } 
	        else 
	        { 
	            $error_msg="Login failed. Incorrect username or password";
	            $_SESSION["error"]=$error_msg;
	            echo (json_encode(array("error"=>$error_msg, "success"=>0))); 
	            die();
	            
	        } 
    	}
    }
    else 
    {
    	$error_msg="Empty POST";
    	echo (json_encode(array("error"=>$error_msg, "success"=>0))); 
    	$_SESSION["error"]=$error_msg;
    	die();
    } 
     
?> 