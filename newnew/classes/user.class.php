<?php
include_once 'mission.class.php';

class User
{
    // property declaration
    public $userId;
    public $username;
    public $email;
    public $password;
    public $salt;
    public $avatar;
    public $level;
    public $experience;
    
    public function __construct($p_userId, $db)
    {
        $user = $db->rawQuery("SELECT u.* FROM users u WHERE u.uid = ?", Array ($p_userId));
        if ($db->count != 1){
            print "Primary key error: Two users share the same userId";
            return;
        }
        $this->userId = $user[0]['uid'];
        $this->username = $user[0]['username'];
        $this->email = $user[0]['email'];
        $this->password = $user[0]['password'];
        $this->salt = $user[0]['salt'];
        $this->avatar = $user[0]['avatar'];
        $this->level = $user[0]['level'];
        $this->experience = $user[0]['experience'];
    }
    
    public function getAssignedMissions($db) {
        $assignedMissionsQuery = "SELECT uam.mid 
                                  FROM user_assignedmissions uam 
                                  WHERE uam.uid = ?";
        $assignedMissions = $db->rawQuery($assignedMissionsQuery, Array ($this->userId));
        // If < 3 missions, add more until you get to three missions
        if ($db->count < 3) {
            $this->assignMissions($db, 3 - $db->count);
        }
        $detailedMissionsQuery = "SELECT m.mid, m.level, m.title, m.description 
                                            FROM missions m, user_assignedmissions uam 
                                            WHERE m.mid = uam.mid AND uam.uid = ? 
                                            ORDER BY m.level ASC";
        $assignedMissions = $db->rawQuery($detailedMissionsQuery, Array ($this->userId));
        return $assignedMissions;
    }

    // Will improve later. For now, just assign missions the user hasn't been assigned yet
    // TODO: Make assignment of missions random. (Right now missions are repeated)
    private function assignMissions($db, $numDesired) {
        try {
            $db->startTransaction();
            // Finds all mission ids that are not already assigned or completed
            $query = "SELECT m.mid
                    FROM missions m
                    WHERE m.mid NOT IN
                    (
                        SELECT m.mid
                        FROM missions m, user_assignedmissions uam
                        WHERE (m.mid = uam.mid AND uam.uid = ?) 
                        UNION
                        SELECT m.mid
                        FROM missions m, user_completedmissions ucm
                        WHERE (m.mid = ucm.mid AND ucm.uid = ?) 
                          AND m.isReusable = 0
                    ) AND m.level >= ?-2 AND ?+2 >= m.level";
            $insertQuery = "INSERT INTO `user_assignedmissions`(`uid`, `mid`, `assignDate`) VALUES (?, ?, NOW())";
            for ($i = 0; $i < $numDesired; $i += 1) {
                $unassignedMissions = $db->rawQuery($query, Array ($this->userId, $this->userId, $this->level, $this->level));
                if ($db->count == 0) break;
                $toAdd = array_rand($unassignedMissions, 1);
                $insertionStatus = $db->rawQuery($insertQuery, Array ($this->userId, $unassignedMissions[$toAdd]['mid']));
            }
            $db->commit();
        } catch (Exception $e) {
            print "Database error!";
            $db->rollback();
        }
    }

    // Complete mission:
    // 1) Journal entry is inserted into journal table
    // 2) Mission is inserted into user_completedMissions
    // 3) Remove user_acceptedMissions entry
    // 4) Update experience level of the user in USER table
    // Returns experience reward for completing the mission
    public function completeMission($db, $missionId, $journalTitle, $journalText) {
        $mission = new Mission($missionId, $db);
        $db->startTransaction();
        $gainedEXP = -1;
        try {
            // TODO: Convert Taha's refresh solution to class based method:
            // // Check if mission already completed (POST refreshed)
            // $db->where("mid",$mid);
            // $db->where("uid",$uid);
            // $checkMission = $db->get("journal");
            
            // if (!empty($checkMission)) { // mission already completed
            //     $message = "<div class='alert alert-danger' role='alert'>
            //                 <strong>Errors were encountered!</strong><br/>
            //                 You have already completed this mission!";
            // }

            // 1) Insert journal entry into journal table
            $journalInsert = "INSERT INTO journal (uid, mid, saveDate, journalTitle, journalText) 
                                VALUES (?,?,NOW(),?,?)";
            $db->rawQuery($journalInsert, Array($this->userId, $missionId, $journalTitle, $journalText));
            $journalId = $db->getInsertId();   // This gets the id of the most recently inserted row
            
            // 2) Insert into completedmissions:
            $completedInsert = "INSERT INTO user_completedMissions (uid, mid, completionDate, journal_id)
                                VALUES (?, ?, NOW(), ?)";
            $db->rawQuery($completedInsert, Array ($this->userId, $missionId, $journalId) );

            // 3) Remove user_assignedMissions row:
            $db->rawQuery("DELETE FROM user_assignedMissions WHERE uid = ? AND mid = ?", Array ($this->userId, $missionId));

            // 4) Increase experience level of user in USER table:
            $gainedEXP = get_reward_exp($mission->level, $this->level);
            $this->experience = $this->experience + $gainedEXP;
            $this->level = get_level_from_exp($this->experience);
            // Update experience in database as well as in this temporary instantiation:
            $db->rawQuery("UPDATE users 
                SET experience = ?, level = ?
                WHERE uid = ?", Array ($this->experience, $this->level, $this->userId));
            $db->commit();
        } catch (Exception $e) {
            print "Database ERROR";
            $db->rollback();
        }
        return $gainedEXP;
    }

    public function getJournals($db){
        try {
            $query = "  SELECT j.journalTitle, j.journalText, j.saveDate
                        FROM journal j, users u
                        WHERE j.uid = u.uid AND
                             u.uid = ?
                        ORDER BY j.saveDate DESC";
            $journals = $db->rawQuery($query, Array($this->userId));
            return $journals;
        } catch (Exception $e) {
            print "Database error!";
        }
    }

    public function getMostRecentJournalEntry($db){
        try {
            $query = "  SELECT j.journalTitle, j.journalText, j.saveDate
                        FROM journal j, users u
                        WHERE j.uid = u.uid AND
                             u.uid = ?
                        ORDER BY j.saveDate DESC
                        LIMIT 1";
            $journal = $db->rawQuery($query, Array($this->userId));
            if ($db->count == 1){
                return $journal[0];
            } else {
                return null;
            }
        } catch (Exception $e) {
            print "Database error!";
        }
    }

    // Returns the experience reward for completing a mission of missionlevel at level userLevel
    private function get_reward_exp($missionlevel, $userlevel){
        $range = 2; //Tweakable
        if ($userlevel - $range > $missionlevel || $userlevel + $range < $missionlevel){
            return 0;
        } else {
            return floor(sqrt($missionlevel)*1000);
        }
    }

    // Maps experience amount to level.
    private function get_level_from_exp($experience){
        return (float)floor((sqrt(.008*(float)$experience + 1) - 1)/2); //add 1 when we no longer 0 index
    }
}
?>