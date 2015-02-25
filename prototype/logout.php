<?php
//This file returns a response in json format:
//"success": 1 or 0
//"error": "error message"
//
//
//
//
//
//
//
//
//

	session_start();
	header('Content-Type: application/json');
    if(isset($_SESSION['user']))
    {
    	// We remove the user's data from the session 
    	unset($_SESSION['user']); 
    	unset($_SESSION['lastActivity']);
    	// Destroy the session cookie for this session
    	setcookie(session_name(), '', time() - 72000);
    	//Destroy the session data on server
    	session_destroy();
    	
    
    	// Two options:
    	// Redirect the user to the main page 
    	//header("Location: in
    	// OR sent a json response to the page
    	echo json_encode(array("success"=>1));
    	die();
    }
    else 
    {
    	// Redirect the user to the main page
    	//header("Location: index.php");
    	// OR sent a json response to the page
    	//die("You are not signed in!");
    	echo json_encode(array("success"=>0, "error"=>"User is not logged in!"));
    	die();
    }
?>