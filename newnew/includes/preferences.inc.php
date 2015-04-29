<?php

define ('SITE_ROOT', realpath(dirname(__FILE__) . '/..' ));

include_once 'dbConnect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if(!empty($_FILES["avatar"])) {

	try{
		//Check upload errors
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
			throw new Exception($error_msg);
		}
		
		//Check file type
		$tmp_fileloc=$_FILES["avatar"]["tmp_name"];
		if(exif_imagetype($tmp_fileloc)==false)
		{
			$error_msg="The image uploaded is not a valid image type";
			throw new Exception($error_msg);
		}
		
		//Upload and replace the file
		
		$tmp = explode(".", $_FILES["avatar"]["name"]);
		$suffix=end($tmp);
		$filename = generateRandomString();
		$newname = SITE_ROOT."\images\avatars\\".$filename.".".$suffix;
		
		if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $newname))
		{
			$error_msg="Failed to process uploaded image";
			throw new Exception($error_msg);
		}
		
		//Update avatar field in the database for the user
		
		$avatarname = "images/avatars/".$filename.".".$suffix;
		try
		{
			$db->rawQuery("UPDATE users	SET avatar = ? WHERE uid = ?", Array($avatarname,$_SESSION['uid']));
		}catch(PDOException $ex)
		{
			$error_msg="Failed to run query: " . $ex->getMessage();
			throw new Exception($error_msg);
		} 
	} 
	catch(Exception $ex)
	{
		$error_msg=$ex->getMessage();
	}
	
	if($error_msg=="")
	{		
		header('Location: preferences.php?success=1');
	}
}

else if (isset ($_POST["email"])) {
	//validation
	$db->rawQuery("UPDATE users	SET email = ? WHERE uid = ?", Array($_POST["email"],$_SESSION['uid']));
	if ($_POST["email"] == "") {
		$error_msg = "Please enter an email address!";
	} else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$error_msg = "Invalid email format!"; 
	}
}