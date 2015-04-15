<?php
// adapted from http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
		false,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function login($username, $password, $db) {
    // Using prepared statements means that SQL injection is not possible. 

    $db->where ("username", $username);
	$user = $db->getOne("users");
	
	$salt = $user['salt'];
	$user_id = $user['uid'];
	$db_password = $user['password'];
	
	if ($db->count == 1) {
		$password = hash('sha512', $password . $salt);
		
		// If the user exists we check if the account is locked
        // from too many login attempts 
		
		if (checkbrute($user_id, $db) == true) {
               // Account is locked 
               // TO DO: Send an email to user saying their account is locked
               return false;
        } else {
		
			// Check if the password in the database matches
			// the password the user submitted.
			if ($db_password == $password) {
				// Password is correct!
				
				// XSS protection as we might print these values
				$user_id = preg_replace("/[^0-9]+/", "", $user_id);
				$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
				
				// Get the user-agent string of the user.
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				if (!isset($_SESSION)) {
					sec_session_start();
				}
				$_SESSION['uid'] = $user_id;
				$_SESSION['username'] = $username;
				$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
				
				// Login successful!
				return true;
              } else {
				// Password is not correct
                // We record this attempt in the database
                $now = time();
				$data = Array ("uid" => $user_id, "time" => $now);
				$db->insert('login_attempts', $data);
				return false;
              }
        }
	} else {
		// No user exists.
        return false;
    }
}

function checkbrute($uid, $db) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
	$db->where ("uid", $uid);
	$db->where ("time", $valid_attempts, ">");
	$db->get ("login_attempts");
	
	// If there have been more than 5 failed logins
	if ($db->count > 5) {
	    return true;
    } else {
            return false;
    }
}

