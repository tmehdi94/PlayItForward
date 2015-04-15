<?php
	include_once 'dbConnect.php';
	$error_msg = "";
if (isset($_POST['title'], $_POST['entry'], $_POST['missionId'], $_POST['userId'])) {
	print_r($_POST);

	$db->startTransaction();
	try {
		// Complete mission:
		// 1) Mission is inserted into user_completedMissions
		// 2) Journal entry is inserted into journal table
		// 3) Remove user_acceptedMissions entry
		// 4) Update experience level of the user in USER table
		$journalInsert = "INSERT INTO journal (uid, mid, saveDate, journalTitle, journalText) 
							VALUES (?,?,NOW(),?,?)";
		$uid = $_POST['userId'];
		$mid = $_POST['missionId'];
		$journalTitle = $_POST['title'];
		$journalText = $_POST['entry'];
		$db->rawQuery($journalInsert, Array($uid, $mid, $journalTitle, $journalText));
	    
	    $journalId = $db->getInsertId();   // This gets the id of the most recently inserted row

	    // Insert into completedmissions:
		$completedInsert = "INSERT INTO user_completedMissions (uid, mid, completionDate, journal_id)
		                    VALUES (?, ?, NOW(), ?)";
		$db->rawQuery($completedInsert, Array ($uid, $mid, $journalId) );

		// Remove user_acceptedMissions row:
		$db->rawQuery("DELETE FROM user_assignedMissions WHERE uid = ? AND mid = ?", Array ($uid, $mid));

		// Increase experience level of user in USER table:
		// TODO: Use Jake's formulas instead of my constant 100 XP per mission
		$db->rawQuery("UPDATE Users 
			SET experience = experience + 100
			WHERE uid = ?", Array ($uid));
		$db->commit();
		print "reached the end";

	} catch (Exception $e) {
		print "Database ERROR";
		$db->rollback();
	}
}
?>