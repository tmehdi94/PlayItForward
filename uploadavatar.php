<?php
require('dbconnect.php');
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

if(!empty($_FILES["avatar"]))
{
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
		$user_folder_location="users/".$_SESSION["user"]["username"]."/";
		if(!is_dir($user_folder_location))
		{
			mkdir($user_folder_location);
			$suffix=array_pop(explode(".", $_FILES["avatar"]["name"]));
			if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $user_folder_location.$_FILES["avatar"]["name"]))
			{
				$error_msg="Failed to process uploaded image";
				throw new Exception($error_msg);
			}
		}
		else
		{
			$suffix=array_pop(explode(".", $_FILES["avatar"]["name"]));
			if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $user_folder_location.$_FILES["avatar"]["name"]))
			{
				$error_msg="Failed to process uploaded image";
				throw new Exception($error_msg);
			}
		}
		
		//Update avatar field in the database for the user
		$query="UPDATE users SET `avatar`=:avatar WHERE `username`=:username";
		$query_params=array(":avatar"=>$_FILES["avatar"]["name"], ":username"=>$_SESSION["user"]["username"]);
		try
		{
			$stmt=$db->prepare($query);
			$result=$stmt->execute($query_params);
		}catch(PDOException $ex)
		{
			$error_msg="Failed to run query: " . $ex->getMessage();
			throw new Exception($error_msg);
		}
	}catch(Exception $ex)
	{
		$error_msg=$ex->getMessage();
		$_SESSION["error"]=$error_msg;
		header('Location:index.php');
	}
	
	if($error_msg=="")
	{
		$_SESSION["user"]["avatar"]=$_FILES["avatar"]["name"];
		
		header('Location:index.php');
	}
}
?>