function login_check($db) {
    // Check if all session variables are set 
    if (isset($_SESSION['uid'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $uid = $_SESSION['uid'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
		$db->where("uid", $uid);
		$user = $db->getOne("users");
		$password = $user['password'];

		if ($db->count == 1) {
			$login_check = hash('sha512', $password . $user_browser);
			if ($login_check == $login_string) {
				// Logged In!!!! 
				return true;
			} else {
				// Not logged in 
				return false;
				
			}
		} else {
			// Not logged in 
			return false;
		}
    } else {
		// Not logged in 
		return false;
    }
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }	
}

function navigation($currentpage, $loggedin) {
	$nav = "";
	if ($currentpage == "index") {
		$nav .= '<li class="active"><a href="index.php">Home</a></li>';
	} else {
		$nav .= '<li><a href="index.php">Home</a></li>';
	}
    
    if ($currentpage == "FAQ") {
        $nav .= '<li class="active"><a href="FAQ.php">FAQ</a></li>';
	} else {
		$nav .= '<li><a href="FAQ.php">FAQ</a></li>';
	}
    
	if ($loggedin) {
		if ($currentpage == "overview") {
			$nav .= '<li class="active"><a href="overview.php">Overview</a></li>';
		} else {
			$nav .= '<li><a href="overview.php">Overview</a></li>';
		}
        
        if ($currentpage == "missions") {
        $nav .= '<li class="active"><a href="missions.php">Missions</a></li>';
        } else {
            $nav .= '<li><a href="missions.php">Missions</a></li>';
        }
        
        if ($currentpage == "journal") {
        $nav .= '<li class="active"><a href="journal.php">Journal</a></li>';
        } else {
            $nav .= '<li><a href="journal.php">Journal</a></li>';
        }

        if ($currentpage == "preferences") {
        $nav .= '<li class="active"><a href="preferences.php">Preferences</a></li>';
        } else {
            $nav .= '<li><a href="preferences.php">Preferences</a></li>';
        }        
        
		$nav .= '<li><a href="includes/logout.php">Logout</a></li>';
        
	} else {
    
		if ($currentpage == "login") { 
			$nav .= '<li class="active"><a href="login.php">Login/Register</a></li>';
		} else {
			$nav .= '<li><a href="login.php">Login/Register</a></li>';
		}
	}

	return $nav;
}


function get_level_exp($currentlevel) { //Used as size of exp bar
    return 1000*($currentlevel+1); //Tweakable
}

function get_exp_progress($exptotal, $currentlevel) { //Exp for current level = total exp - sum of all previous levels 
    return $exptotal - ($currentlevel)*($currentlevel + 1)*500; //Tweakable
}

function get_exp_percent($exptotal, $currentlevel) {
    return 100 * get_exp_progress($exptotal, $currentlevel)/get_level_exp($currentlevel);
}

function get_reward_exp($missionlevel, $userlevel){
    $range = 2; //Tweakable
    if ($userlevel - $range > $missionlevel || $userlevel + $range < $missionlevel){
		return 0;
	}else{
		return floor(sqrt($missionlevel)*1000);
	}
}

function test_reward_exp($userlevel){ //This is only for debugging. Outputs expected exp rewards for missions
    for($x = 1; $x <= 10; $x++){
        if(get_reward_exp($x, $userlevel) == 0){
            echo "Level ".$userlevel." cannot take on level ".$x." quests<br>";
        } else {
            echo "You will receive ".get_reward_exp($x, $userlevel)." experience from completing a level ".$x." quest<br>";
        }
    }        
}

function get_level_from_exp($experience){
    return (float)floor((sqrt(.008*(float)$experience + 1) - 1)/2); //add 1 when we no longer 0 index
}

function getAssignedMissions($username, $db){
	// Get UserId:
	$user = $db->rawQuery("SELECT u.uid FROM users u WHERE u.username = ? LIMIT 1", Array ($username));
	$userId = $user[0]['uid'];
	$assignedMissions = $db->rawQuery(" SELECT u.uid, m.title, m.description FROM missions m, user_assignedmissions uam, users u WHERE m.mid = uam.mid AND uam.uid = ?", Array ($userId));
	// If < 3 missions, add more until you get to three missions
	if ($db->count <= 3) {
		assignMissions($userId, $db);
	}
	$assignedMissions = $db->rawQuery("SELECT m.mid, m.level, m.title, m.description FROM missions m, user_assignedmissions uam WHERE m.mid = uam.mid AND uam.uid = ?", Array ($userId));
	$format = '<tr>
    <td>%d</td>
    <td>%s</td>
    <td>%s</td>
    <td><p data-placement="top" data-toggle="tooltip" title="Complete Mission"><a href="#edit" data-toggle="modal" class="btn btn-primary btn-xs" data-title="Edit" data-target="#edit" data-book-id="%d" onclick="setMissionId(%d)" ><span class="glyphicon glyphicon-pencil"></span></a></p></td>
    <td><p data-placement="top" data-toggle="tooltip" title="Give Up"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
    </tr>';
	$returnString = "";
	foreach ($assignedMissions as $mission){
		$returnString .= sprintf($format, $mission['level'], $mission['title'], $mission['description'], $mission['mid'], $mission['mid']);
	}
	return $returnString;
}

// Will improve later. For now, just assign missions the user hasn't been assigned yet
// TODO: 1) Make it so completed non-repeatable missions aren't assigned
//       2) Assign missions of interesting levels related to the user's level
function assignMissions($userId, $db) {
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
				)";
		$unassignedMissions = $db->rawQuery($query, Array ($userId, $userId));
		$insertQuery = "INSERT INTO `user_assignedmissions`(`uid`, `mid`, `assignDate`) VALUES (?, ?, NOW())";
		for ($i = 0; $i < 3; $i++) {
			$insertionStatus = $db->rawQuery($insertQuery, Array ($userId, $unassignedMissions[$i]['mid']));
		}
		$db->commit();
	} catch (Exception $e) {
		print "Database error!";
		$db->rollback();
	}
}