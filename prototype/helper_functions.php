<?php 
//A series of helper functions to
//Get the latest data regarding a particular user
//Because they query directly from the database, they are more reliable than SESSION data
//Need to implement helper functions to update the latest data?

//Return values are in all arrays.
//For single-entity queries(e.g. get_current_mission), the array is associative, with key as the column name and the value as the value.
//For multi-entity queries(e.g. get_completed_missions), each entity is an array, and they are nested inside a bigger array

function get_current_mission($uid, $db)
{
	try
	{
		$query="SELECT `currentTask` FROM `users` WHERE `id`=:userId";
		$query_params=array(":userId" => $uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		
		return $stmt->fetch();
	}
	catch(Exception $e)
	{
		return false;
	}
}

function get_completed_missions($uid, $db)
{
	try
	{
		$query="SELECT `tasks`.`title`, `tasks`.`star`, `tasks`.`desc` FROM
		            		`tasks` WHERE
		            		`tasks`.`id` IN
		            		(SELECT `completedtasks`.`tid` FROM
		            		`completedtasks` WHERE
		            		`completedtasks`.`uid`=:userId)";
		
		$query_params=array(":userId"=>$uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		
		$completedTasks=array();
		$completedTasks=$stmt->fetchAll();
		return $completedTasks;
		
	}
	catch(Exception $e)
	{
		return false;
	}
}
function check_mission_complete($uid, $tid, $db) {
	
	try {
		$query="SELECT `completedtasks`.`id` FROM `completedtasks` WHERE
		            		`completedtasks`.`uid` = :uid AND `completedtasks`.`tid` = :tid";
		
		$query_params=array(":uid"=>$uid, ":tid"=>$tid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		
		$completed=count($stmt->fetchAll());
		if ($completed >=1) return true;
		else return false;
		
	}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}

function get_available_missions($uid, $db)
{
	try {

		$query="SELECT `users`.`currentmissions` FROM `users` WHERE `id`=:uid";
		$query_params=array(":uid"=>$uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		$user = $stmt->fetch();
		
		if ($user['currentmissions'] == NULL or $user['currentmissions']=='') {
		// select missions randomly according to levelup table, implode task id's and store into currentmissions
			$level = get_current_level($uid, $db)['level'];
			
			$query="SELECT `levelup`.`1star`, `levelup`.`2star`, `levelup`.`3star` FROM `levelup` WHERE `currentlevel` = :level";
			$query_params=array(":level" => $level);
			$stmt=$db->prepare($query);
			$result2=$stmt->execute($query_params);
			$levelup = $stmt->fetch();
			
			$missions = "";
			$result1star = array();
			$result2star = array();
			$result3star = array();
			
			// get the tasks from each of the different task levels
			if ($levelup['1star'] != 0) {
				
				$query1 = "SELECT `tasks`.`id` AS `tid` FROM `tasks` WHERE (`tasks`.`star` = 1 AND `tasks`.`id` NOT IN (SELECT `completedtasks`.`tid` FROM `completedtasks` WHERE `completedtasks`.`uid`= :uid)) ORDER BY RAND() LIMIT ".$levelup['1star'];
				//$query1 = "SELECT `tasks`.`id` FROM `tasks` INNER JOIN `completedtasks` ON `tasks`.`id`!=`completedtasks`.`uid` WHERE `tasks.id
				
				$query_params=array(":uid"=>$uid);
				$stmt=$db->prepare($query1);
				$result1star=$stmt->execute($query_params);
				$result1star = $stmt->fetchAll();
			}
			if ($levelup['2star'] != 0) {
				$query2 = "SELECT `tasks`.`id` AS `tid` FROM `tasks` WHERE (`tasks`.`star` = 2 AND `tasks`.`id` NOT IN (SELECT `completedtasks`.`tid` FROM `completedtasks` WHERE `completedtasks`.`uid`= :uid)) ORDER BY RAND() LIMIT ".$levelup['2star'];
				$query_params=array(":uid"=>$uid);
				$stmt=$db->prepare($query2);
				$result2star=$stmt->execute($query_params);
				$result2star = $stmt->fetchAll();
			}
			if ($levelup['3star'] != 0) {
				$query3 = "SELECT `tasks`.`id` AS `tid` FROM `tasks` WHERE (`tasks`.`star` = 3 AND `tasks`.`id` NOT IN (SELECT `completedtasks`.`tid` FROM `completedtasks` WHERE `completedtasks`.`uid`= :uid)) ORDER BY RAND() LIMIT ".$levelup['3star'];
				$query_params=array(":uid"=>$uid);
				$stmt=$db->prepare($query3);
				$result3star=$stmt->execute($query_params);
				$result3star = $stmt->fetchAll();
			}
			
			$missions = array_merge((array)$result1star, (array)$result2star, (array)$result3star);
			// the above will give us an extremely complex multi-dimensional array, let's just get it to 
			// a single dimension
			$flattened = array();
			foreach ($missions as $key => $value) {
				foreach ($missions[$key] as $key2 => $value2) {
					$flattened[] = $value2;
				}
			}
			
			// implode the array
			$missions = implode(",", $flattened);
			
			$query="UPDATE `users` SET `currentmissions` = :missions WHERE `id` = :uid";
			$query_params=array(":missions" => $missions, ":uid"=>$uid);
			$stmt=$db->prepare($query);
			$result2=$stmt->execute($query_params);
		}
		
		// then just select the missions
		if (!isset($missions)) $missions = $user['currentmissions'];
		if ($missions == "") return "No missions available!";
		$query="SELECT * FROM `tasks` WHERE `tasks`.`id` IN (".$missions.")";
		$stmt=$db->prepare($query);
		$result2=$stmt->execute($query_params);
		$missions=$stmt->fetchAll();
		return $missions;
	}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}

function get_current_progress($uid, $db)
{
	try
	{
		$query="SELECT `progress` FROM `users` WHERE `id`=:userId";
		$query_params=array(":userId" => $uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
	
		return $stmt->fetch();
	}
	catch(Exception $e)
	{
		return false;
	}
}

function get_current_level($uid, $db)
{
	try
	{
		$query="SELECT `level` FROM `users` WHERE `id`=:userId";
		$query_params=array(":userId" => $uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
	
		return $stmt->fetch();
	}
	catch(Exception $e)
	{
		return false;
	}
}

function suggest_mission($uid, $suggestion, $db)
{
	try
	{
		$query="INSERT INTO `suggestedtasks` (`suggestion`, `suggestedBy`) VALUES (:suggestion, :uid)";
		$query_params=array(":suggestion" => $suggestion, ":uid" => $uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		return $result;
	}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}


function submit_mission($uid, $db, $tid, $fb)
{
	try
	{
		// check if the user is trying to re-submit something (cheater cheater pumpkin eater)
		if (check_mission_complete($uid, $tid, $db)) {
			return "You have already completed this mission!<br/>";
		}
		$query="INSERT INTO `completedtasks` (`uid`, `tid`,`feedback`) VALUES (:uid, :tid, :feedback)";
		$query_params=array(":uid" => $uid, ":tid" => $tid, ":feedback" => $fb);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
	
		$query="SELECT `tasks`.`star` FROM `tasks` WHERE `id` = :tid";
		$query_params=array(":tid" => $tid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		$result = $stmt->fetch();
		
		// increment current X star value in user table
		if ($result['star'] == 1) {
			$query="UPDATE `users` SET `current1star` = `current1star` + 1 WHERE `id` = :uid";
		}
		else if ($result['star'] == 2) {
			$query="UPDATE `users` SET `current2star` = `current2star` + 1 WHERE `id` = :uid";
		}
		else if ($result['star'] == 3) {
			$query="UPDATE `users` SET `current3star` = `current3star` + 1 WHERE `id` = :uid";
		}
		else { echo "Houston we have a problem"; }
		
		$query_params=array(":uid" => $uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		
		// explode currentmissions, remove the submitted tasks, then re-implode and update
		$query="SELECT `users`.`currentmissions` FROM `users` WHERE `id`=:uid";
		$query_params=array(":uid"=>$uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		$user = $stmt->fetch();
		
		$missions = explode(",",$user['currentmissions']);
		if (($key = array_search($tid, $missions)) !== false) {
			unset($missions[$key]);
		}
		$missions = implode(",", $missions);
		$query="UPDATE `users` SET `currentmissions` = :missions WHERE `id` = :uid";
		$query_params=array(":missions" => $missions, ":uid"=>$uid);
		$stmt=$db->prepare($query);
		$result2=$stmt->execute($query_params);

		return $result2;
	}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}
function get_needed_missions($level, $db) {
	try
		{
			$query="SELECT `levelup`.`1star`, `levelup`.`2star`, `levelup`.`3star` FROM `levelup` WHERE `currentlevel` = :level";
			$query_params=array(":level" => $level);
			$stmt=$db->prepare($query);
			$result2=$stmt->execute($query_params);
			$result2=$stmt->fetch();
			return $result2;
		}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}

function get_user_level_info($uid, $db) {
	try
		{
			// get information regarding leveling up from user
			$query="SELECT `users`.`level`, `users`.`current1star`, `users`.`current2star`, `users`.`current3star` FROM `users` WHERE `id` = :uid";
			$query_params=array(":uid" => $uid);
			$stmt=$db->prepare($query);
			$result1=$stmt->execute($query_params);
			$result1=$stmt->fetch();
			return $result1;
		}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}

function get_goals($uid, $db) {
	try
		{
			// get information regarding leveling up from user
			$query="SELECT `users`.`personalGoal1`, `users`.`personalGoal2`, `users`.`personalGoal3` FROM `users` WHERE `id` = :uid";
			$query_params=array(":uid" => $uid);
			$stmt=$db->prepare($query);
			$result1=$stmt->execute($query_params);
			$result1=$stmt->fetch();
			return $result1;
		}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}

function level_up($uid, $db)
{
	try
	{
		$result1 = get_user_level_info($uid, $db);
		$result2 = get_needed_missions($result1['level'], $db);	
		// time to check
		 if (($result1['current1star'] >= $result2['1star']) && 
			($result1['current2star'] >= $result2['2star'])	&& 
			($result1['current3star'] >= $result2['3star']) && 
			($result1['current1star'] + $result1['current2star'] + $result1['current3star'] >= 3)) { 
			
		// if (($result1['current1star'] + $result1['current2star'] + $result1['current3star'] >= 3)) {
			// user can level up :D
			$level = $result1['level'] + 1;
			$msg = "<br/>Yay you have leveled up! Your new level is ".$level."<br/>";
			if ($level > 10) { // user has finished Confiden
				$msg .= "<br/>You have completed Confiden!";
			}
			// reset current X level values to zero and increment level
			$query="UPDATE `users` SET `level` = :level, `current1star`=0, `current2star`=0, `current3star`=0  WHERE `id` = :uid";
			$query_params=array(":level" => $level, ":uid" => $uid);
			$stmt=$db->prepare($query);
			$result3=$stmt->execute($query_params);
		}
		else { // tell them how many missions need to still be completed 
			// get information from table		
			$msg = "<br/>To level up you need to complete a total of:<br/>";
			if ($result2['1star'] != 0) {
				$msg.= $result2['1star']." 1 star missions (You currently have ".$result1['current1star'].")<br/>";
			}
			if ($result2['2star'] != 0) {
				$msg.= $result2['2star']." 2 star missions (You currently have ".$result1['current2star'].")<br/>";
			}
			if ($result2['3star'] != 0) {
				$msg.= $result2['3star']." 3 star missions (You currently have ".$result1['current3star'].")<br/>";
			}
		}
		
		return $msg;
	}
	catch(Exception $e)
	{
		$error_msg="Failed to run query: " . $e->getMessage();
			$_SESSION["error"]=$error_msg;
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			die();
	}
}

//This is just for password validation
function validate_password($new_password, $new_password_again, $db, $uid, $mode, $old_password="")
{
	//if the user is registering
	if($mode=="register")
	{
		//Compare the new_password and new_password_again
		if($new_password!=$new_password_again)
		{
			$error_msg="Passwords don't match";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			return false;
		}

		//Check the length of the new_password_again
		if(strlen($new_password)<8)
		{
			$error_msg="Password is too short (needs to be at least 8 characters long)";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			return false;
		}

		return true;
	}
	
	//if trhe user is changing password
	else if($mode=="change" || $mode=="login")
	{
		//Compare the new_password and new_password_again
		if($new_password!=$new_password_again)
		{
			$error_msg="Passwords don't match";
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			return false;
		}
		//Check the length of the new_password
		if(strlen($new_password)<8)
		{
			//Error information is only provided to the user if he is changing the password
			if($mode=="change")
			{
				$error_msg="Password is too short (needs to be at least 8 characters long)";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
			}
			return false;
		}
		//Get the hashed password and salt stored in the database for that user id
		try{
			$query="SELECT `password`, `salt` FROM `users` WHERE `id`=:uid";
			$query_params=array(":uid"=>$uid);
			$stmt=$db->prepare($query);
			$result=$stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			$error_msg="Failed to run query: ".$ex->getMessage();
			echo json_encode(array("error"=>$error_msg, "success"=>0));
			return false;
		}

		$row=$stmt->fetch();

		//Hash the old_password concat with the salt
		for($round = 0; $round < 65537; $round++)
		{
			$old_password = hash('sha256', $old_password . $row["salt"]);
		}
		//Compare the hashed old_password and the hashed password in the database
		if($old_password!=$row["password"])
		{
			//Error information is only provided to the user if he is changing the password
			if($mode=="change")
			{
				$error_msg="Password entered is incorrent";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
			}
			return false;
		}

		//return true
		return true;
	}
	else
	{
		return false;
	}
}

function get_journal_entries($uid, $db)
{
	try
	{
		$query="SELECT `journals`.`id`, `journals`.`subject`, `journals`.`content`,`journals`.`date` FROM `journals` WHERE
		            		`journals`.`uid` = :uid";

		$query_params=array(":uid" => $uid);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		$result=$stmt->fetchAll();

		return $result;
		
	}
	catch(Exception $e)
	{
		return false;
	}
}


?>
