<?php
include_once 'dbConnect.php';
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['name'], $_POST['address'], $_POST['subject'], $_POST['message'])) {
    //send the mail
    $name = $_POST['name'];
    $sender = $_POST['address'];
    $subjectline = $_POST['subject'];
    $message = $_POST['message'];
    echo $name.$sender."D:LFKJS:DLFKJ".$message;
    //Should be implemented when a valid domain is selected
    if($name != 'name' && $sender != 'address' && $subjectline != 'subject' && $message != "Message"){
        mail($sender, "Copy of message: ".$subjectline." | DO NOT RESPOND", $message); //sends a copy to desired e-mail. Will also check if e-mail entered is valid
        mail("playitforward.thuglife@gmail.com", $subjectline, $message."\n\n-".$name);
        header('Location: ../contact.php?success=1');
    }else{
    header('Location: ../contact.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo "Invalid Request";
}