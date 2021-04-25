<?php

session_start();

require_once('class/lib/Exception.php');
require_once('class/lib/Image.php');
require_once('class/User.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

// We know we're authenticated so get the user by the id stored in the session.

$errorMessage ='';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user = User::find($_REQUEST["id"]);
    // Check if file was received without errors
    if (isset($_REQUEST["id"]) && $_REQUEST["id"] >0) {
        
            $user->setId($_REQUEST["id"]);
            $user->delete();
            header('Location: viewUsers.php');
        
    } 
}

?>