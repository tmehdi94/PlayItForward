<?php
	include_once 'dbConnect.php';
    include_once 'includes/functions.php'; //Include EXP helper functions
    
	$message = "";
if (isset($_POST['title'], $_POST['entry'], $_POST['missionId'], $_POST['userId'])) {

	$db->startTransaction();
	try {
		// Complete mission:
		// 1) Mission is inserted into user_completedMissions
		// 2) Journal entry is inserted into journal table
		// 3) Remove user_acceptedMissions entry
		// 4) Update experience level of the user in USER table
		
		
		$uid = $_POST['userId'];
		$mid = $_POST['missionId'];
		$journalTitle = $_POST['title'];
		$journalText = $_POST['entry'];
		
		// Check if mission already completed (POST refreshed)
		$db->where("mid",$mid);
		$db->where("uid",$uid);
		$checkMission = $db->get("journal");
		
		if (!empty($checkMission)) { // mission already completed
			$message = "<div class='alert alert-danger' role='alert'>
						<strong>Errors were encountered!</strong><br/>
						You have already completed this mission!";
		}
		
		else { // all good
			
			
			$journalInsert = "INSERT INTO journal (uid, mid, saveDate, journalTitle, journalText) 
								VALUES (?,?,NOW(),?,?)";
	
			$db->rawQuery($journalInsert, Array($uid, $mid, $journalTitle, $journalText));
			
			$journalId = $db->getInsertId();   // This gets the id of the most recently inserted row
	
			// Insert into completedmissions:
			$completedInsert = "INSERT INTO user_completedMissions (uid, mid, completionDate, journal_id)
								VALUES (?, ?, NOW(), ?)";
			$db->rawQuery($completedInsert, Array ($uid, $mid, $journalId) );
	
			// Remove user_acceptedMissions row:
			$db->rawQuery("DELETE FROM user_assignedMissions WHERE uid = ? AND mid = ?", Array ($uid, $mid));
	
			// Increase experience level of user in USER table:
			
			$missionlevel = $db->rawQuery("SELECT level FROM missions WHERE mid = ?", Array ($mid)); //Get the mission level
			$userlevel = $db->rawQuery("SELECT level FROM users WHERE uid = ?", Array ($uid)); //Get the user's level
			$gainedEXP = get_reward_exp($missionlevel[0]['level'], $userlevel[0]['level']); //How much EXP should this quest reward for this user?
			
			$db->rawQuery("UPDATE users 
				SET experience = experience + ?
				WHERE uid = ?", Array ($gainedEXP, $uid));
				
			$totalexp = $db->rawQuery("SELECT experience FROM users WHERE uid = ?", Array($uid));
			$newlevel = get_level_from_exp($totalexp[0]['experience']);
			$db->rawQuery("UPDATE users SET level = ? WHERE uid = ?", Array($newlevel, $uid));
			$db->commit();
			
			$message = "<div class='alert alert-success' role='alert'>
						<strong>Congratulations!</strong><br/>
						You have completed the mission and have been rewarded <strong>$gainedEXP</strong> EXP!";
		}
 
	} catch (Exception $e) {
		print "Database ERROR";
		$db->rollback();
	}
}
?>