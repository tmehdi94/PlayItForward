<?php
include_once 'dbConnect.php';
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= 'The email address you entered is not valid.';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
		if (!empty($error_msg)) {
			$error_msg.="<br/>";
		}
        $error_msg .= 'Invalid password configuration.';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
	$db->where("email",$email);
	$db->getOne("users");
	
	if ($db->count == 1) {
            // A user with this email address already exists
			if (!empty($error_msg)) {
				$error_msg.="<br/>";
			}
            $error_msg .= 'A user with this email address already exists.';
    }
	
	$db->where("username",$username);
	$db->getOne("users");
 
    if ($db->count == 1) {
            // A user with this username already exists
			if (!empty($error_msg)) {
				$error_msg.="<br/>";
			}
            $error_msg .= 'A user with this username already exists.';
    }
 
    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
		$data = Array ("username" => "$username",
               "email" => "$email",
               "password" => "$password",
			   "salt" => "$random_salt"
		);
		$id = $db->insert ('users', $data);
		if ($id) {
			header('Location: ./register_success.php');
		}
		else {
			header('Location: ../error.php?err=Registration failure: INSERT');
		}
        header('Location: ./register_success.php');
    }
}

?>