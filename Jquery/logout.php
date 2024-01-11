<?php
session_start(); // Make sure to start the session

// Clear all session variables
 $_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to homee.php
header("Location: index.php");
exit();
?>
