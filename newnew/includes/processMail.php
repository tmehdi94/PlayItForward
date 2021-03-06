<?php
include_once 'dbConnect.php';
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['name'], $_POST['address'], $_POST['subject'], $_POST['message'], $_POST['type'])) {
    $name = $_POST['name'];
    $subjectline = $_POST['subject'];
    $message = $_POST['message'];
    $sender = $_POST['address'];
    $type = $_POST['type'];
    
    
    if (!filter_var($sender, FILTER_VALIDATE_EMAIL) === false
    && $name != 'Name' && $sender != 'Email Address' 
    && $subjectline != 'Subject' && $message != 'Message'
    && $type !=  '') { //if everything goes right
        header('Location: ../contact.php?error=1');
        mail($sender, "Copy of message: ".$subjectline." | DO NOT RESPOND", $message); //sends a copy to sender
        mail("PlayitForward.ThugLife@gmail.com", $subjectline, $message."\n\n-".$name."\t".$sender); //sends all data to site email
        header('Location: ../contact.php?success=1');
    }else{
        header('Location: ../contact.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo "Invalid Request";
}